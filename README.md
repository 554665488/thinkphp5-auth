# think-addons
The ThinkPHP5.1 Auth Package 
基于thinkphp5.1 简单的auth验证
#Email 554665488@qq.com
## 安装
> composer require yfl/thinkphp5-auth:2.0.1

```可以自定义的配置 /config/auth.php
return [
    'table'  => [
        // 和Database/migrations 定义的迁移文件一致
        'group'        => 'group', //权限组
        'auth_group_access' => 'auth_group_access', //权限组和用户关联中间表
        'auth'         => 'auth', //权限规则表
        'user'         => 'user', //用户表
        'role'         => 'role', //系统用户角色表
        'group_auth'        => 'group_auth', //权限组和权限规则关联表
        'user_role_access'       => 'user_role_access', //权限组和权限规则关联表
    ],
    'switch'=>[
        'auth_on'           => 1, // 权限开关
        'auth_type'         => 1, // 认证方式，1为实时认证；2为登录认证。
    ],
    基于layui 组件里边的layui文件放到public目录下 改成为你的目录
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
路由地址
Route::group('auth', [
    //user
    'user_list' => ['thinkAuth\Controller\Users@userList', ['method' => 'get']],
    'ajax_get_user_list' => ['thinkAuth\Controller\Users@ajaxGetUserList', ['method' => 'get,post']],
    'ajax_add_user' => ['thinkAuth\Controller\Users@ajaxAddUser', ['method' => 'get.post']],
    'ajax_del_user' => ['thinkAuth\Controller\Users@ajaxDelUser', ['method' => 'post']],
    'ajax_edit_user' => ['thinkAuth\Controller\Users@ajaxEditUser', ['method' => 'get,post']],
    //auth
    'auth_list' => ['thinkAuth\Controller\Auth@authList', ['method' => 'get']],
    'ajax_get_auth_list' => ['thinkAuth\Controller\Auth@ajaxGetAuthList', ['method' => 'get']],
    'ajax_add_auth' => ['thinkAuth\Controller\Auth@ajaxAddAuth', ['method' => 'get,post']],
    'ajax_edit_auth' => ['thinkAuth\Controller\Auth@ajaxEditAuth', ['method' => 'get,post']],
    'ajax_del_auth' => ['thinkAuth\Controller\Auth@ajaxDelAuth', ['method' => 'post']],
    'get_auth_all/<type?>' => ['thinkAuth\Controller\Auth@getAuthAll', ['method' => 'get']],//获取所有的权限列表
    //group
    'group_list' => ['thinkAuth\Controller\Group@groupList', ['method' => 'get']],
    'ajax_get_group_list' => ['thinkAuth\Controller\Group@ajaxGetGroupList', ['method' => 'get']],
    'ajax_add_group' => ['thinkAuth\Controller\Group@ajaxAddGroup', ['method' => 'get,post']],
    'ajax_edit_group' => ['thinkAuth\Controller\Group@ajaxEditGroup', ['method' => 'get,post']],
    'ajax_del_group' => ['thinkAuth\Controller\Group@ajaxDelGroup', ['method' => 'post']],
    'allocation_auth' => ['thinkAuth\Controller\Group@allocationAuth', ['method' => 'get,post']],
]);
demo地址
http://yadmin.nizouba.cn/admin

$auth = Auth::getInstance();
检查权限用户 
$auth->checkAuths(1, true);         用户ID ,是否缓存权限

获取用户已有的权限
$auth->getUserAuths(1,true);    用户ID ,是否缓存权限

获取用户属于的组和角色
$auth->getGroupsAndRolesAndAuthsByUid(1,true);    用户ID ,是否缓存权限

删除权限缓存
$auth->rmAuthCache($uid)

