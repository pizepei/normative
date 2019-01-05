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
        'nickname'=>[
            'TYPE'=>'varchar(255)',
            'DEFAULT'=>0,//默认值
            'COMMENT'=>'昵称',//字段说明
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
    protected $table_version = 6;
    /**
     * @var array 表结构变更日志
     * 版本号=>['表操作的字段','操作类型ADD、DROP、MODIFY、CHANGE','操作内容（为安全起见不包括alter table user）','修改说明','修改人']
     * 注意：
     */
    protected $table_structure_log = [
        3=>[
            ['new1','ADD',"new3 VARCHAR(20) DEFAULT NULL COMMENT '测试效果'",'修改说明：增加user表的new1字段','pizepei'],
            //['new1','CHANGE',' new1 new4 int;','修改说明：修改一个字段的名称，此时一定要重新指定该字段的类型','pizepei'],
        ],
        4=>[
            ['new1','DROP','new1','修改说明：删除一个字段','pizepei'],
            ['new3','DROP','new3','修改说明：删除一个字段','pizepei'],
            ['new4','DROP','new4','修改说明：删除一个字段','pizepei'],
        ],
        5=>[
                ['nickname','ADD',"nickname varchar(255) DEFAULT '皮皮虾' COMMENT '昵称'",'增加nickname昵称字段','pizepei'],
            ],
        6=>[
            ['nickname','MODIFY',"nickname varchar(255) DEFAULT '皮皮虾' COMMENT '昵称'",'修改字段的类型','pizepei'],
        ],
    ];

    //protected $initData = ['name'=>'皮卡丘','nickname'=>'皮卡皮卡丘皮卡'];
    protected $initData = [
        ['name'=>'皮卡丘','nickname'=>'皮卡皮卡丘皮卡'],
        ['name'=>'皮卡丘2','nickname'=>'皮卡皮卡丘皮卡'],
        ['name'=>'皮卡丘3','nickname'=>'皮卡皮卡丘皮卡'],
        ['name'=>'皮卡丘4','nickname'=>'皮卡皮卡丘皮卡'],

    ];
}