<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/3/26
 * Time: 9:53
 * @title 账号体系
 */

namespace service\basics\account;


use model\basics\account\AccountMilestoneModel;
use model\basics\account\AccountModel;
use pizepei\func\Func;
use pizepei\service\encryption\PasswordHash;
use pizepei\staging\Controller;

class AccountService
{
    /**
     * 注册账号
     * @param array                       $config
     * @param array                       $Request  邮箱、手机
     * @param \pizepei\staging\Controller $Controller
     * @return array
     * @throws \Exception
     */
    public function register(array $config,array $Request,Controller $Controller)
    {
        /**
         * 实例化密码类
         */
        $PasswordHash = new PasswordHash();
        /**
         * 判断密码格式
         */
        if(empty($PasswordHash->password_match($config['password_regular'][0],$Request['password']))){
            return $Controller->error($Request['password'],$config['password_regular'][1]);
        }
        /**
         * 查询是否有对应的账号存在
         */
        $AccountModel = AccountModel::table();

        if($AccountModel->where(['phone'=>$Request['phone']])->fetch(['id'])){ return$Controller->error($Request['phone'],'手机号码已经注册');}
        if($AccountModel->where(['email'=>$Request['email']])->fetch(['id'])){ return$Controller->error($Request['email'],'email已经注册');}

        //获取密码hash
        $password_hash = $PasswordHash->password_hash($Request['password'],$config['algo'],$config['options']);
        if(!empty($password_hash)){
            $Data['password_hash'] = $password_hash;
        }
        $Data['number'] = 'common_'.Func::M('str')::int_rand($config['number_count']);//编号固定开头的账号编码(common,tourist,app,appAdmin,appSuperAdmin,Administrators)
        $Data['phone'] = $Request['phone'];
        $Data['email'] = $Request['email'];
        $Data['logon_token_salt'] = Func::M('str')::str_rand($config['user_logon_token_salt_count']);//建议user_logon_token_salt
        $AccountData = AccountModel::table()->add($Data);
        if(is_array($AccountData)){
            $id = array_keys($AccountData)[0]??null;
        }

        /**
         * 注册账号
         */
        return $Controller->succeed($AccountData);

    }

    /**
     * @Author pizepei
     * @Created 2019/3/30 21:28
     *
     * @param array                       $config 配置
     * @param array                       $Request 请求参数
     * @param array                       $userData 会员数据
     * @param \pizepei\staging\Controller $Controller 控制器
     * @return array|bool|string
     */
    public function logon(array $config,array $Request,array $userData,Controller $Controller)
    {
        /**
         * 注意为了保证安全
         *      登录需要使用的logon_token_salt 解密进行如下处理
         *          1、实际进行操作是是使用项目全局的logon_token_salt拼接用户logon_token_salt
         *          2、在强制用户下线时：项目全局强制可通过修改项目logon_token_salt，单一用户相关用户logon_token_salt
         *          3、由于是jwt方式用户logon_token_salt要注意缓存存在和数据安全
         *
         */

        /**
         *
         */
        /**
         * 实例化密码类
         * 验证是否密码正确
         */
        $PasswordHash = new PasswordHash();

        $hashResult = $PasswordHash->password_verify($Request['password'],$userData['password_hash'],$config['algo'],$config['options']);

        if(!$hashResult['result']){
            return $Controller->error($Request,'账号或者密码错误');
        }

        if($hashResult['newHash']){
            /**
             * 密码加密参数有修改
             */
            $AccountModel = AccountModel::table()->insert([ 'id'=>$userData['id'],'password_hash'=>$hashResult['newHash']]);
            if($AccountModel === 1){
                /**
                 * 写入里程碑事件
                 */
                if(empty(AccountMilestoneModel::table()->add(['account_id'=>$userData['id'],'message'=> ['registerData'=>[ 'id'=>$userData['id'],'password_hash'=>$hashResult['newHash']],'requestId'=>__REQUEST_ID__], 'type'=>7,]))){
                    return $Controller->error('系统错误','系统错误','L002');
                }
            }
        }
        /**
         *
         */
        return $hashResult;
    }


    /**
     * @Author pizepei
     * @Created 2019/3/30 21:35
     *
     * @param array                       $config 配置
     * @param array                       $Request 请求数据
     * @param array                       $userData 用户数据
     * @param \pizepei\staging\Controller $Controller 控制器类
     * @return array
     *
     * @title  修改密码
     * @explain 修改密码（注意配置）
     */
    public function changePassword(array $config,array $Request,array $userData,Controller $Controller)
    {
        /**
         * 实例化密码类
         */
        $PasswordHash = new PasswordHash();
        /**
         * 判断密码格式
         */
        if(empty($PasswordHash->password_match($config['password_regular'][0],$Request['password']))){
            return $Controller->error($Request['password'],$config['password_regular'][1]);
        }
        /**
         * 判断密码要求
         *      如：上次修改  是否是原密码
         */

        /**
         *生成新密码 获取密码hash
         */
        $password_hash = $PasswordHash->password_hash($Request['password'],$config['algo'],$config['options']);
        if(empty($password_hash)){
            return $Controller->error('系统错误','系统错误','L003');
        }
        /**
         * 修改并且写入里程碑事件update
         */
        $updateData = ['password_hash'=>$password_hash,'version'=>$userData['version']+1];
        $AccountModel = AccountModel::table()->where(['version'=>$userData['version']])->update($updateData);
        //$AccountModel = AccountModel::table()->where(['version'=>$userData['version']])->insert([ 'id'=>$userData['id'],'password_hash'=>$password_hash,'version'=>$userData['version']+1]);
        if($AccountModel == 1){
            /**
             * 写入里程碑事件
             */
            if(empty(AccountMilestoneModel::table()->add(['account_id'=>$userData['id'],'message'=> ['registerData'=>[ 'id'=>$userData['id'],'password_hash'=>$password_hash,'version'=>$userData['version']+1],'requestId'=>__REQUEST_ID__], 'type'=>7,]))){
                return $Controller->error('系统错误','系统错误','L002');
            }
        }else{
            return $Controller->succeed($AccountModel,'修改错误');

        }
        return $Controller->succeed($AccountModel,'修改成功');


    }
    /**
     * 修改
     * logon_token_salt
     */
}