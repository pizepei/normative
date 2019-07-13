<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/1/29
 * Time: 11:02
 * @title 命令行入口
 */

define('__INIT_MEMORY_GET_USAGE__',memory_get_usage()/1024);//系统初始化内存
define('__INIT_MICROTIME__',microtime(true));//系统初始化时间
$init_microtime = microtime(true);

define('__APP__','app');//定义应用目录

require('../vendor/autoload.php');

$Start = new pizepei\staging\Start;
$Start->start('CLI');