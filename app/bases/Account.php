<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/1/15
 * Time: 11:28
 * @baseControl pizepei\basics\src\controller\BasicsAccount
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 账号表
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /account/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */
namespace app\bases;

use pizepei\basics\controller\BasicsAccount;

class Account extends BasicsAccount
{

}