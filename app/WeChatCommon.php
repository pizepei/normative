<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/2/27
 * Time: 17:19
 * @baseControl pizepei\wechat\src\controller\BasicsWeChatCommon
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 微信相关基础接口
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /wechat/common/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */
namespace app;

use pizepei\wechat\controller\BasicsWeChatCommon;

class WeChatCommon extends BasicsWeChatCommon
{

    /**
     * 微信开放平台域名验证
     * @var string
     */
    public $openWeixin = '96aa892bea31c23d07a7721ba21bb283';

}