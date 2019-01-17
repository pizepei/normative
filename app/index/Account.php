<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/1/15
 * Time: 11:28
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 账号表
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /account/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app\index;

use model\account\AccountModel;
use model\account\AccountThirdParty;
use pizepei\staging\Controller;

class Account extends Controller
{

    /**
     * @return array [object]
     * @title  账号获取列表
     * @explain 注意所有 path 路由都使用 正则表达式为唯一凭证 所以 / 路由只能有一个
     * @router get index
     */
    public function index()
    {
        return AccountThirdParty::table()->add([['status'=>3,'type'=>'WeChat']]);

        return AccountModel::table()->fetchAll();
    }


}