<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/07/22
 * Time: 16:30
 * @title helper扩展类：该类不会实例化主要是为了方便绑定容器和适配ide，适配ide必须添加对应的@method 或者 @property
 */

namespace container\app;


use pizepei\helper\File;
/**
 * Class Helper
 * @package app
 */
class HelperContainer
{
    /**
     * 容器名称
     */
    const CONTAINER_NAME = 'Helper';
    # key 为标识  value 为类信息（请包括完整的命名空间）
    const bind = [
    ];
}