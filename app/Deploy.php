<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/4/22
 * Time: 14:40
 * @baseAuth DeployAuth:test
 * @title 部署控制器
 * @basePath /deploy/
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
     * @title  同步所有model的结构
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

    /**
     * @Author pizepei
     * @Created 2019/6/12 22:39
     * @param \pizepei\staging\Request $Request
     *
     * @title  删除本地配置接口
     * @explain 当接口被触发时会删除本地所有Config配置，配置会在项目下次被请求时自动请求接口生成
     * @router delete Config
     */
    public function deleteConfig(Request $Request)
    {

    }
    /**
     * @Author pizepei
     * @Created 2019/6/12 22:43
     * @param \pizepei\staging\Request $Request
     *      path [object] 路径参数
     *          path [string] 需要删除的runtime目录下的目录为空时删除runtime目录
     * @title  删除本地runtime目录下的目录
     * @explain 删除runtime目录下的目录或者runtime目录本身。配置会在项目下次被请求时自动请求接口生成runtime
     * @router delete runtime/:path[string]
     */
    public function deleteCache(Request $Request)
    {

    }




}