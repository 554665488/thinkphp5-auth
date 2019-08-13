<?php
return [
    'table'  => [
        // 和Database/migrations 定义的迁移文件一致
        'auth_group'        => 'auth_group', //权限组
        'auth_group_access' => 'auth_group_access', //权限组和用户关联中间表
        'auth_rule'         => 'auth_rule', //权限规则表
        'auth_user'         => 'user', //用户表
        'user_role'         => 'user_role', //系统用户角色表
        'group_auth'        => 'group_auth', //权限组和权限规则关联表
        'role_access'       => 'role_access', //权限组和权限规则关联表
    ],
    'switch'=>[
        'auth_on'           => 1, // 权限开关
        'auth_type'         => 1, // 认证方式，1为实时认证；2为登录认证。
    ],
    'path' => [
        'layui_css' => '/static/js/plugins/layui/css/layui.css',
        'layui_js' => '/static/js/plugins/layui/layui.js',
        'jquery' => '/static/js/jquery.min.js',
        'extend_config' => '/static/js/plugins/layui/config.js',
        'formSelectsCss' => '/static/js/plugins/layui/extend/fromSelect/formSelects-v4.css',
    ],
    //数据列表配置
    'table_config' => [
        'limit' => 30 //获取列表数据的数量
    ]
];