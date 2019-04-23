<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2018/8/6
 * Time: 15:25
 * @baseAuth UserAuth:aut
 * @title 简单的dome
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表（在显示权限时继续分组）资源
 * @basePath /dome/
 */

namespace app\index;

/**
 * 模块资源 （用户管理、商品管理）
 *     操作资源  增 删 改 查
 *
 * 路由方法中的权限资源：每个路由都可注册到不同的操作资源只
 *
 * 在显示操作资源是：首先列出模块-》列出操作资源-》每个操作资源只注册的路由方法
 *
 * 选择并且保存时：保存的是每个路由的唯一权限代码
 * 判断权限是是直接判断路由权限代码是否在保存的列表中
 *
 *
 * baseAuth 权限控制器  里面注册 模块资源
 *
 *方法路由：注册到不同操作权限资源里面用authGroup【admin.bbx:user.bbx】中文名字、注册扩展扩展authExtend  控制器：方法（方法里面有返回数据、）
 *
 */

use model\basics\account\AccountModel;
use model\TerminalInfoModel;
use model\TestModel;
use pizepei\func\Func;
use pizepei\model\cache\Cache;
use pizepei\model\db\TableAlterLogModel;
use pizepei\model\redis\Redis;
use pizepei\service\jwt\JsonWebToken;
use pizepei\service\sms\Sms;
use pizepei\staging\Controller;
use pizepei\staging\Request;
use pizepei\staging\Route;
use pizepei\terminalInfo\TerminalInfo;
use service\basics\account\AccountService;

class Dome extends Controller
{

    /**
     * @return array [html]
     * @title  / 路由的应用
     * @explain 注意所有 path 路由都使用 正则表达式为唯一凭证 所以 / 路由只能有一个
     * @router get /index.html
     */
    public function index()
    {
        require(__INIT__['index-view']);
    }

    /**
     * @param \pizepei\staging\Request $Request
     *      get [object] 路径参数
     *           objectList [objectList] objectList
     *              id [int] 年级
     *              name [raw] 名字
     *                  name [string] 姓名
     *                  Name [string] 姓名
     *           name [string number] path_id
     *           list [list] list
     *              name [int] 111
     *              id [int] id
     *      post [object] post参数
     *           list [object] list
     *              name [int] 111
     *              id [int] id
     *      path [object] 路径参数
     *          id [string] 参数id
     *          name [string] 参数名字
     *      rule [object] 数据流参数
     *          id [string] 参数id
     *          name [string] 参数名字
     * @return array [json] 名字
     *      nameList [objectList] 同学名字
     *          name [string] 姓名
     *      id [int] 年级id
     * @title  演示请求参数与数据返回
     * @explain  测试路由的参数过滤，返回数据过滤
     * @authExpand [staff:员工权限,admin:管理员权限]  权限拓展在选择接口级别的权限时可选，进入控制器后可使用控制器方法获取到当前用户角色的权限
     * @router get param/:id[string]/:name[string]
     * @throws \Exception
     */
    public function param(Request $Request)
    {
        return $this->succeed([
            'Request' => [
                [
                    'id'   => '123456',
                    'name' => [
                        'name'  => '12',
                        'Name'  => 'zepei',
                        'Name2' => 'zepei',
                    ],
                    'Name' => 'zepei',
                ]
            ],
            'input'   => $Request->input()
        ], '测试路由的参数过滤，返回数据过滤');
    }


    /**
     * @param \pizepei\staging\Request $Request
     *      path [object] 路径参数
     *           id [string] id
     *           name [string] 名字
     * @return array [json]
     * @title  获取详细client信息
     * @explain 演示获取详细的client信息
     * @router get client/:id[string]/:name[string]
     * @throws \Exception
     */
    public function client(Request $Request)
    {
        $terminalInfo = TerminalInfo::getArowserPro();
        /**
         * 存储经纬度信息
         */
        $IpInfo = $terminalInfo['IpInfo'];
        $data   = @array_merge($IpInfo, $terminalInfo);
        if(isset($data['point'])){
            $data['point'] = ['GeomFromText', 'POINT('.$data['point']['x'].' '.$data['point']['y'].')'];
        }
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $TerminalInfo       = TerminalInfoModel::table();

        return $this->succeed([
            'location' => $TerminalInfo->insert([$data, $data, $data], false),
            'path'     => $Request->path(),
            'input'    => $Request->input(),
        ]);
    }


