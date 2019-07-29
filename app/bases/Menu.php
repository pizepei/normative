<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/4/23 22:33
 * @baseAuth UserAuth:test
 * @title 菜单相关控制器
 * @authGroup 权限组列表（在显示权限时继续分组）资源
 * @basePath /admin/menu/
 */

namespace app\bases;


use model\basics\backstage\AdminMenuModel;
use model\basics\backstage\MenuModel;
use pizepei\staging\Controller;
use pizepei\staging\Request;

class Menu extends Controller
{
    /**
     * @Author pizepei
     * @Created 2019/4/23 22:35
     *
     * @param \pizepei\staging\Request $Request
     * @return array [json]
     *      data [objectList]
     *          name [string] 一级菜单名称（与视图的文件夹名称和路由路径对应）
     *          title [string] 一级菜单标题
     *          icon [string] 一级菜单图标样式
     *          spread [bool] 是否默认展子菜单
     *          list [objectList] 二级
     *              name [string] 二级菜单名称（与视图的文件夹名称和路由路径对应）
     *              title [string] 二级菜单标题
     *              icon [string] 二级菜单图标样式
     *              spread [bool] 是否默认展子菜单
     *              list [objectList] 三级
     *                  name [string] 三级菜单名称
     *                  title [string] 三级菜单标题
     *                  icon [string] 三级菜单图标样式
     * @title  获取菜单列表
     * @explain 获取菜单列表（权限不同内容不同）
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     * @authGroup basics.menu.getMenu:获取后台菜单1,basics.index.menu:获取首页导航2,system.admin.getAdmin:获取首页导航3,system.admin.getAdmin:获取首页导航4
     * @authExtend UserExtend.list:删除账号操作
     * @baseAuth UserAuth:test
     * @router get menu-list
     * @throws \Exception
     */
    public function index(Request $Request)
    {
        AdminMenuModel::table()->fetchAll();
        return $this->succeed([
            [
                "name"=>"component",//一级菜单名称（与视图的文件夹名称和路由路径对应）
                'title'=>'工作台',//一级菜单标题
                'icon'=>"layui-icon-home",//一级菜单图标样式
                "spread"=>true,//是否默认展子菜单（1.0.0-beta9 新增）
                'list'=>[[
                    "name"=> "grid", //二级菜单名称（与视图的文件夹名称和路由路径对应）
                    'title'=>'导航',//二级菜单标题
                    'jump'=>'/',//自定义一级菜单路由地址，默认按照 name 解析。一旦设置，将优先按照 jump 设定的路由跳转
                    'list'=>null,
                ]]
            ],
            [
            'title'=>'微信应用',
            'icon'=>"layui-icon-home",
                "name"=>"wechat",//一级菜单名称（与视图的文件夹名称和路由路径对应）
                'list'=>[
                    [
                        "name"=> "Tencent", //二级菜单名称（与视图的文件夹名称和路由路径对应）
                        'title'=>'微信公众号管理',//二级菜单标题
                        'list'=>[
                                    [
                                    "name"=> "lsit", //二级菜单名称（与视图的文件夹名称和路由路径对应）
                                    'title'=>'公众号列表',//二级菜单标题
                                    'jump'=>'/',//自定义一级菜单路由地址，默认按照 name 解析。一旦设置，将优先按照 jump 设定的路由跳转
                                    ],
                                ]
                    ],
                    [
                        "name"=> "codeAppManage", //二级菜单名称（与视图的文件夹名称和路由路径对应）
                        'title'=>'微信验证应用管理',//二级菜单标题
                        'list'=>[
                                [
                                "name"=> "applsit", //二级菜单名称（与视图的文件夹名称和路由路径对应）
                                'title'=>'导航',//二级菜单标题
                                'jump'=>'/',//自定义一级菜单路由地址，默认按照 name 解析。一旦设置，将优先按照 jump 设定的路由跳转
                                ],
                        ]
                    ]
                ]
        ]
        ]);

    }

    /**
     * @Author pizepei
     * @Created 2019/4/23 23:02
     * @param \pizepei\staging\Request $Request
     * @return array [json]
     *      data [object]
     *          username [string]
     *          sex [string]
     *          role [int]
     * @title  用户信息
     * @explain 简单用户信息
     * @authGroup basics.index.user:获取后台菜单
     * @router get session
     */
    public function session(Request $Request)
    {
        $data = [
            "username"=> "pizepei", "sex"=>"男", "role"=> 1
        ];
        return $this->succeed($data);
    }
    /**
     * @Author pizepei
     * @Created 2019/4/23 23:02
     * @param \pizepei\staging\Request $Request
     * @return array [json]
     *     data [object]
     *      newmsg [int] 新信息
     * @title  用户信息
     * @explain 简单用户信息
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     * @authGroup basics.index.message:控制台新信息
     * @router get message/new
     */
    public function messageNew(Request $Request)
    {
        $data = [
            "newmsg"=>  3
        ];
        return $this->succeed($data);
    }

}