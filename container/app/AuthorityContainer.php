<?php


namespace Container\app;

use authority\app\controller\DeployAuth;
use authority\app\controller\MicroserviceAuth;
use authority\app\controller\UserAuth;

/**
 * Class Helper
 * @package container
 * @method  DeployAuth                  DeployAuth() 部署权限控制器
 * @method  UserAuth                    UserAuth() 用户权限控制器
 * @method  MicroserviceAuth            MicroserviceAuth() 用户权限控制器
 */
class AuthorityContainer
{
    /**
     * 容器名称
     */
    const CONTAINER_NAME = 'Authority';

    # key 为标识  value 为类信息（请包括完整的命名空间）
    const bind = [
        'DeployAuth'=>DeployAuth::class,//部署权限控制器
        'UserAuth'=>UserAuth::class,//用户权限控制器
        'MicroserviceAuth'=>MicroserviceAuth::class,//微服务资源路由
    ];
}