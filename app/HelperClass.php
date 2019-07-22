<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/07/22
 * Time: 16:30
 * @title helper扩展类：该类不会实例化主要是为了方便绑定容器和适配ide，适配ide必须添加对应的@method 或者 @property
 */
namespace app;


use pizepei\helper\File;

/**
 * Class Helper
 * @package app
 * @property File     $abb  文件类
 * @method static File abb(bool $new = false)  static[可选不填写就是非static方法] File[返回数据类型 可以是类 或者其他的比如self当前来]  test(string $question) [函数详情]
 */
class HelperClass extends \pizepei\helper\Helper
{
    # key 为标识  value 为类信息（请包括完整的命名空间）
    const childBind = [
        'abb'=>File::class
    ];
}