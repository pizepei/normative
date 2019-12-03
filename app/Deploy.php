<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019-12-03
 * Time: 21:47:51
 * @title 部署控制器
 * @basePath /deploy/
 * @baseAuth UserAuth:test
 * @baseAuthGroup systemDeploy:系统部署
 * @packageName 系统部署
 * @packageAuthor pizepei
 * @baseParam [$Request:pizepei\staging\Request]
 * @baseControl pizepei\deploy\src\controller\BasicsDeploy
 */
 
declare(strict_types=1);

namespace app;

use \pizepei\deploy\controller\BasicsDeploy;

class Deploy extends BasicsDeploy
{

}

    