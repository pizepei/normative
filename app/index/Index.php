<?php
/**
 * Created by PhpStorm.
 * User: 84873
 * Date: 2018/8/6
 * Time: 15:25
 */
namespace app\index;
use pizepei\staging\Request;
use pizepei\staging\Controller;
class Index extends Controller
{

    public function index()
    {
        $Request = Request::init();
//
//        var_dump($Request->input());
//        echo $Request->input(['post','dex','int']);


//        var_dump($Request);
//        echo '<hr>';
//        $Request = null;
//        var_dump($GLOBALS['Request']);

//        $Request = Request::init();
//        $Request = Request::init();
//        $Request = Request::init();
//        $Request = Request::init();
//        $Request = Request::init();
//        $Request = Request::init();
//        $Request = Request::init();

        echo '我是首页';
    }

}