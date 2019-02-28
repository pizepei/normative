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


}