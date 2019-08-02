<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/3/1
 * Time: 15:00
 * @title 微信验证应用管理
 * @basePath /wechat/code/appManage/
 */

namespace app\wechat;


use pizepei\staging\Controller;
use pizepei\staging\Request;
use pizepei\wechat\model\OpenWechatCodeAppModel;

class CodeAppManage extends Controller
{

    /**
     * @Author 皮泽培
     * @Created 2019/8/2 10:50
     * @param Request $Request
     *   get [object] 路径参数
     * @return array [json] 定义输出返回数据
     * @title  微信验证应用列表
     * @explain 获取应用列表
     * @authGroup basics.menu.getMenu:权限分组1,basics.index.menu:权限分组2
     * @authExtend UserExtend.list:拓展权限
     * @baseAuth Resource:public
     * @throws \Exception
     * @router get list
     */
    public function appList(Request $Request)
    {

        return OpenWechatCodeAppModel::table()->add([
            'account_id'=>'0ECD12A2-8824-9843-E8C9-C33E40F360D5',
            'name'=>'我的应用',
            'remark'=>'第一个应用',
            'domain'=>'oauth.heil.top',
            'target_url'=>'http://oauth.heil.top/account/wecht-qr-target',
            'encoding_aes_key'=>Helper()::str()->str_rand(42),
            'token'=>Helper()::str()->str_rand(10),
            'app_secret'=>Helper()::str()->str_rand(32),
            'ip_white_list'=>['47.106.89.196'],
            'authorizer_appid'=>'wx3260515a4514ec94',
        ]);


    }
}