    /**
     * @param \pizepei\staging\Request $Request
     *      path [object] 路径参数
     *           id [string] path_id
     *           name [string] path_id
     * @return array [json]
     * @title  命令行cli模式
     * @explain 命令行cli模式运行方式: php index_cli.php --route /dome/cli/001/pizpe(命令行模式请求参数请使用path方式)
     * @router cli cli/:id[string]/:name[string]
     * @throws \Exception
     */
    public function cli(Request $Request)
    {
        $terminalInfo = TerminalInfo::getArowserPro();
        /**
         * 存储经纬度信息
         */
        $IpInfo = $terminalInfo['IpInfo'];
        $data   = @array_merge($IpInfo, $terminalInfo);
        if(isset($data['point'])){
            $data['point'] = ['GeomFromText', 'POINT('.$data['point']['x'].' '.$data['point']['y'].')'];
        }
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $TerminalInfo       = TerminalInfoModel::table();
        $this->succeed(['location' => $TerminalInfo->insert([$data, $data, $data], false), 'path' => $Request->path(), 'input' => $Request->input()]);
    }




    /**
     * @return array [json]
     *      requestId [uuid] 当前请求id
     * @title  获取当前请求id
     * @explain 获取当前请求id,请求id是时空内唯一的
     * @router get request
     * @throws \Exception
     */
    public function Request()
    {
        return $this->succeed(['requestId' => __REQUEST_ID__]);
    }

    /**
     * @Author pizepei
     * @Created 2019/2/16 22:18
     *
     * @param \pizepei\staging\Request $Request
     *      path [object] 路径参数
     *           user [int] path_id
     * @title  路径混合参数演示
     * @explain
     * @return array [object]
     *      user [int] 用户id
     * @router get /dd:user[int]/index.txt
     */
    public function path(Request $Request)
    {
        return $this->succeed($Request->path());
    }

    /**
     * @Author pizepei
     * @Created 2019/2/16 22:23
     *
     * @return array [json]
     * @title 获取路由信息
     * @explain 路由对象在框架初始化时就实例化了，同时该对象一直保留,在框架控制器、模型等框架初始化后的所有地方都可直接使用 Route::init()获取到该对象
     * @router get route
     */
    public function getRoute()
    {
        $Route = Route::init();

        return [
            'controller' => $Route->controller,//控制器
            'module'     => $Route->module,//模块
            'method'     => $Route->method,//控制器方法
            'atPath'     => $Route->atPath,//路径
            'atRoute'    => $Route->atRoute,//路由
        ];
    }

    /**
     * @Author pizepei
     * @Created 2019/2/16 22:24
     *
     * @return array [json]
     * @title  获取缓存
     * @explain 获取缓存
     * @router get cache
     *
     */
    public function cache()
    {
        /**
         * 设置缓存
         */
        $result = Cache::set(['test', 'data'], ['ddd', 'ddd']);
        /**
         * 读取缓存
         */
        $data = Cache::get(['test', 'data']);

        return ['result' => $result, 'cache' => $data];
    }

    /**
     * @Author pizepei
     * @Created 2019/2/16 22:34
     * @throws \Exception
     * @param \pizepei\staging\Request $Request
     *      post [object] 插入数据
     *          content [object] 模拟数据
     *             name [string] key
     *             value [string] 值
     * @return array [json] 插入结果
     *
     * @title   数据库操作->add
     * @explain 框架模型操作-.增加数据操作
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     * @router post db
     *
     */
    public function dbAdd(Request $Request)
    {

        $Test = TestModel::table();

        return $this->succeed($Test->add(
            $Request->input('', 'post')
        ), '一个增加操作');
    }

