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


use pizepei\config\JsonWebTokenConfig;
use pizepei\model\cache\Cache;
use pizepei\service\jwt\JsonWebToken;
use pizepei\staging\Route;
use model\Test;
class Dome
{

    /**
     * @param  $Request
     *      user [int] id
     * @return array [object]
     *      user [int] 用户id
     * @title  / 路由的应用
     * @explain 注意所有 path 路由都使用 正则表达式为唯一凭证 所以 / 路由只能有一个
     * @router get /:user[string]/index
     */
    public function index($Request)
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




}