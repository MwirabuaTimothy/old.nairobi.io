<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Access\User\User;
use App\Language;
use App\Tour;
use DB;

class TestsController extends Controller
{
    /**
     * @return mixed
     */
    public function getIndex()
    {
        // return  array_merge([0=>'Please select one category'], \App\Category::lists('name', 'id'));
        // return User::find(1);
        // return Language::find(1);
        // return Language::find(1)->users;
        // return User::find(1)->languages;
        // return Language::all();
        return Tour::all();
        // return \App\DB::table('user_languages')->get();
        // return DB::table('user_languages')->get();
        // return date('now')->format('d M Y');
        return date('d M Y');
        // return \App\Carbon::now()->format('d M Y');
        // $group->members()->attach(1);
        return [$group->members->contains(1)];
        
        // return [$group->memberRequests(8)->first()];
        return $group->mentorRequests(8) ? 'y' : 'n';

        return $group->mentors;
        return $group->creator;
        // return $group;
        $user = auth()->user();
        return [$user->groups->contains($group->id)];
        
        $tags = \App\Tag::find([rand(0,5),rand(0,5),rand(0,5),rand(0,5)]);
        return $tags;
        $group = \App\Group::find(8);
        return $group->tagz();
        $cats = \App\Category::lists('name', 'id');
        return  array_merge([0=>'Please select one category'], $cats->toArray());
        // return $cats;
        return \App\Category::lists('name', 'id');
    }

    public function getName()
    {
        return app_name();
    }
    public function getPath()
    {
        return app_path();
    }
    public function getSession($var = null)
    {
        if ($var == null) return 'Check tests/session/your-variable';
        if (session($var)) return session($var);
        return $var . ' is empty';
    }
    public function getSessionAdd($var = null)
    {
        if ($var == null) return 'Add something at tests/session-add/your-variable';
        session()->put($var, 'some content');
        if (session($var)) return session($var);
        return $var . ' is empty';
    }
    public function getSessionRemove($var = null)
    {
        if ($var == null) return 'Remove something at tests/session-remove/your-variable';
        if (session($var)) return session()->remove($var);
        return $var . ' is empty';
    }
    public function getTypes()
    {
        $types = ['success', 'warning', 'info', 'danger', 'message'];
        $msg = '';
        foreach ($types as $type):
                $msg .= $type.'<br/>';
        endforeach;
        echo $msg;
    }
}