    /**
     * @Author pizepei
     * @Created 2018/12/2 22:44
     *
     * @return array [json]
     * @throws \Exception
     *
     * @title  方法标题（一般是方法的简称）
     * @explain 一般是方法功能说明、逻辑说明、注意事项等。
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     *
     * @router get jwt
     */
    public function jwt()
    {
        //Test::table();
        //return ['jwt'];
        //JsonWebToken::Payload
        $JsonWebToken = new JsonWebToken([], 'common');

        return $JsonWebToken->setJWT();
    }

    /**
     * @Author pizepei
     * @Created 2019/01/2 22:44
     *
     * @return array [json]
     * @throws \Exception
     *
     * @title  获取uuid
     * @explain 一般是方法功能说明、逻辑说明、注意事项等。
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     *
     * @router get uuid
     */
    public function uuid()
    {

        //Db::table();

        $Uuid = Uuid::table();
        $Uuid->insert(
            [
                ['Build' => ['33333', 'dddss']],
                ['Build' => ['dddd', '44444']],
            ]
        );
        //$Uuid->get('b9dd397d-05fc-a87c-3290-4b7760f19542');


        //return ['db-uuid'=>Db::getUuid(),'func'=>Func::M('str')::getUuid(),'insert'=>$Uuid->insert(
        //    [
        //        ['Build'=>['dddd2','dddss']],
        //        ['Build'=>['dddd','dddss2']],
        //    ]
        //)];
    }

    /**
     * @Author: pizepei
     * @Created: 2019/01/2 22:44
     *
     * @return array [json]
     * @throws \Exception
     *
     * @title  获取随机数字
     * @explain 一般是方法功能说明、逻辑说明、注意事项等。
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     *
     * @router get int-rand
     */
    public function int_rand()
    {
        return Func::M('str')::int_rand(10);

    }

    /**
     * @Author: pizepei
     * @Created: 2019/01/2 22:44
     *
     * @return array [json]
     * @throws \Exception
     *
     * @title  获取随机字符串
     * @explain 一般是方法功能说明、逻辑说明、注意事项等。
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     *
     * @router get str-rand debug:true
     */
    public function str_rand()
    {
        return Func::M('str')::str_rand(10);
    }

    /**
     * @Author: pizepei
     * @Created: 2019/1/21 23:08
     *
     * @throws \Exception
     * @return array [object]
     * @title  账号获取列表
     * @explain
     * @router get sms
     */
    public function sms()
    {
        $Sms = new Sms();

        return $Sms->SendCode('register', 13266579753);
    }

    /**
     * @Author: pizepei
     * @Created: 2019/1/21 23:08
     *
     * @throws \Exception
     * @return array [object]
     * @title  账号获取列表
     * @explain
     * @router get redis
     */
    public function redis()
    {
        Cache::set(['test','bbt'],[0=>'45']);
        return Cache::get(['test','bbt']);
        /**
         *        \pizepei\model\reids\Redis
         */
        //$redis = new Redis();
        //$redis = new Redis();
        //RedisModel::class
    }

    /**
     * @Author pizepei
     * @Created 2019/2/17 16:23
     *
     * @param \pizepei\staging\Request $Request
     *      post [object] post
     *          string [string required] 被搜索的字符串
     *          expression [string required] 使用的表达式
     * @return array [json]
     *
     * @throws \Exception
     * @title  正则表达式
     * @explain 正则表达式实验
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     *
     * @router post preg_match
     */
    public function preg_match(Request $Request)
    {
        preg_match($Request->input('expression', 'post'), $Request->input('string', 'post'), $result);

        return $this->succeed($result);
    }

