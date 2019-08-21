<?php
# 1、clone 项目
# 2、composer install
# 3、根据配置生成配置文件
return [
    # 应用目录
    'app'=>[
        'name'        =>'第一个应用',
        'explain'      =>'说明',
        'prefix'      =>'', #    nginx转发配置
        'config-require'=>[ #   需求的config   默认Config、Dbtabase、Deploy、ErrorOrLogConfig、Service
            'JsonWebTokenConfig'=>[

            ],
        ]
    ],
    # 环境需求
    'require'=>[
        'php'=>'7.3',
        'redis'=>true,
    ],

];