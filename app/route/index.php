<?php
/**
 * Created by PhpStorm.
 * User: 84873
 * Date: 2018/8/6
 * Time: 14:10
 */


/**
 * 所有 all
 * post  get
 * 路由 =>  【控制器，方法，请求类型，权限组['用以区分权限的功能集合']，是否调试（不设置默认系统统一配置，设置为单独配置，适合线上调试exploit），备注】
 */
return [
            '/' =>['index\Index','index','all','','','环境'],

            '/test' =>['index\Index','test','all','test',false,'测试'],

            '/test1' =>['index\Index','test1','all','test',false,'测试'],
            '/test2' =>['index\Index','test2','all','test',false,'测试'],
            '/test3' =>['index\Index','test3','all','test',false,'测试'],
            '/test4' =>['index\Index','test4','all','test',false,'测试'],
            '/test5' =>['index\Index','test5','all','test',false,'测试'],
            '/router/user/777' =>['index\Index','router','all','test',false,'测试'],

            '/Cache' =>['index\Index','Cache','all','缓存'],
            '/db' =>       ['index\Index','terminalInfo','all','test',false,'数据库db使用'],
            '/terminal' =>['index\Index','terminalInfo','get','test',false,'获取客户端信息'],
];