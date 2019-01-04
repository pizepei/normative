<?php
/**
 * Created by PhpStorm.
 * User: pizepei
 * Date: 2018/8/6
 * Time: 15:25
 * @baseAuth 基础权限继承（加命名空间的类名称）
 * @title 人脸识别模块
 * @authGroup [user:用户相关,admin:管理员相关] 权限组列表
 * @basePath /index/dome
 * @baseParam [$Request:pizepei\staging\Request] 注册依赖注入对象
 */

namespace app\index;
use pizepei\staging\Request;
use pizepei\staging\Controller;
use pizepei\model\cache\Cache;
use pizepei\staging\Route;
use pizepei\terminalInfo\TerminalInfo;
use pizepei\terminalInfo\ToLocation;
use pizepei\terminalInfo\UpdateQqwry;
use pizepei\model\db\Db;
class Index extends Controller
{
    /**
     * 获取人脸详情
     * @param  $Request
     *      path [object] 路径参数
     *           id [int:2 ddd] path_id
     *      rule [object] 常规路径
     *          id [int] rule_id
     * @return array [object] 数据
     *      id [uuid] id搜索
     *      objectType [int]  对象类型 0 陌生人 1 员工 2会员 3 其他
     *      objectId [string] 对象id 默认为0     员工为StaffModel的id    会员为CustomerModel id
     *      staffData [object] 对象信息 （员工信息）
     *              id [string] id
     *              accountId [string] 账号id
     *              name [string] 名字
     *      memberData [object] 对象信息 （会员信息）
     *          id [uuid] 会员信息
     *          sn [string] 会员卡
     *          mobile [string] 手机号码d
     *          referee [object] 推荐人  3
     *              id [string] id     6
     *              name [string] 名字
     *          ascription [object] 店铺关联
     *              id [string] 店铺id
     *              erpStoreId [string] erp id
     *      remark [string] 备注（类型其他时）
     *      mobile [string]  号码
     *      config [raw]
     *      data [objectList] 数据列表
     *          id [uuid]  id
     *          uid [int]  主要人脸id fcae_relevance表id
     *          status [string] 状态
     *          createAt [datetime]
     *          updateAt [datetime]
     *
     * @authTiny [获取店铺所有  获取所有店铺  获取一个]
     * @authGroup user
     * @router get  /router/:user[int]/:id[int]  auth:public
     */
    public function router($Request)
    {

        /**
         * 权限区分
            模块（控制器）
            方法组 （如用户的增加、修改、删除 是一个组）
            单一方法
         *
         * 完整的是 -- 控制器 ---》 功能组--》 路由
         */


        $int = 'int';
        $str = '12是多少2312312131.2sahd22';
        var_dump($str);
        /**
         * boolean，float，integer，array，null，object和string
         */
        $type = settype($str,$int);
        var_dump($type);

        var_dump($str);


//        echo phpinfo();exit;
        /**
         * /router/aad
         * /router
         *
         *
         * in_array()绝对匹配
         * 如果没有
         *  strpos()匹配
         *  匹配到 ltrim($str,"Hello")切割
         *
         */
        var_dump(strpos("/router/user/","/router/"));

        var_dump(strpos("/router/user/","/router/"));

        var_dump(ltrim("/router/routers/ssss","/router"));

        $Route = Route::init();


        return $Request->path();
        exit;
        $data = '    @router';
        preg_match('/@router/s',$data,$result);
        var_dump($result);
        $data = 'a@    ddddddd@ca
        [55555]@c';
        preg_match('/a@[ ]{1,6}(.*?)@ca[\n]{1,2}\[(.*?)\]@c/s',$data,$result);
        var_dump($result);
        /**
         * 注解快
         */
        $data =  file_get_contents(__FILE__);
        preg_match_all('/\/\*\*\r(.*?){/s',$data,$result);
//        var_dump($result[1]);
//        $dddddd= [];
        foreach ($result[1] as $k=>$v)
        {
            preg_match('/@router/s',$v,$resultData);
            if(!empty($resultData)){
                $dddddd[] =$v;
            }
        }
        /**
         * 获取方法
         */
        preg_match('/public[\s]{0,3}function[\s]{0,3}(.*?)[\s]{1,3}/s',$dddddd[0],$result);
        var_dump($result[1]);
        $method = $result[1];
//        var_dump($dddddd);
        preg_match('/@router(.*?)\r/s',$dddddd[0],$routerData);
        var_dump($routerData);

        preg_match_all('/[^ ]{1,10}[A-Z-a-z:]{1,30}/s',$routerData[1],$routerData);
        var_dump($routerData);

//        var_dump(explode(' ',$routerData[1]));



        preg_match('/@(.*?)@/s',$dddddd[0],$result);
    var_dump(explode('@',$dddddd[0]));
        var_dump($result);

        exit;

        $array = [];
        //echo __FILE__;
        $data =  file_get_contents(__FILE__);
        /**
         * 获取命名空间
         */
        //$namespace;
        preg_match('/\/\*\*\r(.*?)\*\//s',$data,$result);
        preg_match('/@title (.*?)\r/s',$result[1],$title);
        preg_match('/namespace (.*?);/s',$data,$namespace);
        preg_match('/class (.*?) /s',$data,$class);
        $array['namespace'] = [$namespace[1]=>['title'=>$title[1],'class'=>$class[1]]];
        /**
         * 注解快
         */
        preg_match_all('/\/\*\*\r(.*?){/s',$data,$result);
        /**
         * 分析提取注解快
         */
        foreach ($result[1] as $k=>$v)
        {
            preg_match('/@router(.*?)\r/s',$v,$routerData);
            preg_match('/public[\s]{0,3}function[\s]{0,3}(.*?)[\s]{1,3}/s',$v,$functionData);
            if(!empty($resultData) && !empty($functionData)){
                /**
                 * 获取详细方法
                 */
                preg_match_all('/[^ ]{1,10}[A-Z-a-z:]{1,30}/s',$routerData[1],$routerData);
                var_dump($routerData);

                /**
                 * 检测路由
                 * 1 请求方法
                 * 2 路由路径
                 * 3 返回类型
                 */


                $method = $functionData[1];
                $annotationData[$functionData[1]] =$v;
            }
        }


        //var_dump($array['namespace']['customer\action\manage']);
        //$array['namespace']['customer\action\manage'] = ['title'=>$title[1]];
        var_dump($array);
//        var_dump($data);
//        exit;
        //preg_match_all('/\/\*\*\r(.*?)\)\r/s',$data,$method);
        preg_match_all('/\/\*\*\r(.*?)\{/s',$data,$method);


        var_dump($method[1]);
        exit;

        //var_dump($result);


        preg_match_all('/\/\*\*\r(.*?)\*\//s',$data,$result);
        //preg_match_all('/\/\*\*\r(.*)/',$data,$result);
        //var_dump($result[1][6]);
        preg_match('/\@return(.*?) @/s',$result[1][6],$result);
        var_dump($result[1]);
        preg_match_all('/ (.*?)\r/s',$result[1],$result);
        var_dump($result[1][2]);
        preg_match('/[\w]{1,20}/s',$result[1][2],$result);
        var_dump($result);
        //preg_match('/ [a-z] /s',$result[1],$result);
        //var_dump($result);
        //exit;


    }
    /**
     * @param $Request
     *      direct_id [string] 主id
     *      from_id [string] 从id（集合json   [id，id，id]）
     * @return array [objectList] 数据
     *      id [string] id
     * @router get /index auth:public
     */
    public function index($Request)
    {
//        var_dump($Request->input());
//        echo $Request->input(['post','dex','int']);

        /**
         * url
         */
//        $Request->setUrl('/test',['a'=>'b','b'=>'c']);
        /**
         * 重定向
         */
        $Request->Redirect($Request->setUrl('/test',['a'=>'b','b'=>'c']));
        echo '我是首页';
    }

