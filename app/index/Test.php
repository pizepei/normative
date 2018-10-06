<?php
namespace app\index;

class Test {
    // 路由表
    public $routers = array(
        array("name"=>"userlist", "pattern"=>"get /user", "action"=>"User#get"),
        array("name"=>"userinfo", "pattern"=>"get /user/:s", "action"=>"User#getById"),
        array("name"=>"useradd", "pattern"=>"post /user", "action"=>"User#add"),
        array("name"=>"userupdate", "pattern"=>"update /user", "action"=>"User#update"),
        array("name"=>"userdel", "pattern"=>"delete /user/:id", "action"=>"User#delete")
    );

    public $data = array(
        'cccc'=>222222,
    );


}
?>