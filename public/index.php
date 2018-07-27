<?php
/**
 * @Author: pizepei
 * @Date:   2018-07-26 14:34:25
 * @Last Modified by:   pizepei
 * @Last Modified time: 2018-07-26 14:35:10
 */

header("Content-Type=text/html;charset=utf8");

require('../vendor/autoload.php');

echo '<pre>';
//var_dump(pizepei\config\Dbtabase::DBTABASE);

//pizepei\model\cache\Cache::set('CONFIG',pizepei\config\Dbtabase::DBTABASE);
pizepei\model\cache\Cache::set('PPX',pizepei\config\Dbtabase::DBTABASE);

pizepei\model\db\Db::table('user')->showCreateTableCache();




echo '</pre>';