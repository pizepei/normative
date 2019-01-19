<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/1/15
 * Time: 11:27
 * 平台主账号表
 */

namespace basics\model\account;


use pizepei\model\db\Db;

class AccountModel extends Db
{
    /**
     * 表结构
     * @var array
     */
    protected $structure = [
        'id'=>[
            'TYPE'=>'uuid','COMMENT'=>'主键uuid','DEFAULT'=>false,
        ],
        'number'=>[
            'TYPE'=>'varchar(32)', 'DEFAULT'=>'', 'COMMENT'=>'编号固定开头的账号编码',
        ],
        'name'=>[
            'TYPE'=>'varchar(150)', 'DEFAULT'=>'', 'COMMENT'=>'真实姓名',
        ],
        'nickname'=>[
            'TYPE'=>'varchar(255)', 'DEFAULT'=>'', 'COMMENT'=>'昵称',
        ],
        'email'=>[
            'TYPE'=>'varchar(255)', 'DEFAULT'=>'', 'COMMENT'=>'邮箱',
        ],
        'phone'=>[
            'TYPE'=>'varchar(11)', 'DEFAULT'=>'', 'COMMENT'=>'手机号码',
        ],
        'openid'=>[
            'TYPE'=>'varchar(40)', 'DEFAULT'=>'', 'COMMENT'=>'微信id',
        ],
        'id_Cards'=>[
            'TYPE'=>'varchar(18)', 'DEFAULT'=>'', 'COMMENT'=>'身份证',
        ],
        'parent_id'=>[
            'TYPE'=>'uuid', 'DEFAULT'=>'', 'COMMENT'=>'父级组织id（uuid）',
        ],
        'type'=>[
            'TYPE'=>"ENUM('1','2','3','4')", 'DEFAULT'=>'1', 'COMMENT'=>'账号类型1普通子账号、2应用账号、3应用管理员、4管理员',
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
            ['TYPE'=>'UNIQUE','FIELD'=>'number','NAME'=>'number','USING'=>'BTREE','COMMENT'=>'编号固定开头的账号编码'],
            ['TYPE'=>'UNIQUE','FIELD'=>'email','NAME'=>'email','USING'=>'BTREE','COMMENT'=>'邮箱'],
            ['TYPE'=>'UNIQUE','FIELD'=>'phone','NAME'=>'phone','USING'=>'BTREE','COMMENT'=>'手机号码'],
            ['TYPE'=>'UNIQUE','FIELD'=>'id_Cards','NAME'=>'id_Cards','USING'=>'BTREE','COMMENT'=>'身份证'],
        ],//索引 KEY `ip` (`ip`) COMMENT 'sss '

        'PRIMARY'=>'id',//主键

    ];
    /**
     * @var string 表备注（不可包含@版本号关键字）
     */
    protected $table_comment = '主账号表';
    /**
     * @var int 表版本（用来记录表结构版本）在表备注后面@$table_version
     */
    protected $table_version = 0;
    /**
     * @var array 表结构变更日志 版本号=>['表结构修改内容sql','表结构修改内容sql']
     */
    protected $table_structure_log = [
        1=>[
            //['uuid','ADD',"uuid char(36)  DEFAULT NULL COMMENT 'uuid'",'uuid','pizepei'],
        ]
    ];
}