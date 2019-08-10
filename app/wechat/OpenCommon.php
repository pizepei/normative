<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/3/1
 * Time: 15:00
 * @baseAuth UserAuth:test
 * @title 微信开放平台
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /wechat/official/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app\wechat;


use pizepei\model\redis\Redis;
use pizepei\staging\Controller;
use pizepei\staging\Request;
use pizepei\wechat\model\OpenAuthorizerUserInfoModel;
use pizepei\wechat\model\PreAuthCodeModel;
use pizepei\wechat\service\Config;
use pizepei\wechat\service\Open;

class OpenCommon extends Controller
{
    /**
     * @param \pizepei\staging\Request $Request [json]
     *      path [object] 路径参数
     *          id [uuid] 获取的微信域名切割参数
     * @return array [html]
     *
     * @title   获取授权连接（授权管理）
     *
     * @explain 通过uuid获取授权连接
     *
     * @router get receive/accreditUrl/:id[uuid]
     * @throws \Exception
     */
    public function getAccreditUrl($Request)
    {
        $Config = new Config(Redis::init());
        Open::init($Config->getOpenConfig(),Redis::init());
        $data = Open::getAccreditUrl($Request->path('id'),'http://oauth.heil.top/open/receive/authorizer_access?uuid='.$Request->path('id'));
        PreAuthCodeModel::table()->add(['url'=>$data['url'],'PreAuthCode'=>$data['pre_auth_code'],'uuid'=>$Request->path('id')]);
        return  '<a href="'.$data['url'].'">去授权</a>';
    }
    /**
     * @param \pizepei\staging\Request $Request [json]
     *      path [object] 路径参数
     * @return array [json]
     *      data [objectList]
     *          id [uuid] id
     *          component_appid [string] 第三方平台id
     *          nick_name [string] 公众号昵称
     *          head_img [string] 公众号头像
     *          service_type_info [raw] 授权方公众号类型，0代表订阅号，1代表由历史老帐号升级后的订阅号，2代表服务号
     *          verify_type_info [raw] 授权方认证类型，-1代表未认证，0代表微信认证，1代表新浪微博认证，2代表腾讯微博认证，3代表已资质认证通过但还未通过名称认证，4代表已资质认证通过、还未通过名称认证，但通过了新浪微博认证，5代表已资质认证通过、还未通过名称认证，但通过了腾讯微博认证
     *          user_name [string] 授权方公众号的原始ID
     *          principal_name [string] 公众号的主体名称
     *          alias [string] 授权方公众号所设置的微信号，可能为空
     *          business_info [raw] 用以了解以下功能的开通状况（0代表未开通，1代表已开通）： open_store:是否开通微信门店功能 open_scan:是否开通微信扫商品功能 open_pay:是否开通微信支付功能 open_card:是否开通微信卡券功能 open_shake:是否开通微信摇一摇功能
     *          qrcode_url [string] 二维码图片的URL，开发者最好自行也进行保存
     *          signature [string] 帐号介绍
     *          authorizer_appid [string] appid
     *          func_info [raw] 公众号授权给开发者的权限集列表
     *          status [string] 授权状态
     *
     * @title  公众号链接
     * @explain 公众号列表
     * @router get list
     * @throws \Exception
     */
    public function wechatList(Request $Request)
    {
        return  $this->succeed(OpenAuthorizerUserInfoModel::table()->fetchAll());
    }




    /**
     * @param \pizepei\staging\Request $Request [json]
     *      path [object] 路径参数
     *          id [string] 获取的微信域名切割参数
     * @return array [json]
     *
     * @title   获取授权连接（授权管理）
     *
     * @explain 通过uuid获取授权连接
     *
     * @router get receive/access_token/:appid[string]
     * @throws \Exception
     */
    public function access_token($Request)
    {

        var_dump(Redis::init()->info());
        /**
         * 通过appid获取
         */
        $AuthorizerUser = OpenAuthorizerUserInfoModel::table()->where(['authorizer_appid'=>$Request->path('appid')])->fetch();
        $AccessToken = new AccessToken(\Config::OPEN_WECHAT_CONFIG,Redis::init());
        return ['access_token'=>$AccessToken->access_token($Request->path('appid'),$AuthorizerUser['authorizer_refresh_token'],true)];
    }



}