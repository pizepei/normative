<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/1/14
 * Time: 10:31
 */

namespace model;


use pizepei\model\db\Db;

class Uuid extends Db
{
    /**
     * 表结构
     * @var array
     */
    protected $structure = [
        'id'=>[
            'TYPE'=>'uuid','COMMENT'=>'主键uuid','DEFAULT'=>false,
        ],
        'Build'=>[
            'TYPE'=>'json', 'DEFAULT'=>'', 'COMMENT'=>'移动设备信息',
        ],
        'point'=>[
            'TYPE'=>'geometry', 'DEFAULT'=>'', 'COMMENT'=>'经纬度',
        ],
        'user_agent'=>[
            'TYPE'=>'varchar(255)', 'DEFAULT'=>'', 'COMMENT'=>'user_agent全部信息',
        ],


        'PRIMARY'=>'id',//主键

    ];
    /**
     * @var string 表备注（不可包含@版本号关键字）
     */
    protected $table_comment = 'uuid表';
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