<?php
/**
 * @Author: pizepei
 * @Date:   2019-02-18 14:34:25
 * @Last Modified by:   pizepei
 * @Last Modified time: 2019-02-18 14:35:10
 */

define('__INIT_MEMORY_GET_USAGE__',memory_get_usage()/1024);//系统初始化内存
define('__INIT_MICROTIME__',microtime(true));//系统初始化时间
$init_microtime = microtime(true);

define('__APP__','manage');//定义应用目录

define('__EXPLOIT__',TRUE);// 是否开发模式

require('../vendor/autoload.php');

$Start = new pizepei\staging\Start;
$Start->start();

