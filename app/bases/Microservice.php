<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/10/21
 * Time: 11:28
 * @baseControl pizepei\basics\src\controller\BasicsMicroservice
 * @baseAuth
 * @title 应用端微服务管理
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /basics/microservice/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app\bases;


use pizepei\basics\controller\BasicsMicroservice;

class Microservice extends BasicsMicroservice
{

}