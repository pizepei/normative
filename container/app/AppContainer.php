<?php
/**
 * @title APP 子容器定义（只是为了适配IDE）
 * @methodstatic static 类   方法   [可选不填写就是非static方法] File[返回数据类型 可以是类 或者其他的比如self当前来]  test(string $question) [函数详情]
 */

namespace container\app;


use pizepei\staging\App;
/**
 * Class Helper
 * @package container
 * @method  HelperContainer                 Helper() 应用层次的Helper容器
 * @method AuthorityContainer               Authority() 应用层次的权限容器
 */
class AppContainer extends App
{
    /**
     * 容器名称
     */
    const CONTAINER_NAME = 'App';

    # key 为标识  value 为类信息（请包括完整的命名空间）
    const bind = [
        'Helper'=>HelperContainer::class,//应用层次的Helper容器
        'AuthorityContainer'=>AuthorityContainer::class,//应用层次的权限容器
    ];
}