<?php
/**
 * @Author: pizepei
 * @ProductName: PhpStorm
 * @Created: 2019/4/21 16:34
 * @title 资源定义
 */

namespace authority\app;


class Resource
{
    /**
     * @Author pizepei
     * @Created 2019/4/21 16:38
     * @param $name
     * @return null
     * @title  获取属性
     */
    public function __get($name)
    {
        if(isset($this->$name)){return $this->$name;}
        return null;
    }

    /**
     * 初始化权限列表
     * @param $data
     * @return array
     * @throws \ReflectionException
     */
    public static function initJurisdictionList($data)
    {
        $Resource = 'authority\\'.__APP__.'\\Resource';

        $reflect = new \ReflectionClass($Resource);
        $ConstData = $reflect->getConstants();
        $array =[];
        foreach($data as  $key=>$value)
        {
            $atData['id'] = $key;
            $atData['name'] = $ConstData['mainResource'][$key];
            $atData['pid'] = '0';
            $atData['value'] = '';

            $atData['checked'] = false;//是否选中
            $array [] = $atData;

            self::initList($array,$key,$value,$ConstData);


            ////{ "id": 1, "name": "用户管理", "pid": 0,"disabled":true },
            //$atData['checked'] = false;//是否选中
            //$atData['name'] = $ConstData['mainResource'][$key];//名字
            //$atData['value'] = $key;//代码
            ////$atData['list'] = [];//下级
            //self::initList($atData['list'],$key,$value,$ConstData);
            //$array[] = $atData;
        }
        return $array;
    }

    /**
     * 获取下级 权限
     * @param $atData
     * @param $keyData
     * @param $valueData
     * @param $ConstData
     */
    protected static function  initList(&$atData,$keyData,$valueData,$ConstData)
    {
        //$atDataList = [];
        foreach($valueData as  $key=>$value)
        {
            $data = [];
            foreach($value as $k=>$v)
            {

                $data['id'] = $k;
                $data['name'] = $ConstData[$keyData][$key]['list'][$k]['title'];
                $data['pid'] = $keyData;
                //$data['checked'] = false;//是否选中
                $atData[]=$data;
                self::initPort($atData,$k,$v,$ConstData);
                /**
                 *
                 */
                //$data['checked'] = false;//是否选中
                //$data['name'] = $ConstData[$keyData][$key]['list'][$k]['title'];//名字
                //$data['value'] = $k;//代码
                //self::initPort($data['list'],$k,$v,$ConstData);
                //$atDataList[] = $data;
            }
        }
        //$atData = $atDataList;

    }

    /**
     * 路由层 权限处理
     * @param $atData
     * @param $keyData
     * @param $valueData
     * @param $ConstData
     */
    protected static function initPort(&$atData,$keyData,$valueData,$ConstData)
    {
        foreach($valueData as  $key=>$value)
        {



            $data['id'] = $value['tag'];
            $data['name'] = $value['explain'];
            $data['pid'] = $keyData;
            //$data['checked'] = false;//是否选中
            $data['extend'] = $value['extend'];//扩展（规划中）
            $data['return'] = ['return'];//路由上配置的返回信息（规划中）
            $atData[] = $data;

            //$data['checked'] = true;//是否选中
            //$data['name'] = $value['explain'];//名字
            //$data['value'] = $value['tag'];//代码
            //$data['return'] = ['return'];//路由上配置的返回信息（规划中）
            //$data['extend'] = $value['extend'];//扩展（规划中）
            /**
             * 路由上配置的返回信息（规划中）
             * 扩展（规划中）
             */
            //$atData[] = $data;
        }
    }

    /**
     * 注册主模块(一级菜单)
     */
    const mainResource = [
            'system'=>'系统管理',
            'user'=> '用户管理',
            'basics'=>'基础权限'
        ];

    /**
     * 系统管理（一级的 二级菜单以及三级菜单）
     * @var array
     */
    const system = [
        'admin'=>[
            'title'=>'管理员账号管理',
            'list'=>[
                    'getAdmin'=>['title'=>'获取管理员账号'],
                    'setAdmin'=>['title'=>'管理管理员账号'],
            ],
        ],
    ];
    const basics = [
        'menu'=>[
            'title'=>'后台菜单管理',
            'list'=>[
                'getMenu'=>['title'=>'获取后台菜单'],
                'setMenu'=>['title'=>'设置后台菜单'],
            ],
        ],
        'index'=>[
            'title'=>'后台首页',
            'list'=>[
                'user'=>['title'=>'当前用户相关'],
                'menu'=>['title'=>'菜单导航'],
                'message'=>['title'=>'控制台信息']
            ],
        ]
    ];
    /**
     * 用户管理
     * @var array
     */
    const user=[
        //''=>[
        //    'del'=>'删除用户',
        //    'list'=>'获取用户列表',
        //    'info'=>'获取用户信息信息',
        //    'add'=>'添加用户',
        //]
    ];
}