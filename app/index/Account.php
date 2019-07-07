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

use pizepei\staging\Controller;
use pizepei\staging\Request;
use service\basics\account\AccountService;

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
        //Db::table()->insert();
        return AccountThirdPartyModel::table()->add(['status'=>3,'type'=>'WeChat','openid'=>'77779676','account_id'=>[Db::getUuid()]]);
    }


    /**
     * @Author pizepei
     * @Created 2019/7/5 22:40
     * @param \pizepei\staging\Request $Request
     *      post [object]
     *          phone [string number] 手机号码
     *          code [string required] 手机验证码
     *          email [string email] 邮箱
     *          password [string required] 密码
     *          repass [string required] 确认密码
     *          nickname [string required] 昵称
     *          agreement [string required] 是否同意协议
     * @title  注册接口
     * @explain 获注册接口
     * @throws \Exception
     * @return array [json]
     *      data [raw]
     * @router post account
     */
    public function registerAccount(Request $Request)
    {
        $Service = new AccountService();
        $res = $Service->register(\Config::ACCOUNT,$Request->post());
        if($res['result'])
        {
            return $this->succeed('',$res['msg']);
        }else{
            return $this->error('',$res['msg']);
        }
    }


}