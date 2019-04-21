<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/4/14 13:34
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 服务示例
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /service/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app\index;


use pizepei\service\time\Time;
use pizepei\staging\Request;

class Service
{
    /**
     * @Author pizepei
     * @Created 2019/4/14 13:37
     *
     * @param \pizepei\staging\Request $Request
     *    path [object] 路径参数
     *         date [string] 时间
     * @return array [json]
     * @title  方法标题（一般是方法的简称）
     * @explain 一般是方法功能说明、逻辑说明、注意事项等。
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     *
     * @router get calendar/lunar/:date[string]
     */
    public function calendar(Request $Request)
    {

        return Time::solar(date('Y'),date('m'),date('d'),date('H'));

        //Request::init()
        //Request
    }
}