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
         * 查询是否有对应的账号存在
         */
        $AccountModel = AccountModel::table();

        if($AccountModel->where(['phone'=>$Request['phone']])->fetch(['id'])){ return$Controller->error($Request['phone'],'手机号码已经注册');}
        if($AccountModel->where(['email'=>$Request['email']])->fetch(['id'])){ return$Controller->error($Request['email'],'email已经注册');}

        /**
         * 实例化密码类
         */
        $PasswordHash = new PasswordHash();
        $password_hash = $PasswordHash->password_hash($Request['password']);//获取密码hash
        if(!empty($password_hash)){
            $Data['password_hash'] = $password_hash;
        }
        $Data['number'] = 'common_'.Func::M('str')::int_rand($config['number_count']);//编号固定开头的账号编码(common,tourist,app,appAdmin,appSuperAdmin,Administrators)
        $Data['phone'] = $Request['phone'];
        $Data['email'] = $Request['email'];
        $Data['logon_token_salt'] = Func::M('str')::str_rand(21);//建议
        $AccountData = AccountModel::table()->add($Data);
        if(is_array($AccountData)){
            $id = array_keys($AccountData)[0]??null;
            //$id = $AccountData[''];
        }
        /**
         * 写入里程碑事件
         */
        AccountMilestoneModel::table()->add(
            [
                'account_id'=>$id,
                'message'=>
                    ['registerData'=>$Data],
                'type'=>1
            ]
        );
        //AccountMilestoneModel;

        /**
         * 注册账号
         */
        return $Controller->succeed($AccountData);

    }

    /**
     * 登录
     */
    public function logon()
    {


    }
}