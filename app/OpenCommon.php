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
use function AlibabaCloud\Client\json;
use AlibabaCloud\Domain\V20180129\EmailVerified;
use pizepei\encryption\aes\Prpcrypt;
use pizepei\encryption\google\GoogleAuthenticator;
use pizepei\encryption\SHA1;
use pizepei\func\Func;
use pizepei\service\filesupload\FilesUpload;
use pizepei\staging\Controller;
use pizepei\staging\Request;

class OpenCommon extends Controller
{



    /**
     * @param \pizepei\staging\Request $Request [xml]
     *      path [object] 路径参数
     *      get [object]
     *          filesName [string required] 表单名称
     *          show_domain [string required] 显示图片时的页面 如果不传默认获取请求头内容
     * @return array [json]
     * @title  文件上传
     * @explain 文件上传（公开的但是会判断上传域名）
     * @router get files-upload-signature
     * @throws \Exception
     */
    public function filesUploadSignature(Request $Request)
    {
        $FilesUpload = new FilesUpload(\Config::FILES_UPLOAD_APP['asdkjlk3434df674545l']);
        return $FilesUpload->signature($Request->input(),$this);

    }

    /**
     * @param \pizepei\staging\Request $Request [xml]
     *      post [object] 路径参数
     *          timestamp [int] 时间戳
     *          nonce [string] 随机数
     *          encrypt_msg [string] 密文
     *          msgSignature [string] 签名
     * @return array [json]
     * @title  文件上传
     * @explain 文件上传（公开的但是会判断上传域名）
     * @router post files-upload
     * @throws \Exception
     */
    public function filesUpload(Request $Request)
    {
        $FilesUpload = new FilesUpload(\Config::FILES_UPLOAD_APP['asdkjlk3434df674545l'],\Config::FILES_UPLOAD_APP_SCHEMA['files-upload']);
        return $FilesUpload->verifySignature($Request->post(),$this);
    }

    /**
     * @param \pizepei\staging\Request $Request [xml]
     *      post [object] 路径参数
     *          code [int] 验证码
     * @return array [json]
     * @title  文件上传
     * @explain 文件上传（公开的但是会判断上传域名）
     * @router post google-authenticator
     * @throws \Exception
     */
    public function googleAuthenticator(Request $Request)
    {
        $secret = '3FBUDFZ4DP6JJVM5';
       $GoogleAuthenticator =  new GoogleAuthenticator();
       $GoogleAuthenticator->createSecret();

        return$GoogleAuthenticator->getQRCodeGoogleUrl('ppx',$secret);
    }
}