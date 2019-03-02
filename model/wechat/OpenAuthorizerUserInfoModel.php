<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/3/2 14:16
 * @title 微信第三方授权用户信息表
 */

namespace model\wechat;


use pizepei\model\db\Model;

class OpenAuthorizerUserInfoModel extends Model
{

    /**
     * 表结构
     * @var array
     */
    protected $structure = [
        'id'=>[
            'TYPE'=>'uuid','COMMENT'=>'主键uuid','DEFAULT'=>false,
        ],
        'PreAuthCode'=>[
            'TYPE'=>'varchar(500)', 'DEFAULT'=>'', 'COMMENT'=>'获取授权链接时的授权码:用来对应用户关系',
        ],
        'nick_name'=>[
            'TYPE'=>'varchar(255)', 'DEFAULT'=>'', 'COMMENT'=>'授权方昵称',
        ],
        'head_img'=>[
            'TYPE'=>'varchar(255)', 'DEFAULT'=>'', 'COMMENT'=>'授权方头像',
        ],
        'service_type_info'=>[
            'TYPE'=>"json", 'DEFAULT'=>false, 'COMMENT'=>'授权方公众号类型，0代表订阅号，1代表由历史老帐号升级后的订阅号，2代表服务号',
        ],
        'verify_type_info'=>[
            'TYPE'=>"json", 'DEFAULT'=>false, 'COMMENT'=>'授权方认证类型，-1代表未认证，0代表微信认证，1代表新浪微博认证，2代表腾讯微博认证，3代表已资质认证通过但还未通过名称认证，4代表已资质认证通过、还未通过名称认证，但通过了新浪微博认证，5代表已资质认证通过、还未通过名称认证，但通过了腾讯微博认证',
        ],
        'user_name'=>[
            'TYPE'=>'varchar(120)', 'DEFAULT'=>'', 'COMMENT'=>'授权方公众号的原始ID',
        ],
        'principal_name'=>[
            'TYPE'=>'varchar(450)', 'DEFAULT'=>'', 'COMMENT'=>'公众号的主体名称',
        ],
        'alias'=>[
            'TYPE'=>'varchar(150)', 'DEFAULT'=>'', 'COMMENT'=>'授权方公众号所设置的微信号，可能为空',
        ],
        'business_info'=>[
            'TYPE'=>'json', 'DEFAULT'=>false, 'COMMENT'=>'用以了解以下功能的开通状况（0代表未开通，1代表已开通）： open_store:是否开通微信门店功能 open_scan:是否开通微信扫商品功能 open_pay:是否开通微信支付功能 open_card:是否开通微信卡券功能 open_shake:是否开通微信摇一摇功能',
        ],
        'qrcode_url'=>[
            'TYPE'=>'varchar(255)', 'DEFAULT'=>'', 'COMMENT'=>'二维码图片的URL，开发者最好自行也进行保存',
        ],
        'signature'=>[
            'TYPE'=>'varchar(550)', 'DEFAULT'=>'', 'COMMENT'=>'帐号介绍',
        ],
        'authorizer_access_token'=>[
            'TYPE'=>'varchar(350)', 'DEFAULT'=>'', 'COMMENT'=>'授权方接口调用凭据（在授权的公众号或小程序具备API权限时，才有此返回值），也简称为令牌',
        ],
        'expires_in'=>[
            'TYPE'=>'int(10)', 'DEFAULT'=>0, 'COMMENT'=>'有效期（在授权的公众号或小程序具备API权限时，才有此返回值）',
        ],
        'authorizer_appid'=>[
            'TYPE'=>'varchar(40)', 'DEFAULT'=>'', 'COMMENT'=>'授权方appid',
        ],
        'authorizer_refresh_token'=>[
            'TYPE'=>'varchar(250)', 'DEFAULT'=>'', 'COMMENT'=>'通过授权码和自己的接口调用凭据（component_access_token），换取公众号或小程序的接口调用凭据（authorizer_access_token和用于前者快过期时用来刷新它的authorizer_refresh_token）和授权信息（授权了哪些权限等信息）',
        ],
        'func_info'=>[
            'TYPE'=>'json', 'DEFAULT'=>false, 'COMMENT'=>'公众号授权给开发者的权限集列表，ID为1到15时分别代表： 1.消息管理权限 2.用户管理权限 3.帐号服务权限 4.网页服务权限 5.微信小店权限 6.微信多客服权限 7.群发与通知权限 8.微信卡券权限 9.微信扫一扫权限 10.微信连WIFI权限 11.素材管理权限 12.微信摇周边权限 13.微信门店权限 14.微信支付权限 15.自定义菜单权限 请注意： 1）该字段的返回不会考虑公众号是否具备该权限集的权限（因为可能部分具备），请根据公众号的帐号类型和认证情况，来判断公众号的接口权限。',
        ],
        'status'=>[
            'TYPE'=>"ENUM('1','2','3','4')", 'DEFAULT'=>1, 'COMMENT'=>'授权状态 1、未授权2、授权3、取消授权',
        ],
        /**
         * UNIQUE 唯一
         * SPATIAL 空间
         * NORMAL 普通 key
         * FULLTEXT 文本
         */
        'INDEX'=>[
                  ['TYPE'=>'UNIQUE','FIELD'=>'user_name','NAME'=>'user_name','USING'=>'BTREE','COMMENT'=>'授权方公众号的原始ID'],
                  ['TYPE'=>'UNIQUE','FIELD'=>'authorizer_appid','NAME'=>'authorizer_appid','USING'=>'BTREE','COMMENT'=>'授权方appid'],
        ],//索引 KEY `ip` (`ip`) COMMENT 'sss '
        'PRIMARY'=>'id',//主键
    ];
    /**
     * @var string 表备注（不可包含@版本号关键字）
     */
    protected $table_comment = '微信开放平台第三方平台授权用户表';
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