    /**
     * @Author pizepei
     * @Created 2019/3/23 16:23
     *
     * @param \pizepei\staging\Request $Request
     *      post [object] post
     *          phone [int number] 手机号码
     *          password [string required] 密码
     *          code [string required] 验证码
     *          codeFA [string] 2FA双因子认证code
     * @return array [json]
     *
     * @throws \Exception
     * @title  登录验证
     * @explain 登录验证
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     * @authGroup admin.del:删除账号操作,user.del:删除账英国号操作,user.add:添加账号操作
     * @authExtend UserExtend.list:删除账号操作,UserExtend.add:删除账号操作
     * @router post logon
     */
    public function logon(Request $Request)
    {
        /**
         * 图形验证码系统
         */

        /**
         * 查询账号是否存在（可能会是邮箱  或者用户名）
         * 用户编码 为用户唯一标准     不同的用户编码  可以是同一个手机号码、或者邮箱   ？
         */
        $Account = AccountModel::table()
            ->where(['phone'=>$Request->post('phone')])
            ->fetch();
            //->replaceField('fetch',['type','status']);
        //$Account = AccountModel::table()
        //    ->where(['phone'=>$Request->post('phone')])
        //    ->cache(['Account','info'])
        //    ->replaceField('fetch',['type','status']);
        if(empty($Account)){
            return $this->error($Request->post('phone'),'用户或密码错误');
        }
        $AccountService = new AccountService();

        $result =  $AccountService->logon(\Config::ACCOUNT,$Request->post(),$Account,$this);
        if(isset($result['jwtArray']['str']) && $result['jwtArray']){
            return $this->succeed([
                'result'=>$result,
                'access_token'=>$result['jwtArray']['str']
            ],'登录成功');
        }
        return $result;
    }

    /**
     * @Author pizepei
     * @Created 2019/3/23 16:23
     *
     * @param \pizepei\staging\Request $Request
     *      post [object] post
     *          phone [int number] 手机号码
     *          password [string required] 密码
     *          email [string email] 邮箱
     *          code [string required] 验证码
     * @return array [json]
     *
     * @throws \Exception
     * @title  注册账号
     * @explain 基础注册账号
     * @authTiny 微权限提供权限分配 [获取店铺所有  获取所有店铺  获取一个]
     *
     * @router post register
     */
    public function register(Request $Request)
    {
        $AccountService = new AccountService();
        return $AccountService->register(\Config::ACCOUNT,$Request->post(),$this);
    }

    /**
     * @Author pizepei
     * @Created 2019/3/30 21:33
     *
     * @param \pizepei\staging\Request $Request
     *      post [object] post
     *          phone [int number] 手机号码
     *          password [string required] 密码
     *          code [string required] 验证码
     * @return array [json]
     *
     * @title  方法标题（一般是方法的简称）
     * @explain 一般是方法功能说明、逻辑说明、注意事项等。
     * @authTiny 修改密码
     * @throws \Exception
     * @router post changePassword
     */
    public function changePassword(Request $Request)
    {
        $Account = AccountModel::table()
            ->where(['phone'=>$Request->post('phone')])
            ->replaceField('fetch',['type','status']);
        if(empty($Account)){
            $this->error($Request->post(),'用户不存在');
        }
        $AccountService = new AccountService();
        return $AccountService->changePassword(\Config::ACCOUNT,$Request->post(),$Account,$this);

    }
    /**
     * @Author pizepei
     * @Created 2019/3/30 21:33
     * @param \pizepei\staging\Request $Request
     * @return array [json]
     * @title  验证jwt
     * @explain 一般是方法功能说明、逻辑说明、注意事项等。
     * @authTiny 修改密码
     * @authGroup admin.del:删除管理员账号操作,user.del:删除账号操作,user.add:添加账号操作
     * @authExtend UserExtend.list:删除账号操作
     * @throws \Exception
     * @baseAuth UserAuth:test
     * @router get decodeLogonJwt
     */
    public function decodeLogonJwt( Request $Request)
    {
        // *方法路由：注册到不同操作权限资源里面用authGroup【admin.bbx:user.bbx】中文名字、注册扩展扩展authExtend  控制器：方法（方法里面有返回数据、）
        $AccountService = new AccountService();
        $Redis = Redis::init();
        return ['authExtend'=>$this->authExtend,'Payload'=>$this->Payload];
        //return $AccountService->decodeLogonJwt('common',$Request->input('access_token'),$Redis);
    }


}