    /**
     * @param $Request
     *      direct_id [string] 主id
     *      from_id [string] 从id（集合json   [id，id，id]）
     * @return array [objectList] 数据
     *      id [string] id
     * @router get router/:uid[int]
     */
    public function terminalInfo($Request)
    {
        //var_dump($Request);

        /**
         * 存储经纬度信息
         */
        $terminalInfo = terminalInfo::getArowserPro();
        $IpInfo = $terminalInfo['IpInfo'];
        $data = array_merge($IpInfo,$terminalInfo);
        if (isset($data['point'])){
            $data['point'] = ['GeomFromText','POINT('.$data['point']['x'].' '.$data['point']['y'].')'];
        }
        $Build = '';
        if (isset($data['Build'])){
            $Build = implode('|',$data['Build']);
            $data['Build'] =json_encode($data['Build']);
        }
        $data['user_agent'] =  $_SERVER['HTTP_USER_AGENT'];
        $data['create_time'] = date('Y-m-d H:i:s');
        //$mode = Db::table('terminal_info');
        $TerminalInfo = \model\TerminalInfo::table($data);
        //$TerminalInfo = \model\db\TerminalInfo::table();
        //$data['IpInfo'] = json_encode($data['IpInfo']);
        return $TerminalInfo->insert($data);
        //return $data;


        return [
            'INSERT'=>$mode->insert($data,false),
            '省'=>$IpInfo['province'],
            '市|区'=>$IpInfo['city'],
            '运营商'=>$IpInfo['isp'],
            '运营商网络'=>$IpInfo['NetworkType'],
            '经纬度X'=>isset($IpInfo['point']['x'])?$IpInfo['point']['x']:'000',
            '经纬度Y'=>isset($IpInfo['point']['y'])?$IpInfo['point']['y']:'000',
            '浏览器'=>$data['Ipanel'],
            '语言'=>$data['language'],
            '系统'=>$data['Os'],
            '浏览器网络'=>$data['NetType'],
            '当前IP地址'=>$data['ip'],
            'terminal'=>$Build,
        ];
    }
    /**
     * @param $Request
     *      direct_id [string] 主id
     *      from_id [string] 从id（集合json   [id，id，id]）
     * @return array [objectList] 数据
     *      id [string] id
     * @router get /test.html auth:public
     */
    public function test($Request='')
    {

        var_dump($Request);
        //echo dechex('10090239');

//        $test = new Test();
//        $test2 = $test;
//        var_dump($test->data);
//        $test->data = ['test'=>'然后22'];
//        var_dump($test->data);



//        var_dump($test2->data);

        //        $data = file_get_contents('https://oauth.heil.top/db?a=dddd');
//var_dump($data);
//        var_dump(json_decode($data,true));
        $ToLocation = new ToLocation();
        return ['test'];

//        $data = new UpdateQqwry;


//        var_dump($this->read_qqip('..'.DIRECTORY_SEPARATOR.'runtime'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR));


//        $ip = gethostbyname('www.csdn.net');
//        $num_ip =  ip2long($ip);
//        echo $num_ip,'<br/>';
//        echo long2ip($num_ip);

//        var_dump(TerminalInfo::getArowserInfo());

//        var_dump(ip2long('255.255.255.255'));
//        exit;
//        var_dump(TerminalInfo::get_ip());

//       echo  dirname(__FILE__).DIRECTORY_SEPARATOR;

        /**
         * 路由类
         */
//        $Route = Route::init();
        /**
         * 请求类
         */
//        var_dump($dsdsds);
//        $Request = Request::init();
//        return ['code'=>001,'msg'=>'比如这样','data'=>['获取请求控制器'=>$Route->controller,'获取请求控制器方法'=>$Route->method]];
//        return $Request->input('a');
    }


