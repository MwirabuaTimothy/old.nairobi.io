<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Access\User\User;

class TestsController extends Controller
{
    /**
     * @return mixed
     */
    public function getIndex()
    {

        // return time();
        return microtime(true)*100;
        return date('d M Y');
        // return date('now')->format('d M Y');

        $tags = \App\Tag::find([rand(0, 5), rand(0, 5), rand(0, 5), rand(0, 5)]);
        return $tags;
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
        if ($var == null) {
            return 'Check tests/session/your-variable';
        }

        if (session($var)) {
            return session($var);
        }

        return $var . ' is empty';
    }
    public function getSessionAdd($var = null)
    {
        if ($var == null) {
            return 'Add something at tests/session-add/your-variable';
        }

        session()->put($var, 'some content');
        if (session($var)) {
            return session($var);
        }

        return $var . ' is empty';
    }
    public function getSessionRemove($var = null)
    {
        if ($var == null) {
            return 'Remove something at tests/session-remove/your-variable';
        }

        if (session($var)) {
            return session()->remove($var);
        }

        return $var . ' is empty';
    }
    public function getTypes()
    {
        $types = ['success', 'warning', 'info', 'danger', 'message'];
        $msg = '';
        foreach ($types as $type):
            $msg .= $type . '<br/>';
        endforeach;
        echo $msg;
    }
}
