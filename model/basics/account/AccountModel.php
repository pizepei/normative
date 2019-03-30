<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/1/15
 * Time: 11:27
 * 平台主账号表
 */

namespace model\basics\account;


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
            'TYPE'=>'varchar(32)', 'DEFAULT'=>'', 'COMMENT'=>'编号固定开头的账号编码(common,tourist,app,appAdmin,appSuperAdmin,Administrators)',
        ],
        'surname'=>[
            'TYPE'=>'varchar(150)', 'DEFAULT'=>'', 'COMMENT'=>'真实姓氏',
        ],
        'name'=>[
            'TYPE'=>'varchar(150)', 'DEFAULT'=>'', 'COMMENT'=>'真实名',
        ],
        'nickname'=>[
            'TYPE'=>'varchar(255)', 'DEFAULT'=>'', 'COMMENT'=>'昵称',
        ],
        'user_name'=>[
            'TYPE'=>'varchar(255)', 'DEFAULT'=>'', 'COMMENT'=>'姓名',
        ],
        'email'=>[
            'TYPE'=>'varchar(255)', 'DEFAULT'=>'', 'COMMENT'=>'邮箱',
        ],
        'phone'=>[
            'TYPE'=>'varchar(11)', 'DEFAULT'=>'', 'COMMENT'=>'手机号码',
        ],
        'parent_id'=>[
            'TYPE'=>'uuid', 'DEFAULT'=>'', 'COMMENT'=>'父级组织id（uuid）',
        ],
        'password_hash'=>[
            'TYPE'=>'varchar(255)', 'DEFAULT'=>'', 'COMMENT'=>'password_hash函数返回值',
        ],
        'logon_token_salt'=>[
            'TYPE'=>'varchar(42)', 'DEFAULT'=>'', 'COMMENT'=>'登录token_salt',
        ],
        'password_wrong_count'=>[
            'TYPE'=>"ENUM('3','5','6','8','10')", 'DEFAULT'=>5, 'COMMENT'=>'密码错误数',
        ],
        'password_wrong_lock'=>[
            'TYPE'=>"ENUM('10','20','30','60','120','240')", 'DEFAULT'=>20, 'COMMENT'=>'密码错误超过限制的锁定时间：分钟',
        ],
        'logon_token_period_pattern'=>[
            'TYPE'=>"ENUM('1','2','3','4','5','6')", 'DEFAULT'=>1, 'COMMENT'=>'登录token模式1、谨慎（分钟为单位）2、常规（小时为单位）3、方便（天为单位）4、游客（单位分钟没有操作注销）',
        ],
        'logon_token_period_time'=>[
            'TYPE'=>"int(10)", 'DEFAULT'=>10, 'COMMENT'=>'登录token有效期',
        ],
        'type'=>[
            'TYPE'=>"ENUM('1','2','3','4','5','6','7','8')", 'DEFAULT'=>'1', 'COMMENT'=>'账号类型1普通子账号common、2游客tourist、3应用账号app、4应用管理员appAdmin、5应用超级管理员appSuperAdmin、6超级管理员Administrators',
        ],
        'status'=>[
            'TYPE'=>"ENUM('1','2','3','4','5')", 'DEFAULT'=>'1', 'COMMENT'=>'状态1等待审核、2审核通过3、禁止使用4、保留',
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
            ['TYPE'=>'KEY','FIELD'=>'user_name','NAME'=>'user_name','USING'=>'BTREE','COMMENT'=>'真实姓名'],

        ],//索引 KEY `ip` (`ip`) COMMENT 'sss 'user_name

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
    /**
     * 类型模板
     * 状态1等待审核、2审核通过3、禁止使用4、保留
     * replace_type
     */
    protected $replace_status =[
        1=>'等待审核',
        2=>'审核通过',
        3=>'禁止使用',
        4=>'保留',
        5=>'保留',
    ];
    /**
     * 账号类型
     * 账号类型1普通子账号common、2游客tourist、3应用账号app、4应用管理员appAdmin、5应用超级管理员appSuperAdmin、6超级管理员Administrators
     * @var array
     */
    protected $replace_type =[
        1=>'普通子账号common',
        2=>'游客tourist',
        3=>'应用账号app',
        4=>'应用管理员appAdmin',
        5=>'应用超级管理员appSuperAdmin',
        6=>'超级管理员Administrators',
        7=>'其他',
    ];
}