<?php
/**
 * Created by PhpStorm.
 * User: 84873
 * Date: 2018/8/17
 * Time: 16:11
 */
namespace model;
use pizepei\model\db\Model;
class TerminalInfo extends Model
{
    /**
     * ""user_agent":"PostmanRuntime\/7.4.0","create_time":"2019-01-03 21:39:40","SYSTEMSTATUS":{"controller":"app\\index\\Index","function_method":"terminalInfo","request_method":"GET","request_url":"\/index\/dome\/router\/8787","route":"\/index\/dome\/router\/:uid[int]","sql":"","clientInfo":"121.34.55.43","系统开始时的内存(K)":387.5390625,"系统结束时的内存(KB)":1.25133,"系统内存峰值(KB)":1.28371,"执行耗时(S)":0.0237}}
     */
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
            'TYPE'=>'json', 'DEFAULT'=>'', 'COMMENT'=>'ip信息',
        ],
        'NetType'=>['TYPE'=>'varchar(35)', 'DEFAULT'=>'', 'COMMENT'=>'=从ip获取的移动设备网络',],
        'ip'=>['TYPE'=>'varchar(15)', 'DEFAULT'=>'', 'COMMENT'=>'=ip地址',
        ],

        'PRIMARY'=>'id',//主键
    ];
    /**
     * @var string 表备注（不可包含@版本号关键字）
     */
    protected $table_comment = '客户端信息表';
    /**
     * @var int 表版本（用来记录表结构版本）在表备注后面@$table_version
     */
    protected $table_version = 0;
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


}