<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/4/22
 * Time: 14:40
 * @title 部署控制器
 * @basePath /deploy/
 * @baseAuth DeployAuth:test
 * @packageName 系统部署
 * @packageAuthor pizepei
 * @basePermissions systemDeploy:系统部署
 * @baseControl pizepei\deploy\src\controller\BasicsDeploy
 */
namespace app;

use pizepei\deploy\controller\BasicsDeploy;

class Deploy extends BasicsDeploy
{


}