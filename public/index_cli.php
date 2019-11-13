<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/1/29
 * Time: 11:02
 * @title 命令行入口
 */

require('../vendor/autoload.php');

(new pizepei\staging\App(true, 'app','ORIGINAL','','','CLI'))->start();
