<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/6/16 11:56 $
 * @title 简单的dome
 * @explain 类的说明
 */

namespace authority\app\controller;

use pizepei\basics\authority\BasicsAuthority;

class DeployAuth extends BasicsAuthority
{
    /**
     * @return array
     * @throws \Exception
     */
    public function test()
    {
        # 判断是否登录（如果无效状态会直接异常处理）
        $this->WhetherTheLogin();
    }
}
