<?php
/**
 * Created by PhpStorm.
 * User: 84873
 * Date: 2018/8/17
 * Time: 16:11
 */
namespace model;
use pizepei\model\db\Model;
class TerminalInfoModel extends Model
{
    /**
     * 表结构
     * @var array
     */
    protected $structure = [
        'id'=>[
            'TYPE'=>'int','DEFAULT'=>false,'COMMENT'=>'主键id','AUTO_INCREMENT'=>true,
        ],
        'province'=>[
            'TYPE'=>'varchar(50)', 'DEFAULT'=>'','COMMENT'=>'省',
        ],
        'city'=>[
            'TYPE'=>'varchar(50)', 'DEFAULT'=>'','COMMENT'=>'市',
        ],
        'isp'=>[
            'TYPE'=>'varchar(35)', 'DEFAULT'=>'','COMMENT'=>'网络供应商',
        ],
        'NetworkType'=>[
            'TYPE'=>'varchar(20)','DEFAULT'=>'','COMMENT'=>'网络类型（从请求头中获取）',
        ],
        'Ipanel'=>[
            'TYPE'=>'varchar(35)', 'DEFAULT'=>'', 'COMMENT'=>'浏览器内核',
        ],
        'language'=>[
            'TYPE'=>'varchar(35)', 'DEFAULT'=>'', 'COMMENT'=>'从浏览器获取语言',
        ],
        'Os'=>[
            'TYPE'=>'varchar(35)', 'DEFAULT'=>'', 'COMMENT'=>'从浏览器获取操作系统',
        ],
        'IpInfo'=>[
            'TYPE'=>'json', 'DEFAULT'=>false, 'COMMENT'=>'ip信息','NULL'=>'',
        ],
        'Build'=>[
            'TYPE'=>'json', 'DEFAULT'=>false, 'COMMENT'=>'移动设备信息','NULL'=>'',
        ],
        'NetType'=>['TYPE'=>'varchar(35)', 'DEFAULT'=>'', 'COMMENT'=>'=从ip获取的移动设备网络',],

        'ip'=>[
            'TYPE'=>'varchar(15)', 'DEFAULT'=>'', 'COMMENT'=>'ip地址',
        ],
        'point'=>[
            'TYPE'=>'geometry', 'DEFAULT'=>false, 'COMMENT'=>'经纬度','NULL'=>'',
        ],
        'user_agent'=>[
            'TYPE'=>'varchar(255)', 'DEFAULT'=>'', 'COMMENT'=>'user_agent全部信息',
        ],


        'PRIMARY'=>'id',//主键
        'INDEX'=>[
            //  NORMAL KEY `create_time` (`create_time`) USING BTREE COMMENT '参数'
            ['TYPE'=>'key','FIELD'=>'ip','NAME'=>'ip','USING'=>'BTREE','COMMENT'=>'ip地址'],
        ],//索引 KEY `ip` (`ip`) COMMENT 'sss '

    ];
    /**
     * @var string 表备注（不可包含@版本号关键字）
     */
    protected $table_comment = '客户端信息表';
    /**
     * @var int 表版本（用来记录表结构版本）在表备注后面@$table_version
     */
    protected $table_version = 6;
    /**
     * @var array 表结构变更日志 版本号=>['表结构修改内容sql','表结构修改内容sql']
     */
    protected $table_structure_log = [
        1=>[
            ['Build','ADD',"Build json  DEFAULT NULL COMMENT '移动设备信息'",'增加移动设备信息记录','pizepei','修改时间'],
            ['point','ADD',"point geometry  DEFAULT NULL COMMENT '经纬度'",'经纬度','pizepei'],
        ],
        2=>[
            ['user_agent','ADD',"user_agent json  DEFAULT '' COMMENT 'user_agent全部信息'",'user_agent全部信息','pizepei'],
        ],
        3=>[
            ['user_agent','MODIFY',"user_agent varchar(255) DEFAULT 'user_agent全部信息' COMMENT '昵称'",'修改字段的类型从json变成varchar','pizepei'],
        ],
        4=>[
            ['ip','ADD-INDEX',"`ip`(`ip`) USING BTREE COMMENT '创建时间'",'添加ip为索引','pizepei'],
        ],
        6=>[
            ['user_agent','MODIFY',"user_agent varchar(255) DEFAULT 'user_agent全部信息' COMMENT '昵称'",'修改字段的类型从json变成varchar','pizepei'],
        ],

    ];


}