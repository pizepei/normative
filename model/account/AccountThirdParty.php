<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/1/15
 * Time: 17:29
 */

namespace model\account;


use pizepei\model\db\Db;

class AccountThirdParty extends Db
{
    /**
     * 表结构
     * @var array
     */
    protected $structure = [
        'id'=>[
            'TYPE'=>'uuid','COMMENT'=>'主键uuid','DEFAULT'=>false,
        ],
        'account'=>[
            'TYPE'=>'json', 'DEFAULT'=>'', 'COMMENT'=>'account表id',
        ],
        'openid'=>[
            'TYPE'=>'varchar(50)', 'DEFAULT'=>'', 'COMMENT'=>'真实姓名',
        ],
        'type'=>[
            'TYPE'=>"ENUM('WeChat','QQ','weibo','no')", 'DEFAULT'=>'no', 'COMMENT'=>'WeChat微信、QQ腾讯qq、weibo新浪微博 no 没有',
        ],
        'status'=>[
            'TYPE'=>"ENUM('1','2','3','4')", 'DEFAULT'=>'1', 'COMMENT'=>'状态1等待审核、2审核通过3、禁止使用4、保留',
        ],
        /**
         * UNIQUE 唯一
         * SPATIAL 空间
         * NORMAL 普通 key
         * FULLTEXT 文本
         */
        'INDEX'=>[
            //  NORMAL KEY `create_time` (`create_time`) USING BTREE COMMENT '参数'
            ['TYPE'=>'UNIQUE','FIELD'=>'openid','NAME'=>'openid,type','USING'=>'BTREE','COMMENT'=>'openid唯一索引'],
        ],//索引 KEY `ip` (`ip`) COMMENT 'sss '

        'PRIMARY'=>'id',//主键
    ];
}