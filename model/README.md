**数据库模型目录**
<br>
**命名规范：**
<br>必须大写字母开头以Model结束
<br>类名称为表名称中间的大写会转成下划线

**目录规范：**
<br>功能模块为目录区分
<br>
**编写规范：**
<br>1、模型类必须继承bd来的继承者Model类
<br>2、模型类只做数据库表的定义和维护
<br>3、业务处理在service目录进行编写
<br>4、推荐生产环境使用TableAlterLogModel::table()->initStructure()来批量更新表结构（只适合model目录下以model命名空间开始的类）