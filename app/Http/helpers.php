<?php


    /**
     * Return a success response
     *
     * @return Response
     */
    function success($message, $redirectUrl, $record=null)
    {
        if($record){
            if ( in_array('api', Request::segments())) {//for api
                return [
                    'success' => true, 
                    'version-code'=>Config::get('app.version-code'), 
                    'whats-new'=>Config::get('app.whats-new'), 
                    'minimum-version-code'=>Config::get('app.minimum-version-code'), 
                    'minimum-whats-new'=>Config::get('app.minimum-whats-new'), 
                    'message' => $message, 
                    'record' => $record, 
                ];
            }
            return Redirect::to($redirectUrl)->withInput()->withSuccess($message);
        }
        if ( in_array('api', Request::segments())) {//for api
            return ['success' => true, 'message' => $message];
        }
        return Redirect::to($redirectUrl)->withInput()->withSuccess($message);
    }

    /**
     * Return an error response
     *
     * @return Response
     */

    function error($message, $redirectUrl=null, $message2=null, $key=null, $route_id=null)
    {
        if ( in_array('api', Request::segments())) {//for api
            
            $response = ['success' => false, 'message' => $message];

            if(isset($key)){
                $response['key'] = $key;
            }

            return $response;
        }

        if($message2){
            $message .= '<br/>'.$message2; 
        }

        if($route_id){
            return Redirect::route($redirectUrl, $route_id)->withInput()->withError($message);
        }

        if($redirectUrl){
            return Redirect::to($redirectUrl)->withInput()->withError($message);
        }
        return $message;
    }

    /**
     * Return validation errors
     *
     * @return Response
     */
    function validation($validator, $redirectUrl)
    {
        if ( in_array('api', Request::segments())) {//for api

            $array = $validator->messages()->toArray();
            // return $array;

            // new version:
            $key = array_keys($array)[0];
            $message = array_values($array)[0][0];
            return  error($message, $redirectUrl, null, $key);

            // old version:
            $output = [];
            foreach ($array as $key=>$message){
                $output[$key]= $message[0];
            };
            return ['success' => false, 'errors' => $output];
        }
        return Redirect::to($redirectUrl)->withInput()->withErrors($validator);
    }

    /**
     * Return a html response
     *
     * @return Response
     */
    function html($view)
    {
        if ( in_array('api', Request::segments())) {//for api
            return View::make('partials.'.$view.'-content');
        }
        return View::make($view);
    }

    function cached($record, $method, $param=null)
    {
        $key = get_class($record)."-$record->id-$method";
        // if(Cache::has($key)){
        //     return Cache::get($key);
        // }
        $value = $record->$method($param);

        Cache::forever($key, $value);
        return $value;

    }

    function cachedIndex($record, $string)
    {
        $key = get_class($record)."-$record->id-$string";
        if(Cache::has($key)){
            return Cache::get($key);
        }
        $value = $record->$string;

        Cache::forever($key, $value);
        return $value;

    }

    function recache($record, $method, $param=null)
    {
        $key = get_class($record)."-$record->id-$method";
        $value = $record->$method($param);
        Cache::forever($key, $value);
    }

    function recacheIndex($record, $string)
    {
        $key = get_class($record)."-$record->id-$string";
        $value = $record->$string;
        Cache::forever($key, $value);
    }

    function toastr()
    {
        $types = ['success', 'warning', 'info', 'error', 'msg'];
        foreach ($types as $type):
            if (Session::get($type)):
                $msg = Session::get($type);
                
                if(is_array(json_decode($msg,true))):
                    $msg = implode('', $msg->all(':message<br/>'));
                endif;
                if ($type == 'danger') $type = 'error';
                Session::put('toastr.level', $type);
                Session::put('toastr.message', $msg);
            endif;
        endforeach;

        if ($errors = Request::session()->get('errors')):
            $msg = '';
            foreach ($errors->all() as $error):
                $msg .= $error.'<br/>';
            endforeach;
            
            Session::put('toastr.level', 'error');
            Session::put('toastr.message', $msg);
        endif;

    }
    function report($tracker, $exception=null, $subject='ShopOfficer Exceptions'){

        // save message
        // @todo

        // fetch team
        $recipients = Config::get('app.devs');
        $dev = $recipients[0]; 

        // whatsapp/slack team 
        try {
        }
        catch (Exception $exception){       
        }

        // sms message
        try {
            (new SMS)->send($dev['phone'], 'team.report', [substr($tracker, 0, 160)]);
            $message = 'Successfully sent sms!';
        }
        catch (Exception $exception){
            $message = 'Failed to send sms!'.$tracker;
        }
        
        // email team
        try {
            $data = [
                'body' => $tracker.'<br/>'.'<br/>'.$exception,
                'name' => $dev['name'],
                'email' => $dev['email'],
            ];
            Mail::send('emails.simple', $data, function($message) use ($dev, $subject) {
                $message->to([$dev['email'] => $dev['name']]);
                $message->subject($subject);
            });
            $message .= '<br/> Successfully sent mail!';
            return $message;
        }
        catch (Exception $exception){       
            $message .= '<br/> Failed to send mail!'.$tracker;
            return $message;
        }

    }
    
    function imager($str)
    {
        if ($str && filter_var($str, FILTER_VALIDATE_URL) === FALSE) { // string is not empty and is a not a url
           return Config::get('app.url').$str;
        }
        return $str;
    }

    function uploadImage($record, $field) {

        $request = new \Illuminate\Http\Request;

        if($request->hasFile($field)) {
            $file = $request->file($field);
            $destinationPath = '/uploads/' . $record->getTable() . '/' . $field.'/'.$record->id.'/';
            $filename = str_random(6) . '_' . $file->getClientOriginalName();
            $uploadSuccess = $file->move(public_path() . $destinationPath, $filename);
            return $destinationPath.$filename;
        }
        elseif($request->get($field)) { // possible base64 upload
            $data = explode(',', $request->get($field));
            $decoded = base64_decode($data[1]); 

            $path = '/uploads/'.$record->getTable().'/'.$field.'/'.$record->id.'/';
            $apath = public_path().$path;
            $filename = time().'.png';
            $filename_path = $apath.$filename;

            $folder = File::makeDirectory($apath, 493, true, true);
            if (File::isDirectory($apath))
            {
                $bytes_written = File::put($filename_path, $decoded);
                if ($bytes_written != false)
                {
                    return $path.$filename;
                }
            }
        }
        else{
            // return ''; // dont return null
            return $record[$field]; // allow updates if they worked only
        }
    }

    function getUpload($record, $field, $placeholder=null) {
        $table = $record->getTable();
        $id = $record->id;
        $name = $record->$field;

        if ($name):
            return $name;
        endif;
        if ($placeholder):
            return $placeholder;
        endif;
        
        return $name; // allowing blank images

        $name = "no_$field.png";
        return tempImage($table, $field);
    }

    function tempImage($table, $field) {
        return asset("/assets/img/$table/$field/no_$field.png");
    }

    function lorem($length) { //not called/used for stories
        $str = 'Lorem ipsum pretium mollitia praesentium malesuada fames';
        $str .= 'beatae viverra molestias ultricies donec enim Purus ad reprehenderit conubia malesuada a corrupti';
        $str .= 'commodo neque feugiat harum nibh ';
        $str .= 'velit conubia. Ipsam reiciendis. Diam phasellus ';
        $str .= 'ullam mus ducimus accusamus tempor a ac phasellus aliquip, ';
        $str .= 'sapien wisi leo augue iste dui. Consequat ante Et. Volutpat sem ea elementum tempus dolorum labore autem, ';
        $str .= 'purus iste lacinia eros dolores ut eros anim reprehenderit curabitur accusamus imperdiet repudiandae, ';
        $str .= 'blandit. Eos scelerisque, explicabo facilisi architecto wisi iure, ';
        $str .= 'debitis in mauris natus minus quis nullam. Odio, impedit ';
        $str .= 'curabitur arcu Pharetra minus. Aperiam. Amet sint cupidatat repudiandae aspernatur deleniti felis.';
        $str .= 'Distinctio vehicula. Eaque aute a odit Natus eos quasi natus pellentesque ducimus.';
        $str .= 'Doloremque inventore eligendi velit, ';
        $str .= 'tellus malesuada deleniti luctus nec laborum fugiat mauris earum commodo, ';
        $str .= 'magnis lorem proin suspendisse. Aenean. Laudantium praesent. Nostrud Vehicula reprehenderit ';
        $str .= 'ante ante iaculis faucibus provident class sint etiam anim etiam quae vulputate autem, ';
        $str .= 'totam scelerisque iste pariatur rhoncus, ';
        $str .= 'minus accusantium quos. Molestiae aliqua occaecat pellentesque sapiente exercitationem';
        $str .= 'minima dictumst. Wisi donec repellat voluptas lacinia iaculis, commodi, dolorem ';
        $str .= 'litora illum, tortor eu. Debitis exercitationem laudantium viverra, accumsan netus ut veniam ';
        $str .= 'sollicitudin repellat, modi incidunt ipsa, molestias ';
        $str .= 'earum habitasse, morbi voluptatibus interdum lacus Officia.';
        $str .= 'Nonummy. Perferendis officia. Wisi potenti suspendisse, ';
        $str .= 'leo massa esse duis. Orci architecto odit mus dicta metus nulla voluptas potenti exercitationem';
        $str .= 'quis hendrerit minim ac reprehenderit Inceptos. Molestiae possimus at, ';
        $str .= 'metus explicabo pretium conubia assumenda. Platea occaecat, ';
        $str .= 'pulvinar facilisi. Officiis unde Tenetur ';
        $str .= 'lorem tortor ratione. Aute placeat. Molestiae eleifend, ';
        $str .= 'quidem feugiat, ';
        $str .= 'magna ultricies. Adipisci aperiam imperdiet a ';
        $str .= 'quas itaque Ornare aliquet nostra accumsan, ';
        $str .= 'per diam. Ac, ';
        $str .= 'fames nemo laudantium. Architecto fugit nemo. Deserunt Dolor dignissim. Occaecat illo natus tempore.';
        $str .= 'Beatae occaecati tristique vehicula. Laboris dolorem quaerat occaecat ';
        $str .= 'neque quae debitis incidunt ';
        $str .= 'fuga Incidunt do porro tenetur tenetur, ';
        $str .= 'nisl nascetur animi hymenaeos.';
        $words = explode(" ", $str);
        // return $words;
        // $count = count($words);
        // $shuffled = array_push($shuffled, $words[array_rand($words)]);
        shuffle($words);
        $set = array_splice($words, 0, $length);
        $set = implode(' ', $set);
        $sexy = preg_replace_callback('/([.!?])\s*(\w)/', function ($matches) {
            return strtoupper($matches[1] . ' ' . $matches[2]);
        }, ucfirst(strtolower($set)));
        return $sexy;
    }

    /*
      |--------------------------------------------------------------------------
      | Edit Rights
      |--------------------------------------------------------------------------
      |
     */

    function canEdit($record) {
        if (!Auth::check()) {
            return false;
        }
        if (All::getCreator($record) == Auth::getUser()->id || Auth::getUser()->hasAccess('admin')) {
            return true;
        } else {
            return false;
        }
    }

    function getPlatform()
    {
        $ua = $_SERVER['HTTP_USER_AGENT'];

        if(strpos($ua, 'MSIE') !== FALSE)
            $name = 'Internet explorer';
        elseif(strpos($ua, 'Trident') !== FALSE) //For Supporting IE 11
        $name = 'Internet explorer';
        elseif(strpos($ua, 'Firefox') !== FALSE)
            $name = 'Mozilla Firefox';
        elseif(strpos($ua, 'Chrome') !== FALSE)
            $name = 'Google Chrome';
        elseif(strpos($ua, 'Opera Mini') !== FALSE)
            $name = "Opera Mini";
        elseif(strpos($ua, 'Opera') !== FALSE)
            $name = "Opera";
        elseif(strpos($ua, 'Safari') !== FALSE)
            $name = "Safari";
        else
            $name = 'Something else';

        
        $ua = strtolower($ua); 

        // What version? 
        if (preg_match('/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/', $ua, $matches)) { 
            $version = $matches[1]; 
        } 
        else { 
            $version = 'unknown'; 
        } 

        // Running on what platform? 
        if (preg_match('/linux/', $ua)) { 
            $platform = 'linux'; 
        } 
        elseif (preg_match('/macintosh|mac os x/', $ua)) { 
            $platform = 'osx'; 
        } 
        elseif (preg_match('/windows|win32/', $ua)) { 
            $platform = 'windows'; 
        } 
        else { 
            $platform = 'unrecognized'; 
        } 

        return [
            'browser'   => $name, 
            'version'   => $version, 
            'platform'  => $platform, 
            'user_agent' => $ua 
        ];
    }
