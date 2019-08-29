<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/4/22
 * Time: 14:40
 * @baseAuth DeployAuth:test
 * @title 统一临时测试方法
 * @basePath /test/
 */

namespace app;


use pizepei\basics\model\console\PersonShortcutModel;
use pizepei\staging\Controller;
use pizepei\staging\Request;

class test extends Controller
{
    /**
     * @param \pizepei\staging\Request $Request [xml]
     *      path [object] 路径参数
     *      get [object]
     * @return array [json]
     *      date [raw]
     * @title   测试方法
     * @explain 测试方法
     * @router get test
     * @throws \Exception
     */
    public function filesUploadSignature(Request $Request)
    {
        return PersonShortcutModel::table()->field(['status','count(*) as count '])->group('status');
        //year  month day
        return $this->app->Helper()->Date()->intDate('H:i','11:22','23:22','hour +1 minute');
    }

}