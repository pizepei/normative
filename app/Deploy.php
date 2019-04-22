<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/4/22
 * Time: 14:40
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 部署控制器
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /document/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */
namespace app;


use pizepei\model\db\TableAlterLogModel;
use pizepei\staging\Controller;
use pizepei\staging\Request;

class Deploy extends Controller
{
    /**
     * @param \pizepei\staging\Request $Request
     *      path [object] 路径参数
     *           domain [string] 域名
     * @return array [json]
     * @title  同步所有model不结构
     * @explain 建议生产发布新版本时执行
     * @router get cliDbInitStructure
     * @throws \Exception
     */
    public function cliDbInitStructure(Request $Request)
    {
        /**
         * 命令行没事 saas
         */
        $model = TableAlterLogModel::table();
        return $model->initStructure();
    }
}