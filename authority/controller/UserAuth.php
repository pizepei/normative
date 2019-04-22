<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/4/21 15:49
 * @title 用户权限控制器
 */

namespace authority\controller;



use pizepei\staging\Authority;

class UserAuth extends Authority
{
    /**
     * 模式
     * @param $pattern
     */
    public function test()
    {
        $this->WhetherTheLogin();
    }
}