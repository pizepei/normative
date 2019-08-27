<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/1/15
 * Time: 11:28
 * @baseControl pizepei\basics\src\controller\BasicsConsole
 * @baseAuth
 * @title 后台首页控制台
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /home/console/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app\bases;

use pizepei\basics\controller\BasicsConsole;

class Console extends BasicsConsole
{

}