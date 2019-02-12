<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/2/3
 * Time: 16:24
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 文档控制器
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /document/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app;
use pizepei\staging\Controller;
use pizepei\staging\Request;
use pizepei\staging\Route;


class Document extends Controller
{
    protected $path  = '';
    /**
     * @return array [html]
     * @title  文档入口（开发助手）
     * @explain 文档入口（API文档、权限文档、公共资源文档）
     * @router get index debug:true
     * @throws \Exception
     */
    public function index()
    {
        $this->view('Document');
    }

    /**
     * @return array [json]
     * @title  API文档 侧边导航
     * @explain  侧边导航
     * @router get nav debug:true
     * @throws \Exception
     */
    public function nav()
    {
        return Route::init()->noteBlock;
    }


}