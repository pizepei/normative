<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/10/15
 * Time: 11:28
 * @baseControl  pizepei\basics\src\controller\BasicsHome
 * @baseAuth
 * @title 首页控制器
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /home/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app\bases;

use pizepei\basics\controller\BasicsHome;

class Home extends BasicsHome
{

}