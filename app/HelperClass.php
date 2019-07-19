<?php


namespace app;


use pizepei\helper\File;
use pizepei\helper\Str;

/**
 * Class Helper
 * @package app
 * @property File             $abb  文件类
 * @method static File test(string $question)  static[可选不填写就是非static方法] File[返回数据类型 可以是类 或者其他的比如self当前来]  test(string $question) [函数详情]
 */
class HelperClass extends \pizepei\helper\Helper
{

    private $childContainer = [
        'abb'=>File::class
    ];
}