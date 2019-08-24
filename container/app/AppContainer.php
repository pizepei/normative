<?php
/**
 * @title
 */

namespace Container\app;


use pizepei\staging\App;
/**
 * Class Helper
 * @package app
 * @property File     $abb  文件类
 * @method  File abb(bool $new = false)  static[可选不填写就是非static方法] File[返回数据类型 可以是类 或者其他的比如self当前来]  test(string $question) [函数详情]
 */
class AppContainer extends App
{
    /**
     * 容器名称
     */
    const CONTAINER_NAME = 'App';

    # key 为标识  value 为类信息（请包括完整的命名空间）
    const bind = [

    ];
}