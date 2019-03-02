<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/3/1
 * Time: 14:00
 * @title 微信开放平台第三方平台授权事件接收URL日志
 */

namespace model\wechat;


use pizepei\model\db\Model;

class OpenAccreditInformLogModel extends Model
{

    /**
     * 表结构
     * @var array
     */
    protected $structure = [
        'id'=>[
            'TYPE'=>'uuid','COMMENT'=>'主键uuid','DEFAULT'=>false,
        ],
        'input'=>[
            'TYPE'=>'text', 'DEFAULT'=>false, 'COMMENT'=>'input原始数据',
        ],
        'request'=>[
            'TYPE'=>'json', 'DEFAULT'=>false, 'COMMENT'=>'get请求参数',
        ],
        'msg'=>[
            'TYPE'=>'json', 'DEFAULT'=>false, 'COMMENT'=>'解密',
        ],
        'InfoType'=>[
            'TYPE'=>'varchar(100)', 'DEFAULT'=>'', 'COMMENT'=>'事件类型',
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
    protected $table_comment = '微信开放平台第三方平台授权事件接收URL日志';
    /**
     * @var int 表版本（用来记录表结构版本）在表备注后面@$table_version
     */
    protected $table_version = 1;
    /**
     * @var array 表结构变更日志 版本号=>['表结构修改内容sql','表结构修改内容sql']
     */
    protected $table_structure_log = [
        1=>[
            ['smg','ADD'," msg  json  COMMENT '解密' ",'解密','pizepei'],
        ]
    ];
}