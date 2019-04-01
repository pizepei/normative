<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/2/3
 * Time: 16:30
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 常用开放接口
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /open/common/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app;
use pizepei\staging\Controller;
use pizepei\staging\Request;

class OpenCommon extends Controller
{

    /**
     * @param \pizepei\staging\Request $Request [xml]
     *      path [object] 路径参数
     *      post [object]
     * @return array [json]
     * @title  文件上传
     * @explain 文件上传（公开的但是会判断上传域名）
     * @router post files-upload
     * @throws \Exception
     */
    public function openMessage(Request $Request)
    {
        /**
         * 获取当前域名
         */
        $HOST = $_SERVER['HTTP_HOST'];

        /**
         * 处理文件
         */

        foreach($_FILES as $key=>$value){





        }




        /**
         * 获取文件大小
         */


        /**
         * 获取文件类型
         */


        /**
         * 拼接文件
         */

        var_dump( $_SERVER['HTTP_HOST'] );
        var_dump($_FILES);

        return $Request->input('','raw');
    }


}