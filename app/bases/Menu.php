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
use service\basics\MenuService;

class Menu extends Controller
{
    /**
     * @Author pizepei
     * @Created 2019/4/23 22:35
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
    public function index()
    {
        return $this->succeed((new  MenuService())->getAdminMenu());

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