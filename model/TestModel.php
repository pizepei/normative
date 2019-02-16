<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/2/16 22:28
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 简单的dome
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /dome/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace model;


use pizepei\model\db\Model;

class TestModel extends Model
{
    /**
     * 表结构
     * @var array
     */
    protected $structure = [
        'id'=>[
            'TYPE'=>'uuid','COMMENT'=>'主键uuid','DEFAULT'=>false,
        ],
        'content'=>[
            'TYPE'=>'json', 'DEFAULT'=>false, 'COMMENT'=>'简单信息',
        ],
        'PRIMARY'=>'id',//主键
    ];
    /**
     * @var string 表备注（不可包含@版本号关键字）
     */
    protected $table_comment = '测试表';
    /**
     * @var int 表版本（用来记录表结构版本）在表备注后面@$table_version
     */
    protected $table_version = 1;
    /**
     * @var array 表结构变更日志 版本号=>['表结构修改内容sql','表结构修改内容sql']
     */
    protected $table_structure_log = [
        1=>[
            ['uuid','ADD',"uuid char(36)  DEFAULT NULL COMMENT 'uuid'",'uuid','pizepei'],
        ]
    ];
}