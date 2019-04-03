<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/2/3
 * Time: 16:30
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 常用开放接口
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /open/common/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app;
use pizepei\encryption\SHA1;
use pizepei\func\Func;
use pizepei\staging\Controller;
use pizepei\staging\Request;

class OpenCommon extends Controller
{

    /**
     * @param \pizepei\staging\Request $Request [xml]
     *      path [object] 路径参数
     * @return array [json]
     * @title  文件上传
     * @explain 文件上传（公开的但是会判断上传域名）
     * @router post files-upload
     * @throws \Exception
     */
    public function openMessage(Request $Request)
    {
        /**
         * 请求签名接口
         * 参数  需要显示的域名
         *
         *
         * 签名确定域名准确性
         *
         * 签名   sha1（域名+appid+AppSecret+时间戳+随机字符串）       域名+时间戳+随机字符串+appid
         *
         *
         *接受接口
         *
         * 验证签名 签名正确
         *      使用appid查询 域名是否授权，授权就上传到对应的appid目录返回域名+时间+文件路径+文件名称
         */

        //$token, $timestamp, $nonce, $encrypt_msg
        $timestamp = time();
        $nonce =    Func::M('str')::str_rand(10);
        $encrypt_msg = '[域名,appid,表单，有效期（分钟单位）]';
        $SHA1 = new SHA1();

        $SHA1->getSHA1(\Config::FILES_UPLOAD_APP['token'],$timestamp,$nonce,$encrypt_msg);



        /**
         * 获取当前域名
         */
        //$HOST = $_SERVER['HTTP_HOST'];
        //var_dump($_SERVER['HTTP_REFERER']);
        //var_dump(\Config::FILES_UPLOAD_APP_SCHEMA);
        //var_dump(\Config::FILES_UPLOAD_APP);

        /**
         * 处理文件
         */

        foreach($_FILES as $key=>$value){
            /**
             * 相同key的数组文件上传
             */
            if(is_array($value['name'])){

            }else{
                /**
                 * 判断文件大小
                 */
                if($value['size'] > \Config::FILES_UPLOAD_APP_SCHEMA['files-upload']['size']){
                    return $this->error(['name'=>$key,'data'=>$value],'文件大小超过：'.(\Config::FILES_UPLOAD_APP_SCHEMA['files-upload']['size']/1024).'kb');
                }
                /**
                 * 判断文件类型
                 */
                if(!in_array($value['type'],\Config::FILES_UPLOAD_APP_SCHEMA['files-upload']['type'])){
                    return $this->error(['name'=>$key,'data'=>$value],'不允许的文件类型：'.$value['type']);
                }
                /**
                 * 判断是否限制域名
                 */
                if(!empty(\Config::FILES_UPLOAD_APP['domain'])){
                    $i = 0;
                    foreach(\Config::FILES_UPLOAD_APP['domain'] as $valueDomain)
                    {
                        preg_match($valueDomain,$_SERVER['HTTP_REFERER'], $result);
                        /**
                         *匹配
                         */
                        if(!empty($result)){
                            $domain = $result[0];
                            $i++;
                        }
                    }
                    if(!$i){
                        return $this->error(['name'=>$key,'data'=>$value],'不允许的来源域名：'.$_SERVER['HTTP_REFERER']);
                    }
                }
            }
        }


        /**
         * 拼接文件
         */

        var_dump( $_SERVER['HTTP_HOST'] );
        var_dump($_FILES);

        return $Request->input('','raw');
    }


}