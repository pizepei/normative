<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/4/21 15:49
 * @title 用户权限控制器
 */

namespace authority\controller;



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
            '19c65abe91df5874ef901cfa8183f3ad'=>[
                'name'=>'添加账号操作',
                'extend'=>[
                    'organization'=>Model::UUID_ZERO,
                    'request'=>__REQUEST_ID__,
                ]
            ],
            'a9350ec33824502781b0271717583c70'=>[
                'name'=>'添加账号操作',
                'extend'=>[
                    'organization'=>Model::UUID_ZERO,
                    'request'=>__REQUEST_ID__,
                ]
            ]
        ];
        /**
         * 路由信息
         */
        $this->jurisdictionTidy($jurisdictionData);
        var_dump($this->authExtend);
        return  ['authExtend'=>$this->authExtend,'Payload'=>$this->Payload];
    }
}