<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/3/2 15:53
 * @title 微信获取授权url时的授权代码
 */

namespace model\wechat;


use pizepei\model\db\Model;

class PreAuthCodeModel extends Model
{
    /**
     * 表结构
     * @var array
     */
    protected $structure = [
        'id'=>[
            'TYPE'=>'uuid','COMMENT'=>'主键uuid','DEFAULT'=>false,
        ],
        'uuid'=>[
            'TYPE'=>'uuid', 'DEFAULT'=>'', 'COMMENT'=>'关联uuid',
        ],
        'PreAuthCode'=>[
            'TYPE'=>'varchar(150)', 'DEFAULT'=>'', 'COMMENT'=>'授权码',
        ],
        'url'=>[
            'TYPE'=>'varchar(500)', 'DEFAULT'=>'', 'COMMENT'=>'获取的url',
        ],
        /**
         * UNIQUE 唯一
         * SPATIAL 空间
         * NORMAL 普通 key
         * FULLTEXT 文本
         */
        'INDEX'=>[

        ],//索引 KEY `ip` (`ip`) COMMENT 'sss '
        'PRIMARY'=>'id',//主键
    ];
    /**
     * @var string 表备注（不可包含@版本号关键字）
     */
    protected $table_comment = '微信获取授权url时的授权代码';
    /**
     * @var int 表版本（用来记录表结构版本）在表备注后面@$table_version
     */
    protected $table_version = 0;
    /**
     * @var array 表结构变更日志 版本号=>['表结构修改内容sql','表结构修改内容sql']
     */
    protected $table_structure_log = [

    ];
}