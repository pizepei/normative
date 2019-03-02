<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2019/2/27
 * Time: 17:19
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 微信相关基础接口
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /wechat/common/
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app;


use model\wechat\OpenAccreditInformLogModel;
use model\wechat\OpenAuthorizerUserInfoModel;
use pizepei\model\redis\Redis;
use pizepei\staging\Controller;
use pizepei\staging\Request;
use pizepei\wechat\basics\AccessToken;
use pizepei\wechat\service\Open;

class WeChatCommon extends Controller
{
    /**
     * @param \pizepei\staging\Request $Request [json]
     *      path [object] 路径参数
     *          verify [string] 获取的微信域名切割参数
     * @return array [html]
     * @title  微信域名验证
     * @explain 微信配置时需要使用文件验证此方法可自动验证
     * @router get /MP_verify_:verify[string].txt debug:false
     * @throws \Exception
     */
    public function wx_verify(Request $Request)
    {
        return $Request->path()['verify'];
    }

    /**
     * @return array [html]
     * @title  微信开放平台域名验证
     * @explain 微信配置时需要使用文件验证此方法可自动验证
     * @router get /8219921392.txt debug:false
     * @throws \Exception
     */
    public function openWeixin()
    {
        echo '96aa892bea31c23d07a7721ba21bb283';
    }
    /**
     * @param \pizepei\staging\Request $Request [xml]
     *      path [object] 路径参数
     *          appid [string]
     *      raw [xml] 数据流
     *          ToUserName [string] 开发者ai
     * @return array [html]
     * @title  第三方服务消息与事件接收
     * @explain 消息与事件接收http://oauth.heil.top/wechat/common/$APPID$/message
     * @router post :appid[string]/message debug:false
     * @throws \Exception
     */
    public function openMessage(Request $Request)
    {

        var_dump($Request->input('','raw'));

        return $Request->path()['appid'];
    }
    /**
     * @param \pizepei\staging\Request $Request [xml]
     *      get [object] 参数
     *          timestamp [int]    消息接口token验证参数
     *          nonce [int]    消息接口token验证参数
     *          echostr [int]  消息接口token验证参数
     *          signature [string] 消息接口token验证参数
     *          openid [string] 消息接口token验证参数
     *          encrypt_type [string] 消息接口token验证参数
     *          msg_signature [string] 消息接口token验证参数
     * @return array [json]
     * @title  第三方服务授权接口
     * @explain 用于接收取消授权通知、授权成功通知、授权更新通知，也用于接收ticket，ticket是验证平台方的重要凭据。
     * @router post open/accredit/inform debug:false
     * @throws \Exception
     */
    public function openAccreditInform (Request $Request)
    {
        $redis = new Redis();
        Open::init(\Config::OPEN_WECHAT_CONFIG,$redis->redis);

        //file_put_contents('request.txt',json_encode($Request->input('','get')));
        //file_put_contents('input.txt',file_get_contents("php://input"));

        $result = Open::accredit($Request->input('','get'),file_get_contents("php://input"));

        OpenAccreditInformLogModel::table()->add([[
                                                 'input'=>file_get_contents("php://input"),
                                                 'request'=>$Request->input('','get'),
                                                 'InfoType'=>$result['InfoType'],
                                                 'msg'=>$result,
                                             ]]);

        /**
         * 授权authorized
         * 取消授权unauthorized
         */
        switch ($result['InfoType'])
        {
            case "component_verify_ticket":

                break;
            case "unauthorized"://取消授权
                /**
                 * 修改为未授权
                 */
                break;

            case "authorized"://进行授权（可能是重复授权）authorization_code
                /**
                 * 保存或者修改信息配置
                 */
                $resultData = OpenAuthorizerUserInfoModel::table()->where([
                    'authorizer_appid'=>$result['authorizerAccessInfo']['authorizer_appid'],
                ])->fetch();

                if($resultData)
                {
                    $result['authorizerAccessInfo']['id'] =$resultData['id'];

                    return OpenAuthorizerUserInfoModel::table()
                        ->where(
                                [
                                    'authorizer_appid'=>$result['authorizerAccessInfo']['authorizer_appid'],
                                ]
                        )
                        ->insert($result['authorizerAccessInfo']);

                }else{
                    OpenAuthorizerUserInfoModel::table()->add($result['authorizerAccessInfo']);
                }

                break;
            case "updateauthorized"://进行授权（可能是重复授权）authorization_code
                /**
                 * 保存或者修改信息配置
                 */
                $resultData = OpenAuthorizerUserInfoModel::table()->where([
                    'authorizer_appid'=>$result['authorizerAccessInfo']['authorizer_appid'],
                ])->fetch();
                var_dump($resultData);
                if($resultData)
                {
                    $result['authorizerAccessInfo']['id'] =$resultData['id'];

                    return OpenAuthorizerUserInfoModel::table()
                        ->where(
                            [
                                'authorizer_appid'=>$result['authorizerAccessInfo']['authorizer_appid'],
                            ]
                        )
                        ->insert($result['authorizerAccessInfo']);

                }else{
                    OpenAuthorizerUserInfoModel::table()->add($result['authorizerAccessInfo']);
                }

                break;


            default:

                break;
        }
        return $result;
    }

    /**
     * @param \pizepei\staging\Request $Request [xml]
     *      raw [xml] 数据流
     *          ToUserName [string] 开发者ai
     * @return array [json]
     * @title  测试接口
     * @explain 测试接口
     * @router get open/test debug:false
     * @throws \Exception
     */
    public function test (Request $Request)
    {
        //new AccessToken(\Config::OPEN_WECHAT_CONFIG,new Redis());
        $redis = new Redis();
        Open::init(\Config::OPEN_WECHAT_CONFIG,$redis->redis);
        return Open::authorizerInfo('wx3260515a4514ec94');

    }


}