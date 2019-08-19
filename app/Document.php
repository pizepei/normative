<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/2/3
 * Time: 16:24
 * @baseControl pizepei\deploy\src\controller\BasicsDeploy
 * @baseAuth UserAuth:public
 * @title 文档控制器
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /document/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app;
use pizepei\deploy\controller\BasicsDeploy;

class Document extends BasicsDeploy
{

}