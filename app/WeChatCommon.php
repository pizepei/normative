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

use pizepei\wechat\basics\CodeApp;
use pizepei\wechat\basics\QrCode;
use pizepei\wechat\basics\ReplyApi;
use pizepei\wechat\model\OpenAccreditInformLogModel;
use pizepei\model\redis\Redis;
use pizepei\staging\Controller;
use pizepei\staging\Request;
use pizepei\wechat\model\OpenMessageLogModel;
use pizepei\wechat\model\OpenWechatCodeAppModel;
use pizepei\wechat\model\PreAuthCodeModel;
use pizepei\wechat\service\Config;
use pizepei\wechat\service\Open;
class WeChatCommon extends Controller
{

    /**
     * @param \pizepei\staging\Request $Request [xml]
     *      path [object] 路径参数
     *          verify [string] 获取的微信域名切割参数
     * @return array|bool|string [json]
     *      data [raw]
     * @title  微信域名验证
     * @explain 微信配置时需要使用文件验证此方法可自动验证
     * @router get test debug:false
     * @throws \Exception
     */
    public function test(Request $Request)
    {
        $QrCode = new QrCode('wx3260515a4514ec94');
        return $QrCode->get_ticket(1234,10);

//        $config = new Config(Redis::init());
//        return $config->access_token('wx3260515a4514ec94',false);
    }

    /**
     * @return array|bool|string [json]
     *      data [raw]
     * @title  微信域名验证
     * @explain 微信配置时需要使用文件验证此方法可自动验证
     * @router get test2 debug:false
     * @throws \Exception
     */
    public function test2()
    {
        return Helper()->syncLock(Redis::init(),['test','1'],false);
    }

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
     *      get [object] 参数
     *          timestamp [int]    时间戳
     *          nonce [int]    随机数
     *          echostr [int]  消息接口token验证参数
     *          signature [string] 签名
     *          openid [string] appid
     *          encrypt_type [string] 加密方式
     *          msg_signature [string] 消息接口token验证参数
     *      rule [xml] 数据流
     *          ToUserName [string] 开发者ai
     * @return array [xml]
     * @title  第三方服务消息与事件接收
     * @explain 消息与事件接收http://oauth.heil.top/wechat/common/$APPID$/message
     * @router post :appid[string]/message debug:false
     * @throws \Exception
     */
    public function openMessage(Request $Request)
    {
        OpenMessageLogModel::table()->add([
            'title'=>'init数据',
            'request'=>$Request->input(),
            'input'=>file_get_contents("php://input"),
            'appid'=>$Request->path('appid'),
        ]);
        $Config = new Config(Redis::init());
        $AloneConfig = $Config->getAloneConfig(true,$Request->path('appid'));
        if (!isset($AloneConfig['component_appid']) || empty($AloneConfig['component_appid'])){
            throw new \Exception('Alone null');
        }
        $OpenConfig= $Config->getOpenConfig(false,$AloneConfig['component_appid']);
        if (!isset($OpenConfig['appid']) && empty($OpenConfig['appid'])){
            throw new \Exception('Open null');
        }
        $AloneConfig['EncodingAESKey'] = $OpenConfig['EncodingAESKey'];
        $AloneConfig['token'] = $OpenConfig['token'];

        if (empty($OpenConfig['transpond_url'])){
            $ReplyApi = new ReplyApi($Request->input(),$AloneConfig,$Request->path('appid'));
            echo $content =  $ReplyApi->content_type();
            OpenMessageLogModel::table()->add([
                'title'=>'content',
                'request'=>$Request->input(),
                'input'=>file_get_contents("php://input"),
                'appid'=>$Request->path('appid'),
                'msg'=>[$content],
            ]);
        }else{
            //转发
        }
    }
    /**
     * @param \pizepei\staging\Request $Request [xml]
     *      get [object] 参数
     *          timestamp [int required]   时间戳
     *          nonce [int required]   随机数
     *          echostr [string]
     *          signature [string required] 签名
     *          openid [string]  openid
     *          encrypt_type [string required] 加密类型
     *          msg_signature [string required] 签名
     *      rule [raw] 数据流
     *          AppId [string] 第三方平台appid
     *          Encrypt [string] 密文
     * @return array [xml]
     * @title  第三方服务授权接口
     * @explain 用于接收取消授权通知、授权成功通知、授权更新通知，也用于接收ticket，ticket是验证平台方的重要凭据。
     * @router post open/accredit/inform debug:false
     * @throws \Exception
     */
    public function openAccreditInform (Request $Request)
    {
        ignore_user_abort(true);
        set_time_limit(60);
        OpenAccreditInformLogModel::table()->add([
            'raw_input'=>file_get_contents("php://input"),
            'request'=>$Request->input(),
            'msg'=>$_SERVER,
            'xmlToArray'=>$Request->input('','raw')
        ]);
        /**
         * 获取配置
         */
        $Config = new Config(Redis::init());
        $Config = $Config->getOpenConfig(false,$Request->input('AppId','raw'));
        /**
         * 初始化类
         */
        Open::init($Config,Redis::init());
        /**
         * 授权信息解析
         */
        $result = Open::accredit($Request->input('','get'),file_get_contents("php://input"));

        OpenAccreditInformLogModel::table()->add([
            'raw_input'=>file_get_contents("php://input"),
            'request'=>$Request->input('','get'),
            'InfoType'=>$result['InfoType'],
            'msg'=>$result,
            'xmlToArray'=>$Request->input('','raw')
        ]);
        return $result;
    }
    /**
     * @Author 皮泽培
     * @Created 2019/7/13 14:33
     * @param Request $Request
     *   path [object] 路径参数
     *      AppId [string] appid
     *   get [object] 路径参数
     *   post [object] post参数
     *   rule [object] 数据流参数
     * @return array [html] 定义输出返回数据
     * @title  获取授权连接
     * @explain 路由功能说明
     * @authGroup basics.menu.getMenu:权限分组1,basics.index.menu:权限分组2
     * @authExtend UserExtend.list:拓展权限
     * @baseAuth Resource:public
     * @throws \Exception
     * @router get open/accredit/AccreditUrl/:AppId[string]
     */
    public function getAccreditUrl(Request $Request)
    {
        $Config = new Config(Redis::init());
        $Config = $Config->getOpenConfig(false,$Request->path('AppId'));
        Open::init($Config,Redis::init());
        $AccreditUrl = Open::getAccreditUrl('','http://'.$_SERVER['HTTP_HOST'].'/wechat/common/open/accredit/RedirectUri/'.__REQUEST_ID__);
        PreAuthCodeModel::table()->add(['url'=>$AccreditUrl['url'],'PreAuthCode'=>$AccreditUrl['pre_auth_code'],'uuid'=>__REQUEST_ID__]);
        echo '<html><head></head><body><a  href="'.$AccreditUrl['url'].'">去授权</a></body></html>';
    }
    /**
     * @Author 皮泽培
     * @Created 2019/7/13 14:45
     *   path [object] 路径参数
     *      uuid [uuid] uuid
     *   get [object] 路径参数
     *      expires_in [int] 有效期
     *      auth_code [string] 授权码
     *   post [object] post参数
     *   rule [object] 数据流参数
     * @return array [json] 定义输出返回数据
     *      data [raw] 数据
     * @title  授权RedirectUri地址
     * @explain 暂时不处理
     * @throws \Exception
     * @router get open/accredit/RedirectUri/:uuid[uuid]
     */
    public function accreditRedirectUri(Request $Request)
    {
        return $Request->path();
    }

