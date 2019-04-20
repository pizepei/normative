<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/4/14 14:44
 * @title 节日表
 */

namespace model\festival;


use pizepei\model\db\Model;

class FestivalModel extends Model
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
        'name'=>[
            'TYPE'=>'varchar(255)', 'DEFAULT'=>'', 'COMMENT'=>'节日名称',
        ],
        'remark'=>[
            'TYPE'=>'varchar(255)', 'DEFAULT'=>'', 'COMMENT'=>'备注说明',
        ],
        'year'=>[
            'TYPE'=>'int(4)', 'DEFAULT'=>'1997', 'COMMENT'=>'年',
        ],
        'month'=>[
            'TYPE'=>'int(2)', 'DEFAULT'=>'00', 'COMMENT'=>'月',
        ],
        'day'=>[
            'TYPE'=>'int(2)', 'DEFAULT'=>'00', 'COMMENT'=>'日',
        ],
        'hour'=>[
            'TYPE'=>'int(2)', 'DEFAULT'=>'00', 'COMMENT'=>'小时（24小时）',
        ],
        'minute'=>[
            'TYPE'=>'int(2)', 'DEFAULT'=>'00', 'COMMENT'=>'分钟',
        ],
        'second'=>[
            'TYPE'=>'int(2)', 'DEFAULT'=>'00', 'COMMENT'=>'秒',
        ],
        'time'=>[
            'TYPE'=>'int(10)', 'DEFAULT'=>0, 'COMMENT'=>'时间戳',
        ],
        'calendar'=>[
            'TYPE'=>"ENUM('1','2','3')", 'DEFAULT'=>'2', 'COMMENT'=>'日历类型1农历 2 阳历',
        ],
        'remind_count'=>[
            'TYPE'=>"ENUM('1','2','3','4','5','6')", 'DEFAULT'=>'1', 'COMMENT'=>'提醒数',
        ],
        'ahead_remind_type'=>[
            'TYPE'=>"ENUM('1','2','3','4','5')", 'DEFAULT'=>'1', 'COMMENT'=>'提前提醒类型1、天2、小时3、分钟4、秒5、倒计时',
        ],
        'ahead_remind'=>[
            'TYPE'=>"int(10)", 'DEFAULT'=>0, 'COMMENT'=>'提前提醒数',
        ],
        'ahead_remind_time'=>[
            'TYPE'=>"varchar(10)", 'DEFAULT'=>0, 'COMMENT'=>'当天提醒时间date H:i:s',
        ],
        'type'=>[
            'TYPE'=>"ENUM('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16')", 'DEFAULT'=>'1', 'COMMENT'=>'1默认，2生日、3纪念日，4、待办事件5、倒计时',
        ],
        'date'=>[
            'TYPE'=>"varchar(255)", 'DEFAULT'=>'', 'COMMENT'=>'日期时间用来显示',
        ],
        'inform_wechat'=>[
            'TYPE'=>"ENUM('1','2')", 'DEFAULT'=>'1', 'COMMENT'=>'微信通知 1通知2不通知',
        ],
        'inform_sms'=>[
            'TYPE'=>"ENUM('1','2')", 'DEFAULT'=>'1', 'COMMENT'=>'短信通知 1通知2不通知',
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
            //['TYPE'=>'UNIQUE','FIELD'=>'number','NAME'=>'number','USING'=>'BTREE','COMMENT'=>'编号固定开头的账号编码'],
            ['TYPE'=>'KEY','FIELD'=>'account_id','NAME'=>'account_id','USING'=>'BTREE','COMMENT'=>'账号id'],
            ['TYPE'=>'KEY','FIELD'=>'type','NAME'=>'type','USING'=>'BTREE','COMMENT'=>'类型'],
            ['TYPE'=>'KEY','FIELD'=>'year','NAME'=>'year','USING'=>'BTREE','COMMENT'=>'年'],
            ['TYPE'=>'KEY','FIELD'=>'month','NAME'=>'month','USING'=>'BTREE','COMMENT'=>'月'],
            ['TYPE'=>'KEY','FIELD'=>'day','NAME'=>'day','USING'=>'BTREE','COMMENT'=>'日'],



        ],//索引 KEY `ip` (`ip`) COMMENT 'sss 'user_name

        'PRIMARY'=>'id',//主键
    ];
    /**
     * @var string 表备注（不可包含@版本号关键字）
     */
    protected $table_comment = '节日表';
    /**
     * @var int 表版本（用来记录表结构版本）在表备注后面@$table_version
     */
    protected $table_version = 0;
    /**
     * @var array 表结构变更日志 版本号=>['表结构修改内容sql','表结构修改内容sql']
     */
    protected $table_structure_log = [

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
     * 类型模板
     * 状态1等待审核、2审核通过3、禁止使用4、保留
     * replace_type
     */
    protected $replace_calendar =[
        1=>'农历',
        2=>'阳历',
    ];
    /**
     * 节日类型
     * 1默认，2生日、3纪念日，4、待办事件5、倒计时
     * @var array
     */
    protected $replace_type =[
        1=>'其他',
        2=>'生日',
        3=>'纪念日',
        4=>'待办事件',
        5=>'倒计时',
    ];
    /**
     * 提前提醒类型
     * 1、天2、小时3、分钟4、秒
     * @var array
     */
    protected $replace_ahead_remind_type =[
        1=>'天',
        2=>'小时',
        3=>'分钟',
        4=>'秒',
        5=>'倒计时',
    ];

    /**
     * 思路
     *      首先确定类型type  不同的类型 保存的数据意义不同
     *          年月日这些字段  在不同类型下意义不同
     *              生日、纪念日：保存的是对应的出生年月日  和纪念日的发生日期
     *              待办事件、倒计时：保存的确实是通过处理的需要提醒的时间不如设置2019-04-20的待办事件就直接保存2019-04-20
     *          提前提醒
     *              生日、纪念日的提前提醒：类型只能是天然后ahead_remind_time确定开始可提醒的开始时间-》remind_count确定是否继续提醒ahead_remind确定提醒间隔（小时）
     *              注意：设置 提前提醒，到当天依然会按照ahead_remind_time确定开始可提醒的时间
     *              其他两个类型不支持提前提醒
     */
}