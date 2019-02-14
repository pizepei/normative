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
        return ['data'=>[
            'fatherInfo'=>$fatherInfo,
            'info'=>$info]
        ];
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
     * @title  获取一个API 的参数信息
     * @explain  根据点击侧边导航获取对应的获取API文档信息
     * @router get request-param debug:true
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

                $Document = new \service\document\Document;
                $infoData = $Document ->getParamInit($info);
            }

        }else{
            $info = [];
        }


        return [
            'code'=>0,
            'msg'=>'获取'.$input['index'].'成功',
            'count'=>count($info),
            'data'=>$infoData??[]
        ];
    }

    public function recursiveParam($info,&$infoData,&$i)
    {
        if(!empty($info)){
            foreach($info as $key=>$value){
                $infoData[$i]['field'] = $key;
                $infoData[$i]['fieldExplain'] = $value['fieldExplain'];//字段说明
                $infoData[$i]['type'] = $value['fieldRestrain'][0];//字段说明
                $infoData[$i]['fieldRestrain'] = implode(' | ',$value['fieldRestrain']);//约束
                $i++;
            }
        }
    }
}