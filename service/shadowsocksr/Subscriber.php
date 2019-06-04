<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/6/4 21:11 $
 * @title 简单的dome
 * @explain 类的说明
 */

namespace service\shadowsocksr;


class Subscriber
{
    /**
     * @Author pizepei
     * @Created 2019/6/4 21:12
     * @title  方法标题（一般是方法的简称）
     * @explain 一般是方法功能说明、逻辑说明、注意事项等。
     */
    public static function getKey()
    {

    }

    /**
     * @Author pizepei
     * @Created 2019/6/4 21:17
     * @title  方法标题（一般是方法的简称）
     * @explain 一般是方法功能说明、逻辑说明、注意事项等。
     * @param $data
     * @param $node
     */
    public static function setContent($data,$node)
    {
        $data = [
            'passwd'=>'passwd',//密码
            'port'=>'80',//端口
            'email'=>'qq@qq.com',
            'enable'=>'1',//状态 0 关闭 1 启动
            'plan'=>'C',//套餐
            'remarks'=>'套餐说明',
        ];
        $node = [
                    [
                    'node_server'=>'192.168.1.1',//服务器地址
                    'node_method'=>'aes-256-cfb',//加密方式
                    'node_protocol'=>'origin',//协议
                    'node_protoparam'=>'',//协议参数
                    'node_obfs'=>'plain',//混淆
                    'node_obfsparam'=>'',//混淆参数
                    'node_info'=>'备注说明',//备注说明
                    'node_group'=>'皮皮虾',//服务商
                ]
        ];

        $ssurl = '';
        foreach ($node as $k => $v) {
            /**
             *   host  port  协议   加密方式   混淆   密码  混淆参数 obfsparam   协议参数 protoparam   备注 remarks
             */
            $ssurl .=  "ssr://".base64_encode($v['node_server']
                    .':'.$data['port']
                    .':'.$v['node_protocol']
                    .':'.$v['node_method']
                    .':'.$v['node_obfs']
                    .':'.base64_encode($data['passwd'])
                    .'/?obfsparam='.base64_encode($v['node_obfsparam'])
                    .'&protoparam='.base64_encode($v['node_protoparam'])
                    .'&remarks='.base64_encode($v['node_name'].$data['email'])
                    .'&group='.base64_encode($v['node_group'].$data['remarks'])
                    .'&udpport=0&uot=0').PHP_EOL;
        }

    }







}
