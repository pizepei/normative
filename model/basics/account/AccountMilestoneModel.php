<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/3/27
 * Time: 11:16
 * @title 账号表里程碑事件表
 */

namespace model\basics\account;


use pizepei\model\db\Model;

class AccountMilestoneModel extends Model
{
    /**
     * 表结构
     * @var array
     */
    protected $structure = [
        'id'=>[
            'TYPE'=>'uuid','COMMENT'=>'主键uuid','DEFAULT'=>false,
        ],
        'account_id'=>[
            'TYPE'=>'uuid', 'DEFAULT'=>'', 'COMMENT'=>'account表id',
        ],
        'type'=>[
            'TYPE'=>"ENUM('1','2','3','4','5','6','7','8','9','10')", 'DEFAULT'=>'1', 'COMMENT'=>'1注册、2修改密码、3修改手机、4修改邮箱、5密码错误超限、6异地登录、7更改加密参数',
        ],
        'status'=>[
            'TYPE'=>"ENUM('1','2','3','4','5')", 'DEFAULT'=>'1', 'COMMENT'=>'状态1等待审核、2审核通过3、禁止使用4、保留',
        ],
        'message'=>[
            'TYPE'=>"json", 'DEFAULT'=>false, 'COMMENT'=>'详细信息',
        ],
        /**
         * UNIQUE 唯一
         * SPATIAL 空间
         * NORMAL 普通 key
         * FULLTEXT 文本
         */
        'INDEX'=>[
            //  NORMAL KEY `create_time` (`create_time`) USING BTREE COMMENT '参数'
            ['TYPE'=>'KEY','FIELD'=>'account_id','NAME'=>'account_id','USING'=>'BTREE','COMMENT'=>'account表id'],
            ['TYPE'=>'KEY','FIELD'=>'type','NAME'=>'type','USING'=>'BTREE','COMMENT'=>'类型'],


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
 * 1注册、2修改密码、3修改手机、4修改邮箱、5密码错误超限、6异地登录、7
 * replace_type
 */
    protected $replace_type =[
        1=>'注册',
        2=>'修改密码',
        3=>'修改手机',
        4=>'修改邮箱',
        5=>'密码错误超限',
        6=>'异地登录',
        7=>'其他',
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
}