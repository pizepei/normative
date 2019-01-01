<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2018/12/31 22:38
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 简单的dome
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /dome/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace model;

use pizepei\model\db\Db;

class Dome extends Db
{
    /**
     * 表结构
     * @var array
     */
    protected $structure = [
        'id'=>[
            'TYPE'=>'int',//数据类型（默认不为空）NOT NULL
            'DEFAULT'=>false,//默认值
            'COMMENT'=>'主键id',//字段说明
            'AUTO_INCREMENT'=>true,//自增  默认不
        ],
        'name'=>[
            'TYPE'=>'varchar(255)',
            'DEFAULT'=>0,//默认值
            'COMMENT'=>'名字',//字段说明
        ],

        'PRIMARY'=>'id',//主键
        /**
         * UNIQUE 唯一
         * SPATIAL 空间
         * NORMAL 普通 key
         * FULLTEXT 文本
         */
        'INDEX'=>[
            //  NORMAL KEY `create_time` (`create_time`) USING BTREE COMMENT '参数'
            //['TYPE'=>'key','FIELD'=>'creation_time','NAME'=>'creation_time','USING'=>'BTREE','COMMENT'=>'创建时间'],
        ],//索引 KEY `ip` (`ip`) COMMENT 'sss '
    ];
    /**
     * @var string 表备注（不可包含@版本号关键字）
     */
    protected $table_comment = '一个新的表Dome';
    /**
     * @var int 表版本（用来记录表结构版本）在表备注后面@$table_version
     */
    protected $table_version = 3;
    /**
     * @var array 表结构变更日志 版本号=>['表结构修改内容sql','表结构修改内容sql']
     */
    protected $table_structure_log = [
        1=>[],
        /**
         * 修改的内容必须是完整的否则好缺失部分原来的结构
         * ALTER TABLE `oauth_module`.`user_app` MODIFY COLUMN `nickname` timestamp(0) NULL DEFAULT NULL COMMENT '昵称' AFTER `mobile`;
         * ALTER TABLE `数据库`.`表` MODIFY COLUMN `需要修改的字段` 修改后的内容 AFTER `字段在哪个字段后面`;
         */
    ];


    /**
     * 链接数据库
     * 判断表是否存在方法
     *      存在
     *
     *      不存在
     *
     * 判断表结构是否一致方法
     *
     * 创建表方法
     *
     *修改表结构方法
     *
     */

}