    /**
     * @Author 皮泽培
     * @Created 2019/8/2 16:49
     * @param Request $Request
     *   path [object] 路径参数
     *      appid [uuid] 应用appid
     *   rule [object] rule参数
     *      nonce [string required]
     *      timestamp [int required]
     *      signature [string required]
     *      encrypt_msg [string required]
     * @return array [json] 定义输出返回数据
     *      data [raw] uuid
     * @title  验证应用二维码获取
     * @explain 验证应用二维码获取
     * @baseAuth Resource:public
     * @throws \Exception
     * @router post code-app/qr/:appid[uuid]
     */
    public function getQr(Request $Request)
    {
        $App = OpenWechatCodeAppModel::table()
            ->where(['id'=>$Request->path('appid'),'status'=>2])
            ->cache(['OpenWechatCodeApp','config'],60)
            ->fetch();
        if (empty($App)){
            return $this->error($Request->path('appid'),'非法请求');
        }
        $QrCode = new QrCode($App['authorizer_appid']);
        return $QrCode->responseQr($App,$Request->raw());

    }
    /**
     * @Author 皮泽培
     * @Created 2019/8/10 16:49
     * @param Request $Request
     *   path [object] 路径参数
     *      appid [uuid] 应用appid
     *      id [uuid] 日志id
     *   get [object] rule参数
     *      nonce [string required] 随机数
     *      ticketNonce [string required] ticket随机数
     *      timestamp [int required]  时间戳
     *      period [int required] 有效期时间戳
     *      openid [string required] 粉丝openid
     *      signature [string required] 签名
     *      authorizer_appid [string required] 微信公众号appid
     *      ticketSignature [string required] ticket签名
     * @return array|string [html] 定义输出返回数据
     * @title  验证应用二维码验证页面
     * @explain 验证页面
     * @baseAuth Resource:public
     * @throws \Exception
     * @router get code-app/verify/OAuth20/:appid[uuid]/:id[uuid].html
     */
    public function urlVerifyOAuth20(Request $Request)
    {
        # 验证
        $data = (new CodeApp())->getUrlVerifyOAuth20($Request->path(),$Request->input());
        var_dump($data);
        if (isset($data['result'])){
            if ($data['result'] == 'on'){         return $this->view('VerifyMode',$data);}
        }


        return $this->view('VerifyMode');
    }
    /**
     * @Author 皮泽培
     * @Created 2019/8/2 16:49
     * @param Request $Request
     *   path [object] 路径参数
     *      appid [uuid] 应用appid
     *      id [uuid] 日志id
     *   get [object] rule参数
     *      nonce [string required] 随机数
     *      ticketNonce [string required] ticket随机数
     *      timestamp [int required]  时间戳
     *      period [int required] 有效期时间戳
     *      openid [string required] 粉丝openid
     *      signature [string required] 签名
     *      authorizer_appid [string required] 微信公众号appid
     *      ticketSignature [string required] ticket签名
     * @return array|string [html] 定义输出返回数据
     * @title  验证应用二维码验证页面
     * @explain 验证页面
     * @baseAuth Resource:public
     * @throws \Exception
     * @router get code-app/verify/:appid[uuid]/:id[uuid].html
     */
    public function urlVerifyHtml(Request $Request)
    {
        $data = (new CodeApp())->initialUrlVerifyHtml($Request->path(),$Request->input());
        # 4 通过API请求确认
        # 5 在API中判断ticketSignature签名是否合法
        return $this->view('VerifyMode',$data);
    }

}