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

use model\basics\account\AccountModel;
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
    /**
     * @Author pizepei
     * @Created 2019/3/23 16:23
     *
     * @param \pizepei\staging\Request $Request
     *      post [object] post
     *          phone [int number] 手机号码
     *          password [string required] 密码
     *          code [string required] 验证码
     *          codeFA [string] 2FA双因子认证code
     * @return array [json]
     *      data [object] 数据
     *          result [raw] 结果
     *          access_token [string] access_token
     * @throws \Exception
     * @title  登录验证
     * @explain 登录验证
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     * @router post logon
     */
    public function logon(Request $Request)
    {
        /**
         * 图形验证码系统
         */

        /**
         * 查询账号是否存在（可能会是邮箱  或者用户名）
         * 用户编码 为用户唯一标准     不同的用户编码  可以是同一个手机号码、或者邮箱   ？
         */
        $Account = AccountModel::table()
            ->where(['phone'=>$Request->post('phone')])
            ->fetch();
        if(empty($Account)){
            return $this->error($Request->post('phone'),'用户名或密码错误');
        }
        $AccountService = new AccountService();

        $result =  $AccountService->logon(\Config::ACCOUNT,$Request->post(),$Account,$this);
        if(isset($result['jwtArray']['str']) && $result['jwtArray']){
            return $this->succeed([
                'result'=>$result,
                'access_token'=>$result['jwtArray']['str']
            ],'登录成功');
        }
        return $result;
    }
    /**
     * @Author pizepei
     * @Created 2019/3/30 21:33
     *
     * @param \pizepei\staging\Request $Request
     *      post [object] post
     *          phone [int number] 手机号码
     *          password [string required] 密码
     *          repass [string required] 确认密码
     *          code [string required] 验证码
     * @return array [json]
     *
     * @title  修改密码
     * @explain 通过手机验证码修改密码
     * @authTiny 修改密码
     * @throws \Exception
     * @router put password
     */
    public function changePassword(Request $Request)
    {
        $Account = AccountModel::table()
            ->where(['phone'=>$Request->post('phone')])
            ->replaceField('fetch',['type','status']);
        if(empty($Account)){
            $this->error($Request->post(),'用户不存在');
        }
        $AccountService = new AccountService();
        return $AccountService->changePassword(\Config::ACCOUNT,$Request->post(),$Account,$this);
    }
    /**
     * @Author pizepei
     * @Created 2019/3/30 21:33
     *
     * @param \pizepei\staging\Request $Request
     *      post [object] post
     *          phone [int number] 手机号码
     *          password [string required] 密码
     *          repass [string required] 确认密码
     *          code [string required] 短信验证码
     * @return array [json]
     * @title  短信验证码结果验证
     * @explain 验证结果并且返回一个唯一的参数以进行后面的配置
     * @throws \Exception
     * @router post smsCodeVerification
     */
    public function smsCodeVerification(Request $Request)
    {
        return $this->succeed('','成功');
    }
}