    /**
     * 数据库测试
     */
    public function db(){


        /**
         * 实例化
         */
        $mode = Db::table('ip_white');

        /**
         * 批量删除
         */
        /**
            $where['ip'] = 343434;
            var_dump($mode->where($where)->del([3357,3361,3377,3384]));
         **/
        /**
         * 插入或者修改
         * 自动检测是否有主键 有为更新  没有为插入
         *
         * 注意：批量插入时返回的是成功插入的第一条 id
         * 批量插入、更新无法判断成功多少条(业务)，只能判断sql插入是否成功
         */
//        $data = [
//            ['ip'=>1000000000,'test'=>45545454],
//            ['ip'=>'pi','test'=>888888888],
//            ['ip'=>3434343,'test'=>455445],
//        ];
        /**
         * 批量更新
         */
//        $data = [
//        ['id'=>20381,'ip'=>000000,'test'=>'村上春树'],
//        ['id'=>20380,'ip'=>000000,'test'=>'村上春树'],
//        ];
        /**
         * 开启事务
         */
//        $mode->beginTransaction();

//        var_dump($mode->inTransaction());
//        var_dump($mode->insert($data));
        /**
         * 提交事务
         */
//         $mode->commit();
        /**
         * 回滚事务
         */
//        var_dump( $mode->rollBack());

//        var_dump($mode->sqlLog);
        /**
         * 更新一条
         */
        //var_dump($mode->insert(['id'=>$mode->insert($data),'ip'=>000000,'test'=>'村上春树']));

        /**
         * 查询方法
         */
//        $where['ip'] = ['LIKE','%3'];
//        $where['ip'] = ['EQ','19.55.55.55'];
//        $where['ip|test'] = ['LIKE','%3'];
//        $where['ip|test'] = '3434343';
        //$where['ip'] = '3434343';
        /**
         * ['字段或者函数'=>'别名']
         */
        //var_dump($mode->field(['ip'=>'ip地址','id'=>'主键','count(id)'=>'所有数据数量'])->where($where)->fetchAll());

        // $mode->field(['ip','id'])->where($where)->forceIndex('id')->fetch();
        //var_dump($mode->sqlLog);
        /**
         * 根据主键获取
         * cache 缓存方法
         */
//        var_dump($mode->get(20637));

//        var_dump($mode->cache(['src','datastets'],20)->get(20637));
    }
    /**
     *缓存
     */
    public function Cache()
    {
        echo filemtime('qqwry.dat');
        //var_dump(pizepei\model\cache\Cache::get('public','db'));
//        Cache::get('public','db');

    }


