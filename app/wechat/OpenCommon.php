<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/3/1
 * Time: 15:00
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 微信开放平台
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /wechat/common/open/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app\wechat;


use model\wechat\PreAuthCodeModel;
use pizepei\model\redis\Redis;
use pizepei\staging\Controller;
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
        $redis = new Redis();
        Open::init(\Config::OPEN_WECHAT_CONFIG,$redis->redis);
        $data = Open::getAccreditUrl($Request->path('id'),'http://oauth.heil.top/open/receive/authorizer_access?uuid='.$Request->path('id'));
        PreAuthCodeModel::table()->add(['url'=>$data['url'],'PreAuthCode'=>$data['pre_auth_code'],'uuid'=>$Request->path('id')]);
        echo '<a href="'.$data['url'].'">去授权</a>';
    }
}