<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/6/16 11:56 $
 * @title 简单的dome
 * @explain 类的说明
 */

namespace authority\app\controller;


use pizepei\staging\AuthorityInterface;

class DeployAuth implements AuthorityInterface
{
    /**
     * @return array
     * @throws \Exception
     */
    public function test()
    {
        return[];
    }
}
