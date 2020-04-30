# normative
normative致力于在框架层次强制规范开发人员的业务实现来确保实现更高效团队的团队协作与降低后期维护成本。
### normative特性：
* 强大的注解来规范
    * 路由的由控制器中的注解来定义
    * 每个路由的请求数据格式、数据类型、权限配置由注解来定义（不规范的请求数据会被框架的Request类强制过滤并转换成定义的数据类型）。
    * 每个路由的返回数据格式、数据类型由注解来定义（不规范的返回数据会被框架的Request类强制过滤并转换成定义的数据类型）。
    * 每个路由的权限由注解来定义（开实现强大的自定义权限控制，比如可控制到不同的用户访问同一个路由选择性的返回数据）。
    * 自动的根据注解生成API文档、权限文档。    
* 支持更多的PSR规范
* 完美适配PhpStorm IDE 提供settings.zip配置文件使开发更加规范便捷。
* 完美支持SAAS模式
* 自动化的Db控制
    * 精力有限只做了MySQL5.7的适配
    * 开发者按照规范（表版本、表结构修改、表创建、初始化表数据）构造Model类可实现：
        * 自动管理表版本（在项目开发甚至上线后的维护时都会出现不同程度的表结构修改，每次表结构的修改都设置有一个版本号），db模型可自动判断表是否存在，不存在就根据设置的当前版本号创建表，表存在会判断表版本号是否与当前数据库表版本号一致，不一致根据对应版本自动修改表结构，此方法非常适合SAAS模式下的表结构同步和开发环境与生产环境的同步。同时记录了每次表结构的修改信息也可以通过设置当前版本号来切换到对应的表结构中去。
        * 创建表的步骤是由Db模型负责，可设置Db模型在创建表成功后做初始化数据的插入，插入数据来源目前支持直接在模型里面设置$initData类对应或者通过设置$initDataUrl定义外部请求当前（需要配置加密参数）。
    * 原则上不允许在Model类上写任何业务逻辑，Model类只是用来定义会维护数据库表，业务逻辑全部在项目目录下的service目录实现。
* 新的微服务模式
    * 框架的设计初衷是安全精简的微服务框架。
    * 下面介绍一个简单的微服务模式，一个项目可以拆分为下面几个微服务处理。
        * 账号权限微服务（建议使用JWT）。
        * 文件微服务。
        * 异步队列业务处理微服务（可与websocket配合）。
        * websocket服务。
        * 各业务微服务。 
* 高效的设计模式（DI依赖注入，DIC容器）
    * 详细介绍可谷歌
### 运行环境的简单介绍：
 + 1、推荐PHP7.0+版本+MySQL5.7+Nginx
 + 2、功能模块中大量运用到Redis因此是必须的
### 安装方式：
    方式一：  composer create-project pizepei/normative 项目名称   版本：dev-master为最新  不写为最新稳定版本
    方式二：  git clone --branch [tags标签] git@github.com:pizepei/normative.git   
             clone对应分支使用 git clone -b [分支]  git@github.com:pizepei/normative.git 
### 单元测试：
    composer require --dev phpunit/phpunit:8
### 模板引擎：
    composer require "twig/twig:~1.0"
### 开发规范
* 团队开发业务功能时可尽可能的以composer包形式开发方便代码维护和跨项目复用。
    * composer包可使用本地git源详情这样项目代码就不公开[https://getcomposer.org/doc/04-schema.md#repositories]
    * 本地源需要认证可创建auth.json文件[https://getcomposer.org/doc/articles/handling-private-packages-with-satis.md#authentication]当然团队成员在自己工作电脑上已经有SSH Keys 就不需要这个文件了
    * 如需要使用官方包管理又苦难速度感人可[命令行]使用代理<br>
### composer 代理加速
    export https_proxy='127.0.0.1:10808'
    export http_proxy='127.0.0.1:10808'
    composer update -vvv    查看是否使用代理
###资源分享
#### 软件
* 官方免费Xftp和Xshell [https://www.netsarang.com/en/free-for-home-school/]（这个是官方免费的只需要填写姓名和邮箱就可以收到一封带有下载地址的官方邮件）
#### PHP扩展安装
* PHP 扩展下载[http://pecl.php.net/]
* sql server 拓展安装（注意细节）
    * 准备工作:
        * 下载地址：[http://pecl.php.net/package/pdo_sqlsrv]
        * 加入微软的源 curl https://packages.microsoft.com/config/rhel/7/prod.repo > /etc/yum.repos.d/mssqlrelease.repo
        * 或者一次性 安装所有依赖包
            * 防止冲突先卸载原有版本(可选)  yum remove unixODBC 
            * yum -y install gcc gcc-c++ autoconf libjpeg libjpeg-devel libpng libpng-devel freetype freetype-devel libxml2 libxml2-devel zlib zlib-devel glibc glibc-devel glib2 glib2-devel bzip2 bzip2-devel ncurses ncurses-devel curl curl-devel e2fsprogs e2fsprogs-devel krb5-devel libidn libidn-devel openssl openssl-devel nss_ldap openldap openldap-devel  openldap-clients openldap-servers libxslt-devel libevent-devel ntp  libtool-ltdl bison libtool vim-enhanced  msodbcsql mssql-tools unixODBC-devel    
    * 编译安装pdo_sqlsrv驱动
        * 避免出现make: *** No rule to make target `install'. Stop.错误（因为缺少依赖包的原因，请执行上面的依赖安装命令）
        * 为了避免make 时出现【fatal error: sql.h: No such file or directory】错误 （ 安装unixodbc的工具包即可  yum install unixODBC-devel ）
        * 与mysql不同 的dbh  new PDO("sqlsrv:Server=localhost,端口号;Database=数据库", 用户名 , 密码); 
#### composer
* 命令composer dumpautoload 更新命名空间