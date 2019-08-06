<?php
return [
    'auth'  => [
        'auth_on'           => 1, // 权限开关
        'auth_type'         => 1, // 认证方式，1为实时认证；2为登录认证。
        'auth_group'        => 'y_auth_group', //和Database/migrations 定义的迁移文件一致
        'auth_group_access' => 'y_auth_group_access', //和Database/migrations 定义的迁移文件一致
        'auth_rule'         => 'y_auth_rule', //和Database/migrations 定义的迁移文件一致
        'auth_user'         => 'y_user', // 用户信息不带前缀表名
    ],
];