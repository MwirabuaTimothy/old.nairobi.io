<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Request;

/**
 * Class FrontendController
 * @package App\Http\Controllers
 */
class FrontendController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {

        return view('frontend.index');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function macros()
    {
        return view('frontend.macros');
    }

    public function home()
    {
        javascript()->put([
            'test' => 'it works!',
        ]);

        return view('frontend.home');
    }

    public function getHome()
    {
        return Redirect::to('/');
    }

    public function getTraffic(){


        return View::make('admin.traffic');
    }

    public function getUsersOnline() {
       $count = 0;

       $handle = opendir(session_save_path());
       if ($handle == false) return -1;

       while (($file = readdir($handle)) != false) {
           if (preg_match("/[^0-^9]+/", $file)) $count++;
       }
       closedir($handle);

       // return $count;
       return View::make('admin.traffic', compact('count'));
    }

    public function contact(Request $request){

        $input = $request->all();
        return $input;

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'body' => 'required|min:10',
        ];
        // return nl2br(e($input['body']));
        $input['body'] = nl2br(e($input['body'])); // include new lines

        // Validate the inputs
        $validator = Validator::make($input, $rules);

        // Check if the form validates with success
        if ($validator->passes()) {

            // Send the email
            try {
                Mail::send('emails.simple', $input, function($message) use ($input) {
                    $message->subject('Contact Form From Nairobi IO - ' .$input['name']);
                    $message->replyTo([$input['email'] => $input['name']]);
                    $message->to(['info@shopofficer.com' => 'ShopOfficer Support']);
                    $message->setBody($input['body']);
                });
                
            } catch (Exception $exception) {

                report('Err e '.$input['email'].' '.__CLASS__.'@'.__FUNCTION__.':'.__LINE__, $exception);

                $message = 'Failed to send mail! Please retry later.'; 
                return error($message, null, route('home'));
            }

            $success = 'Email has been sent! <br/>Kindly wait for response.';
            // return $success;
            return success($success, route('home'));
        } 
        else {

            $messages = $validator->messages();
            // return $messages;
            
            return validator($validator, route('home'));

        } 
    }
}
