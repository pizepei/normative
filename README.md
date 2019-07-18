# normative
normative致力于在框架层次强制规范开发人员的业务实现了确保实现更高效团队的团队协作与降低后期维护成本。
### normative特性：
* 强大的注解来规范
    * 路由的由控制器中的注解来定义
    * 每个路由的请求数据格式、数据类型、权限配置由注解来定义（不规范的请求数据会被框架的Request类强制过滤并转换成定义的数据类型）。
    * 每个路由的返回数据格式、数据类型由注解来定义（不规范的返回数据会被框架的Request类强制过滤并转换成定义的数据类型）。
    * 每个路由的权限由注解来定义（开实现强大的自定义权限控制，比如可控制到不同的用户访问同一个路由选择性的返回数据）。
    * 自动的根据注解生成API文档、权限文档。
* 完美支持SAAS模式
* 自动化的Db控制
    * 精力有限只做了MySQL5.7的适配
    * 开发者按照规范（表版本、表结构修改、表创建、初始化表数据）构造Model类可实现：
        * 自动管理表版本（在项目开发甚至上线后的维护时都会出现不同程度的不结果修改，每次表结构的修改的设置有一个版本号），db模型可自动判断表是否存在，不存在就根据设置的当前版本号创建表，表存在会判断表版本号是否与当前数据库表一致不一致根据对应版本自动修改表结构，此方法非常适合SAAS模式下的表结构同步和开发环境与生产环境的同步。同时记录了每次表结构的修改信息也可以通过设置当前版本号来切换到对应的表结构中去。
        * 创建表的步骤是由Db模型负责，可设置Db模型在创建表成功后做初始化数据的插入，插入数据来源目前支持直接在模型里面设置$initData类对应或者通过设置$initDataUrl定义外部请求当前（需要配置加密参数）。
* 新的微服务模式
    * 框架的设计初衷是安全精简的微服务框架。
    * 下面介绍一个简单的微服务模式，一个项目可以拆分为下面几个微服务处理。
        * 账号权限微服务（建议使用JWT）。
        * 文件微服务。
        * 异步队列业务处理微服务（与websocket配合）。
        * websocket服务。
        * 各业务微服务。      
### 运行环境的简单介绍：
 + 1、推荐PHP7.0+版本+MySQL5.7+Nginx
 + 2、功能模块中大量运用到Redis
### 安装方式：
    方式一：  composer create-project pizepei/normative 项目名称   版本：dev-master为最新  不写为最新稳定版本
    方式二：  git clone --branch [tags标签] git@github.com:pizepei/normative.git   
             clone对应分支使用 git clone -b [分支]  git@github.com:pizepei/normative.git 
### 单元测试：
    composer require --dev phpunit/phpunit:8
### 开发规范
* 团队开发业务功能时可尽可能的以composer包形式开发方便代码维护和跨项目复用。
    * composer包可使用本地git源详情这样项目代码就不公开[https://getcomposer.org/doc/04-schema.md#repositories]
    * 本地源需要认证可创建auth.json文件[https://getcomposer.org/doc/articles/handling-private-packages-with-satis.md#authentication]当然团队成员在自己工作电脑上已经有SSH Keys 就不需要这个文件了