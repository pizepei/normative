<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/4/23 22:33
 * @baseAuth UserAuth:test
 * @title 微信验证码app管理
 * @basePath /wechat-code-app/manage/
 */

namespace app\wechatCodeApp;


use pizepei\staging\Controller;
use pizepei\staging\Request;

class AppManage extends Controller
{
    /**
     * @Author 皮泽培
     * @Created 2019/7/29 15:53
     * @param Request $Request
     *      post [object] post参数
     * @return array [json] 定义输出返回数据
     * @title  添加应用
     * @explain 添加一个验证码应用
     * @authGroup basics.menu.getMenu:权限分组1,basics.index.menu:权限分组2
     * @authExtend UserExtend.list:拓展权限
     * @baseAuth Resource:public
     * @throws \Exception
     * @router post app
     */
    public function add(Request $Request)
    {
        # 应用名称 名字方便用户区分
        # 应用标识 唯一的（可做appid） 自动生成
        # ip白名单 获取验证码时验证
        # 应用域名 域名等待审核
        # 应用说明 应用的说明
        # 使用的公众号
    }
}