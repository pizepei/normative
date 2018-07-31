<?php
/**
 * @Author: pizepei
 * @Date:   2018-07-26 14:34:25
 * @Last Modified by:   pizepei
 * @Last Modified time: 2018-07-26 14:35:10
 */
$init_memory_get_usage = memory_get_usage()/1024;
$init_microtime = microtime(true);

header("Content-Type=text/html;charset=utf8");
require('../vendor/autoload.php');
use pizepei\model\db\Db;
use pizepei\model\db\Model;
use pizepei\model\db\IpWhite;



$t1 = microtime(true);

echo '<pre>';
//echo '您好';
//var_dump(pizepei\config\Dbtabase::DBTABASE);
//Func::M('file')::createDir('bbc/dd/');
//var_dump(pizepei\model\cache\Cache::set('public',pizepei\config\Dbtabase::DBTABASE,15,'db'));

var_dump(pizepei\model\cache\Cache::get('public','db'));

//pizepei\model\cache\Cache::set('PPX',pizepei\config\Dbtabase::DBTABASE);

//Db::table('config')->showCreateTableCache();

//var_dump(Db::table('user')->get(4));

//$where['appid'] = ['LIKE','%5'];

$where['ip'] = ['EQ','19.55.55.55'];

//$where['status|appid'] = 0;
$mode = IpWhite::table('user');
$eco =  $mode->field(['id','ip'=>'appID'])->where($where)->forceIndex('id')->fetchAll();
var_dump($eco);
echo $mode->sql;
echo '<br>';

var_dump($mode->sqllog);
var_dump($mode->bindValuelog);
echo '<hr>';
$where = null;
$where['id'] = 2;
$eco =  $mode->field(['id'])->where($where)->forceIndex('id')->fetchAll();
var_dump($eco);

echo $mode->sql;
var_dump($mode->sqllog);
var_dump($mode->bindValuelog);
echo '<hr>';



echo '</pre>';
$over_microtime = microtime(true);
echo '耗时'.round($over_microtime-$init_microtime,3).'秒<br>';
$over_memory_get_usage = memory_get_usage()/1024;
$over_memory_get_peak_usage = memory_get_peak_usage()/1024;
echo '峰值: ' . $over_memory_get_peak_usage. '/K<br />';

