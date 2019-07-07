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



use pizepei\deploy\DeployService;
use pizepei\deploy\LocalDeployServic;
use pizepei\func\Func;
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

     * @title  删除本地配置接口
     * @explain 当接口被触发时会删除本地所有Config配置，配置会在项目下次被请求时自动请求接口生成
     * @router delete Config
     */
    public function deleteConfig(Request $Request)
    {

        Func::M('file')::deldir();

    }

    /**
     * @Author pizepei
     * @Created 2019/6/12 22:43
     * @param \pizepei\staging\Request $Request
     *      raw [object] 路径
     *          path [string] 需要删除的runtime目录下的目录为空时删除runtime目录
     * @title  删除本地runtime目录下的目录
     * @explain 删除runtime目录下的目录或者runtime目录本身。配置会在项目下次被请求时自动请求接口生成runtime
     *
     * @return array [json]
     * @throws \Exception
     * @router delete runtime
     */
    public function deleteCache(Request $Request)
    {
         $path = $Request->raw('path');
        /**
         * 判断是否有方法的目录
         * 如 ../   ./
         */
        if(strpos($path,'..'.DIRECTORY_SEPARATOR) === 0 || strpos($path,'..'.DIRECTORY_SEPARATOR) > 0 ){
            return $this->error([],'非法目录');
        }
        if(strpos($path,'.'.DIRECTORY_SEPARATOR) === 0 || strpos($path,'.'.DIRECTORY_SEPARATOR) > 0 ){
            return $this->error([],'非法目录');
        }
        if($path ==='runtime')
        {
            $path = '..'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR;
        }else{
            $path = '..'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR;
        }
        Func::M('file')::deldir($path);
    }

    /**
     * @Author pizepei
     * @Created 2019/6/16 22:43
     * @param \pizepei\staging\Request $Request
     *      post [raw] 路径参数
     *          object_kind [string] 操作对象性质 push tag
     *          event_name [string] 事件名
     *          after [string] 上一个git
     *          before [string] 当前git
     *          ref [string] 参考 refs/tags/1.01  或者 refs/heads/master
     *          checkout_sha [string]
     *          message [string]
     *          user_id [int] 事件触发者id
     *          user_name [string] 事件触发者用户名
     *          user_email [string] 事件触发者 邮箱
     *          user_avatar [string] 事件触发者 头像
     *          project_id [int] 事件对象ID
     *          project [raw] 对象详情
     *              name [string] 项目名
     *              description [string] 项目描述
     *              ssh_url [string] ssh_url
     *              default_branch [string]
     *              path_with_namespace [string]
     *          commits [raw] 提交信息
     *          total_commits_count [int] 提交数量
     *          repository [raw] 代码仓库
     * @return array [json]
     *      data [raw]
     * @throws \Exception
     * @title  gitlab System hooks
     * @explain System hooks
     * @router post gitlabSystemHooks
     */
    public function gitlabSystemHooks(Request $Request)
    {
        file_put_contents('txt1.txt',file_get_contents("php://input"));

        if(!isset($_SERVER['HTTP_X_GITLAB_TOKEN']) || $_SERVER['HTTP_X_GITLAB_TOKEN']!== \Deploy::GITLAB['HTTP_X_GITLAB_TOKEN']  )
        {
            return $this->error('非法请求');
        }
        $SystemHooksData = json_decode(file_get_contents("php://input"),true);
        $DeployService = new DeployService();
        return $DeployService->gitlabSystemHooks($SystemHooksData);
    }

    /**
     * @Author pizepei
     * @Created 2019/6/16 22:43
     * @param \pizepei\staging\Request $Request
     * @return array [json]
     *    data [raw]
     * @throws \Exception
     * @title  gitlab System hooks
     * @explain System hooks
     * @router get test
     */
    public function test(Request $Request)
    {
        /**
         * MicroServiceConfigCenterModel
         */
        //$MicroServiceConfigCenter = MicroServiceConfigCenterModel::table();
        //$InitializeConfig = new InitializeConfig();
        //$Config = $InitializeConfig->get_config_const('..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.__APP__.DIRECTORY_SEPARATOR);
        //$dbtabase = $InitializeConfig->get_dbtabase_const('..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.__APP__.DIRECTORY_SEPARATOR);
        //$error_log = $InitializeConfig->get_error_log_const('..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.__APP__.DIRECTORY_SEPARATOR);
        //
        //
        //$deploy = $InitializeConfig->get_deploy_const('..'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR);
        //$data = [
        //    'name'              =>'测试',
        //    'appid'             =>$deploy['INITIALIZE']['appid'],
        //    'service_group'     =>'develop',
        //    'ip_white_list'     =>['47.106.89.196'],
        //    'config'            =>$Config,
        //    'dbtabase'          =>$dbtabase,
        //    'error_or_log'      =>$error_log,
        //    'deploy'            =>$deploy,
        //    'domain'            =>$_SERVER['HTTP_HOST'],
        //];
        //
        //return $MicroServiceConfigCenter->add($data);
        $LocalDeployServic = new LocalDeployServic();
        $data=[
            'ProcurementType'=>'ErrorOrLogConfig',//获取类型   Config.php  Dbtabase.php  ErrorOrLogConfig.php
            'appid'=>\Deploy::INITIALIZE['appid'],//项目标识
            'domain'=>$_SERVER['HTTP_HOST'],//当前域名
            'time'=>time(),//
        ];
        return $LocalDeployServic->getConfigCenter($data);

    }

    /**
     * @Author pizepei
     * @Created 2019/7/5 22:40
     *
     * @param \pizepei\staging\Request $Request
     *      post [object] 路径参数
     *          nonce [int required] 随机数
     *          timestamp [string required]  时间戳
     *          signature [string required] 签名
     *          encrypt_msg [string required] 密文
     *          domain [string required] 域名
     *      path [object] 路径参数
     *          appid [string] 项目appid
     * @title  获取项目配置接口
     * @explain 获取项目配置接口（基础配置）。
     * @throws \Exception
     * @return array [json]
     *      data [raw]
     * @router post service-config/:appid[string]
     */
    public function serviceConfig(Request $Request)
    {

        $LocalDeploy = new LocalDeployServic();
        return $LocalDeploy->initConfigCenter($Request->post(),$Request->path('appid'));
    }

}