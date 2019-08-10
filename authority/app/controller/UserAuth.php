<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/4/21 15:49
 * @title 用户权限控制器
 */

namespace authority\app\controller;



use pizepei\model\db\Model;
use pizepei\staging\Authority;
use pizepei\staging\Route;

class UserAuth extends Authority
{
    /**
     * @return array
     * @throws \Exception
     */
    public function test()
    {
        /**
         * 判断是否登录（如果无效状态会直接异常处理）
         */
        $this->WhetherTheLogin();
        /**
         * 获取当前用户的信息（权限）$jurisdictionData
         */
        $jurisdictionData = [
            '409bfd433e7dd7af7d7530ad5fb7bc46'=>[
                'name'=>'添加账号操作',
                'extend'=>[
                    'organization'=>Model::UUID_ZERO,
                    'request'=>$this->app->__REQUEST_ID__,
                ]
            ],
            '282e641f4e6d57d537506b39c44d3b3c'=>[
                'name'=>'添加账号操作',
                'extend'=>[
                    'organization'=>Model::UUID_ZERO,
                    'request'=>$this->app->__REQUEST_ID__,
                ]
            ],
            '5096329358d51606876178c77d940bb4'=>[
                'name'=>'添加账号操作',
                'extend'=>[
                    'organization'=>Model::UUID_ZERO,
                    'request'=>$this->app->__REQUEST_ID__,
                ]
            ]
        ];
        /**
         * 路由信息
         */
//        $this->jurisdictionTidy($jurisdictionData);
        //var_dump($this->authExtend);
        return  ['authExtend'=>$this->authExtend,'Payload'=>$this->Payload];
    }
}