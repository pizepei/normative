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
use pizepei\model\cache\Cache;
use pizepei\staging\Route;

class Index extends Controller
{

    public function index()
    {
        $Request = Request::init();
//        var_dump($Request->input());
//        echo $Request->input(['post','dex','int']);

        $Request = Request::init();
        /**
         * url
         */
        $Request->setUrl('/test',['a'=>'b','b'=>'c']);
        /**
         * 重定向
         */
        $Request->Redirect($Request->setUrl('/test',['a'=>'b','b'=>'c']));
        echo '我是首页';
    }

    public function test()
    {



       echo  dirname(__FILE__).DIRECTORY_SEPARATOR;





        /**
         * 路由类
         */
        $Route = Route::init();
        /**
         * 请求类
         */
//        var_dump($dsdsds);
//        $Request = Request::init();
//        return ['code'=>001,'msg'=>'比如这样','data'=>['获取请求控制器'=>$Route->controller,'获取请求控制器方法'=>$Route->method]];
//        return $Request->input('a');
    }


    /**
     * 数据库测试
     */
    public function db(){


        /**
         * 添加查询
         */
        $mode = \pizepei\model\db\IpWhite::table('user');
        $where['ip'] = ['LIKE','%5'];
//        $where['status|appid'] = 0;
        $eco =  $mode->field(['ip','id'])->where($where)->forceIndex('id')->fetchAll();
        $eco =  $mode->field(['ip','id'])->where($where)->forceIndex('id')->fetch();
        return ['data'=>$eco];
////echo '您好';
////var_dump(pizepei\config\Dbtabase::DBTABASE);
////Func::M('file')::createDir('bbc/dd/');
////var_dump(pizepei\model\cache\Cache::set('public',pizepei\config\Dbtabase::DBTABASE,15,'db'));
//
//var_dump(pizepei\model\cache\Cache::get('public','db'));
//
////pizepei\model\cache\Cache::set('PPX',pizepei\config\Dbtabase::DBTABASE);
//
//Db::table('config')->showCreateTableCache();

////var_dump(Db::table('user')->get(4));
//
////$where['appid'] = ['LIKE','%5'];
//
//$where['ip'] = ['EQ','19.55.55.55'];
//
////$where['status|appid'] = 0;
//$mode = IpWhite::table('user');
//$eco =  $mode->field(['id','ip'=>'appID'])->where($where)->forceIndex('id')->fetchAll();
//var_dump($eco);
//echo $mode->sql;
//echo '<br>';
//
//var_dump($mode->sqllog);
//var_dump($mode->bindValuelog);
//echo '<hr>';
//$where = null;
//$where['id'] = 2;
//$eco =  $mode->field(['id'])->where($where)->forceIndex('id')->fetchAll();
//var_dump($eco);
//
//echo $mode->sql;
//var_dump($mode->sqllog);
//var_dump($mode->bindValuelog);
//echo '<hr>';

//        echo '</pre>';

    }

    /**
     *缓存
     */
    public function Cache()
    {

        echo filemtime('qqwry.dat');



        //var_dump(pizepei\model\cache\Cache::get('public','db'));
//        Cache::get('public','db');

    }
}