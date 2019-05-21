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
use authority\app\Resource;
use pizepei\staging\Controller;
use pizepei\staging\Request;
use pizepei\staging\Route;
use service\document\DocumentService;
use ZipArchive;


class Document extends Controller
{
    protected $path  = '';
    /**
     * @param \pizepei\staging\Request $Request
     *      path [object] 路径参数
     *          type [string] 路径
     * @return array [html]
     * @title  文档入口（开发助手）
     * @explain 文档入口（API文档、权限文档、公共资源文档）
     * @router get index/:type[string].html debug:true
     * @throws \Exception
     */
    public function index(Request $Request)
    {

        $type = $Request->path('type')==='index'?'document':$Request->path('type');
        return $this->view($type);
    }
    /**
     * @return array [json]
     * @title  API文档 侧边导航
     * @explain  侧边导航
     * @router get nav-list debug:true
     * @throws \Exception
     */
    public function navList()
    {
        return Route::init()->noteBlock;
    }

    /**
     * @Author pizepei
     * @Created 2019/2/12 23:01
     *
     * @param \pizepei\staging\Request $Request
     *      get [object] 路径参数
     *          father [string] 父路径
     *          index [string] 当前路径
     * @return array [json]
     * @title  获取API文档信息
     * @explain  根据点击侧边导航获取对应的获取API文档信息
     * @router get index-nav debug:true
     * @throws \Exception
     */
    public function getNav(Request $Request)
    {
        $input = $Request->input();
        $fatherInfo = Route::init()->noteBlock[$input['father']];
        $fatherInfo['index'] = $input['father'];
        $info = Route::init()->noteBlock[$input['father']]['route'][$input['index']]??null;
        if(!empty($info)){
            $info['index'] = $input['index'];
        }
        return $this->succeed([
            'fatherInfo'=>$fatherInfo,
            'info'=>$info]
        );

    }
    /**
     * @Author pizepei
     * @Created 2019/2/14 23:01
     *
     * @param \pizepei\staging\Request $Request
     *      get [object] get参数
     *          father [string required] 父路径
     *          index [string required] 当前路径
     *          type [string required] 参数类型
     * @return array [json]
     *      data [objectList] 数据
     *          field [string] 参数名字
     *          type [string] 参数数据类型
     *          fieldExplain [string] 参数说明
     *          fieldRestrain [string] 参数约束
     * @title  获取API的请求参数信息
     * @explain  根据点击侧边导航获取对应的获取API文档信息
     * @router get request-param
     * @throws \Exception
     */
    public function RequestParam(Request $Request)
    {
        $input = $Request->input();

        $info = Route::init()->noteBlock[$input['father']]['route'][$input['index']]??null;
        if(!empty($info)){
            $info['index'] = $input['index'];
        }
        if(isset($info['Param']) && !empty($info['Param'])){
            $info = $info['Param'][$input['type']]['substratum']??[];
            if(!empty($info)){

                $Document = new DocumentService;
                $infoData = $Document ->getParamInit($info);
            }
        }else{
            $info = [];
        }
        return $this->succeed($infoData??[],'获取'.$input['index'].'成功',0);
    }


    /**
     * @Author pizepei
     * @Created 2019/2/14 23:01
     *
     * @param \pizepei\staging\Request $Request
     *      get [object] get参数
     *          father [string required] 父路径
     *          index [string required] 当前路径
     *          type [string required] 参数类型
     * @return array [json]
     *      data [objectList] 数据
     *          field [string] 参数名字
     *          type [string] 参数数据类型
     *          fieldExplain [string] 参数说明
     *          fieldRestrain [string] 参数约束
     * @title  获取API的返回参数信息
     * @explain  根据点击侧边导航获取对应的获取API文档信息
     * @router get return-param debug:true
     * @throws \Exception
     */
    public function ReturnParam(Request $Request)
    {
        $input = $Request->input();
        $info = Route::init()->noteBlock[$input['father']]['route'][$input['index']]??null;
        if($info['ReturnType'] != $input['type']){
            return $this->succeed([],'获取1'.$input['index'].'成功',0);
        }
        if(!empty($info)){
            $info['index'] = $input['index'];
        }
        if(isset($info['Return']) && !empty($info['Return'])){
            $info = $info['Return']??[];
            if(!empty($info)){
                $Document = new DocumentService;
                $infoData = $Document ->getParamInit($info);
            }
        }else{
            $info = [];
        }
        return $this->succeed($infoData??[],'获取'.$input['index'].'成功',0);
    }


    /**
     * @Author pizepei
     * @Created 2019/4/25 14:01
     *
     * @param \pizepei\staging\Request $Request
     *      get [object] get参数
     *          projectId [string required] 项目id
     * @return array [json]
     *      list [objectList] 数据
     *          id [string] 权限id
     *          name [string] 权限名
     *          pid [string] 父id
     *          value [string] 参数
     *          checked [string] 选中
     *      checkedId [raw] 被选中的id
     * @title  获取权限树
     * @explain  根据点击侧边导航获取对应的获取API文档信息
     * @router get jurisdiction-list debug:true
     * @throws \Exception
     */
    public function jurisdictionList(Request $Request)
    {
        $Route = Route::init();
        return $this->succeed([
            'list'=>Resource::initJurisdictionList($Route->Permissions),
            'checkedId'=>['getMenu','409bfd433e7dd7af7d7530ad5fb7bc46'],
        ]);


    }

    /**
     * @Author 皮泽培
     * @Created 2019/5/18 17:57
     * @param Request $Request
     *   path [object] 路径参数
     *   get [object] 路径参数
     *   post [object] post参数
     *      name [string] 姓名
     *   rule [object] 数据流参数
     * @return array [json] 定义输出返回数据
     *      id [uuid] uuid
     *      name [object] 同学名字
     * @title  路由标题
     * @explain 路由功能说明
     * @authGroup basics.menu.getMenu:权限分组1,basics.index.menu:权限分组2
     * @authExtend UserExtend.list:拓展权限
     * @baseAuth Resource:public
     * @throws \Exception
     * @router post exportPhpStormSettings
     */
    public function exportPhpStormSettings(Request $Request)
    {
        if($Request->post('name') === 'settings.zip' || $Request->post('name') === 'settings')
        {
            throw new \Exception('不能为settings关键字');
        }
        $zip = new ZipArchive();
        $path = "..".DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'PhpStormSettings'.DIRECTORY_SEPARATOR;
        $route = $path.$Request->post('name');
        $file = $path.'settings.zip';
        /**
         *
         * 怎么下载？
         */
        if ($zip->open($file) === true){

            $mcw = $zip->extractTo($route);//解压到$route这个目录中

            $zip->close();
        }
        return self::fileTemplates_includes_PHP_Function_Doc_Comment['content'];
    }

    const fileTemplates_includes_PHP_Function_Doc_Comment=[
        'content'=><<<ABC
这里可以是任合内容
我是历的苛夺基
本原则叶落归根在运
输费艰难田￥￥&……
ABC
    ];
}