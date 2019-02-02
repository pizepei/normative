<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2018/8/6
 * Time: 15:25
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 简单的dome
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /dome/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app\index;


use config\app\SetConfig;
use model\TerminalInfoModel;
use pizepei\config\JsonWebTokenConfig;
use pizepei\func\Func;
use pizepei\model\cache\Cache;
use pizepei\model\db\Db;
use pizepei\service\jwt\JsonWebToken;
use pizepei\service\sms\Sms;
use pizepei\staging\Request;
use pizepei\staging\Route;
use pizepei\terminalInfo\TerminalInfo;

class Dome
{

    /**
     * @return array [object]
     * @title  / 路由的应用
     * @explain 注意所有 path 路由都使用 正则表达式为唯一凭证 所以 / 路由只能有一个
     * @router get /index.html
     */
    public function index()
    {
        //var_dump(require(__INIT__['index-view']));
        //var_dump(file_get_contents(__INIT__['index-view']));
        //echo file_get_contents(__INIT__['index-view']);
        require(__INIT__['index-view']);
    }

    /**
     * @param \pizepei\staging\Request $Request
     *      get [object] 路径参数
     *           id [string] path_id
     *           name [string] path_id
     * @return array [object]
     * @title  路由的应用
     * @explain 注意所有 path 路由都使用 正则表达式为唯一凭证 所以 / 路由只能有一个
     * @router cli /client/:id[string]/:name[string]
     * @throws \Exception
     */
    public function client( Request $Request)
    {
        $terminalInfo = TerminalInfo::getArowserPro();
        /**
         * 存储经纬度信息
         */
        $IpInfo = $terminalInfo['IpInfo'];
        $data = @array_merge($IpInfo,$terminalInfo);
        if (isset($data['point'])){
            $data['point'] = ['GeomFromText','POINT('.$data['point']['x'].' '.$data['point']['y'].')'];
        }
        $data['user_agent'] =  $_SERVER['HTTP_USER_AGENT'];
        $TerminalInfo = TerminalInfoModel::table();
        return ['msg'=>'Hello World！','location'=>$TerminalInfo->insert([$data,$data,$data],false),'path'=>$Request->path(),'input'=>$Request->input()];
    }



    /**
     * @param \pizepei\staging\Request $Request
     *      get [object] 路径参数
     *           id [string] path_id
     *           name [string] path_id
     * @return array [object]
     * @title  命令行cli模式
     * @explain 命令行cli模式运行方式  php index_cli.php --route /dome/cli/001/pizpe
     * @router cli cli/:id[string]/:name[string]
     * @throws \Exception
     */
    public function cli( Request $Request)
    {
        $terminalInfo = TerminalInfo::getArowserPro();
        /**
         * 存储经纬度信息
         */
        $IpInfo = $terminalInfo['IpInfo'];
        $data = @array_merge($IpInfo,$terminalInfo);
        if (isset($data['point'])){
            $data['point'] = ['GeomFromText','POINT('.$data['point']['x'].' '.$data['point']['y'].')'];
        }
        $data['user_agent'] =  $_SERVER['HTTP_USER_AGENT'];
        $TerminalInfo = TerminalInfoModel::table();
        return ['msg'=>'Hello World！','location'=>$TerminalInfo->insert([$data,$data,$data],false),'path'=>$Request->path(),'input'=>$Request->input()];
    }