    function read_qqip($qq_datafile)
    {
        if(!$fd = @fopen($qq_datafile, 'rb')){
            return 'Invalid IP data file';
        }


        //获取文件的前8个字节
        if(!($DataBegin = fread($fd, 4)) || !($DataEnd = fread($fd, 4)) ) return;
        //$ipbegin指向第一个起始IP的位置(索引区)
        @$ipbegin = implode('', unpack('L', $DataBegin));
        if($ipbegin < 0) $ipbegin += pow(2, 32);
        //$ipend指向最后一个起始IP的位置(索引区)
        @$ipend = implode('', unpack('L', $DataEnd));
        if($ipend < 0) $ipend += pow(2, 32);
        //索引区每条记录的长度为7个字节，$ipAllNum表示的是IP段的个数
        $ipAllNum = ($ipend - $ipbegin) / 7 + 1;


        //在起始IP区进行索引
        $result = array(array());
        for($i = 0; $i < $ipAllNum; $i++)
        {
            fseek($fd, $ipbegin + 7 * $i);
            $ip_start = fread($fd, 4);  //读取IP段的起始IP的二进制串

            if(strlen($ip_start) < 4){
                fclose($fd);
                return 'System Error';
            }
            $ip_start = implode('', unpack('L', $ip_start));
            if($ip_start < 0) $ip_start += pow(2, 32);
            $result[$i]['IP_START'] = $ip_start;   //获取IP段的起始IP值

            $DataSeek = fread($fd, 3);  //寻找结束IP
            if(strlen($DataSeek) < 3) {
                fclose($fd);
                return 'System Error';
            }
            $DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
            fseek($fd, $DataSeek);
            $ip_end = fread($fd, 4);   //结束IP二进制码
            if(strlen($ip_end) < 4) {
                fclose($fd);
                return 'System Error';
            }
            $ip_end = implode('', unpack('L', $ip_end)); //结束IP值
            if($ip_end < 0) $ip_end += pow(2, 32);
            $result[$i]['IP_END'] = $ip_end;  //读取结束IP值

            $ipAddr1 = '';
            $ipAddr2 = '';
            //下面开始读取国家和地区信息
            $ipFlag = fread($fd, 1);  //指向国家串前的一个字节
            if($ipFlag == chr(1)) {  //为0x01表明国家、地区与前面的IP信息重复
                $ipSeek = fread($fd, 3);  //国家、地区字符串的偏移量
                if(strlen($ipSeek) < 3) {
                    fclose($fd);
                    return 'System Error';
                }
                $ipSeek = implode('', unpack('L', $ipSeek.chr(0)));
                fseek($fd, $ipSeek);   //返回到国家、地区偏移量处
                $ipFlag = fread($fd, 1);
            }
            if($ipFlag == chr(2)) { //为0x02,表明国家串与前面的国家或地区重复
                $AddrSeek = fread($fd, 3);  //国家串的偏移量
                if(strlen($AddrSeek) < 3) {
                    fclose($fd);
                    return 'System Error';
                }
                $ipFlag = fread($fd, 1); //读取地区串前的第一个字节
                if($ipFlag == chr(2)) {  //出现0x02说明地区串与前面的国家或地区串重复
                    $AddrSeek2 = fread($fd, 3);   //地区串的偏移量
                    if(strlen($AddrSeek2) < 3) {
                        fclose($fd);
                        return 'System Error';
                    }
                    $AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
                    fseek($fd, $AddrSeek2);
                } else {
                    fseek($fd, -1, SEEK_CUR);
                }
                while(($char = fread($fd, 1)) != chr(0))
                    $ipAddr2 .= $char;
                $AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
                fseek($fd, $AddrSeek);
                while(($char = fread($fd, 1)) != chr(0))
                    $ipAddr1 .= $char;
            }else {//国家串不与前面重复
                fseek($fd, -1, SEEK_CUR);
                while(($char = fread($fd, 1)) != chr(0))
                    $ipAddr1 .= $char;  //读取国家串
                $ipFlag = fread($fd, 1);
                if($ipFlag == chr(2)) {  //地区串与前面的串重复
                    $AddrSeek2 = fread($fd, 3);
                    if(strlen($AddrSeek2) < 3) {
                        fclose($fd);
                        return 'System Error';
                    }
                    $AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
                    fseek($fd, $AddrSeek2);
                } else {
                    fseek($fd, -1, SEEK_CUR);
                }
                while(($char = fread($fd, 1)) != chr(0))
                    $ipAddr2 .= $char;  //地区串
            }
            if(preg_match('/http/i', $ipAddr2)) {
                $ipAddr2 = '';
            }

            $ipaddr = "$ipAddr1";
            $ipaddr = preg_replace('/CZ88\.NET/is', '', $ipaddr);
            $ipaddr = preg_replace('/^\s*/is', '', $ipaddr);
            $ipaddr = preg_replace('/\s*$/is', '', $ipaddr);
            if(preg_match('/http/i', $ipaddr) || $ipaddr == '') {
                $ipaddr = 'Unknown';
            }
            $ipaddr = mb_convert_encoding($ipaddr, "utf-8", "gb2312");
            $ipAddr2 = mb_convert_encoding($ipAddr2, "utf-8", "gb2312");
            $result[$i]['BIG_AREA'] = $ipaddr;
            $result[$i]['SMALL_AREA'] = $ipAddr2;
            //echo $result[$i]['BIG_AREA'].'---'.$result[$i]['SMALL_AREA'].'<br>';

        }
        return $result;
    }





    public function test1()
    {
        $Request = Request::init();
        /**
         * 重定向
         */
        $Request->Redirect($Request->setUrl('/test2',['a'=>'b','b'=>'c']));

    }

    public function test2()
    {
        $Request = Request::init();
        /**
         * 重定向
         */
        $Request->Redirect($Request->setUrl('/test3',['a'=>'b','b'=>'c']));

    }
    public function test3()
    {
        $Request = Request::init();
        /**
         * 重定向
         */
        $Request->Redirect($Request->setUrl('/test4',['a'=>'b','b'=>'c']));

    }

    public function test4()
    {
        $Request = Request::init();
        /**
         * 重定向
         */
        echo 'sssssssssss5555555555555555555';
//        $Request->Redirect($Request->setUrl('/test5',['a'=>'b','b'=>'c']));
    }



















}