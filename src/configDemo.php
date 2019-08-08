<?php
return [
    'auth'  => [
        'auth_on'           => 1, // 权限开关
        'auth_type'         => 1, // 认证方式，1为实时认证；2为登录认证。
        'auth_group'        => 'y_auth_group', //和Database/migrations 定义的迁移文件一致
        'auth_group_access' => 'y_auth_group_access', //和Database/migrations 定义的迁移文件一致
        'auth_rule'         => 'y_auth_rule', //和Database/migrations 定义的迁移文件一致
        'auth_user'         => 'y_user', // 和Database/migrations 定义的迁移文件一致
    ],
    'path' => [
        'layui_css' => 'static/js/plugins/layui/css/layui.css',
        'layui_js' => 'static/js/plugins/layui/layui.js',
        'jquery' => '/static/js/jquery.min.js',
    ]

];