    /**
     * @return array [object]
     * @title  路由的应用
     * @explain 获取当前请求id
     * @router get request
     * @throws \Exception
     */
    public function Request()
    {
        var_dump(\Config::API_CONFIG);
        SetConfig::API_CONFIG;

        return __REQUEST_ID__;
    }
    /**
     * @param  $Request
     *      path [object] 路径参数
     *           user [int] path_id
     * @return array [object]
     *      user [int] 用户id
     * @title  / 路由的应用
     * @explain 注意所有 path 路由都使用 正则表达式为唯一凭证 所以 / 路由只能有一个
     * @router get /dd:user[int]/index.txt
     */
    public function path($Request)
    {
        $id = $Request->path('user');
        return $id;
    }
    /**
     * @title 获取路由信息
     * @explain 路由对象在框架初始化时就实例化了，同时该对象一直保留
     *              在框架控制器、模型等框架初始化后的所有地方都可直接使用 Route::init()获取到该对象
     * @router get index
     */
    public function getRoute()
    {
        $Route = Route::init();
        return [
            'controller'=>$Route->controller,//控制器
            'module'=>$Route->module,//模块
            'method'=>$Route->method,//控制器方法
            'atPath'=>$Route->atPath,//路径
            'atRoute'=>$Route->atRoute,//路由
        ];
    }
    /**
     * @title  缓存
     * @router get cache
     */
    public function cache()
    {
        /**
         * 设置缓存
         */
        $result = Cache::set(['test','data'],['ddd','ddd']);
        /**
         * 读取缓存
         */
        $data = Cache::get(['test','data']);
        return ['result'=>$result,'cache'=>$data];
    }

    /**
     * @title db 操作->add
     * @explain 框架模型操作-.增加数据操作
     * @router get db
     */
    public function dbAdd()
    {
        //\pizepei\model\db\Test::table();
        Test::table();

        //var_dump(Test::table());

    }

    /**
     * @Author: pizepei
     * @Created: 2018/12/2 22:44
     *
     * @return array
     * @throws \Exception
     *
     * @title  方法标题（一般是方法的简称）
     * @explain 一般是方法功能说明、逻辑说明、注意事项等。
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     * @authGroup 权限分组对应文件头部 @authGroup
     *
     * @router get jwt
     */
    public function jwt()
    {
        //Test::table();
        //return ['jwt'];
        //JsonWebToken::Payload
        $JsonWebToken = new JsonWebToken([],'common');
        return $JsonWebToken->setJWT();
    }

    /**
     * @Author: pizepei
     * @Created: 2019/01/2 22:44
     *
     * @return array
     * @throws \Exception
     *
     * @title  获取uuid
     * @explain 一般是方法功能说明、逻辑说明、注意事项等。
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     * @authGroup 权限分组对应文件头部 @authGroup
     *
     * @router get uuid
     */
    public function uuid()
    {

        //Db::table();

        $Uuid = Uuid::table();
        $Uuid->insert(
            [
                ['Build'=>['33333','dddss']],
                ['Build'=>['dddd','44444']],
            ]
        );
        //$Uuid->get('b9dd397d-05fc-a87c-3290-4b7760f19542');



        //return ['db-uuid'=>Db::getUuid(),'func'=>Func::M('str')::getUuid(),'insert'=>$Uuid->insert(
        //    [
        //        ['Build'=>['dddd2','dddss']],
        //        ['Build'=>['dddd','dddss2']],
        //    ]
        //)];
    }

    /**
     * @Author: pizepei
     * @Created: 2019/01/2 22:44
     *
     * @return array
     * @throws \Exception
     *
     * @title  获取随机数字
     * @explain 一般是方法功能说明、逻辑说明、注意事项等。
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     * @authGroup 权限分组对应文件头部 @authGroup
     *
     * @router get int-rand
     */
    public function int_rand()
    {
        return Func::M('str')::int_rand(10);

    }
    /**
     * @Author: pizepei
     * @Created: 2019/01/2 22:44
     *
     * @return array
     * @throws \Exception
     *
     * @title  获取随机字符串
     * @explain 一般是方法功能说明、逻辑说明、注意事项等。
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     * @authGroup 权限分组对应文件头部 @authGroup
     *
     * @router get str-rand
     */
    public function str_rand()
    {
        return Func::M('str')::str_rand(10);
    }

    /**
     * @Author: pizepei
     * @Created: 2019/1/21 23:08
     *
     * @throws \Exception
     * @return array [object]
     * @title  账号获取列表
     * @explain
     * @router get sms
     */
    public function sms()
    {
        $Sms = new Sms();
        return $Sms->SendCode('register',13266579753);
    }
}