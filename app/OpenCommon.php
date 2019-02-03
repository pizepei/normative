<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/2/3
 * Time: 16:30
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 常用开放接口
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /document/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app;
use pizepei\staging\Controller;
use pizepei\staging\Request;

class OpenCommon extends Controller
{
    /**
     * @param \pizepei\staging\Request $Request [json]
     * @return array [html]
     * @title  微信域名验证
     * @explain 微信配置时需要使用文件验证此方法可自动验证
     * @router get /MP_verify_:verify[string].txt debug:false
     * @throws \Exception
     */
    public function wx_verify(Request $Request)
    {
        return $Request->path()['verify'];
    }

}