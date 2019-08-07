<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/7 0007
 * Time: 14:32
 */

namespace thinkAuth\Auth\Config;

use think\facade\Request;

class AuthBase
{
    const AUTH_ON = true; // 权限开关  false 关闭
    const AUTH_TYPE = 1; // 认证方式，1为实时认证；2为登录认证。
    //视图目录
    const VIEW_PATH = __DIR__ . '/../view/';
    //** 不检测的权限 */
    protected static $notCheckAuth = [

    ];

    /**
     * @Description:权限认证对象单例
     * @var object $instance
     */
    protected static $instance;
    protected $request;
    protected $param;
    protected $module;
    protected $controller;
    protected $action;

    protected $config = [
        'auth_on' => self::AUTH_ON,
        'auth_type' => self::AUTH_TYPE,
        'auth_group' => Table::AUTH_GROUP,
        'auth_group_access' => Table::AUTH_GROUP_ACCESS,
        'auth_rule' => Table::AUTH_RULE,
        'auth_user' => Table::AUTH_USER,
    ];


    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function __construct(array $config = array())
    {
        if ($config) $this->config = array_merge($this->config, $config);
        /**
         * @Description:初始化认证参数
         */
        $this->request = Request::instance();
        $this->param = $this->request->param();
        $this->module = $this->request->module();
        $this->controller = $this->request->controller();
        $this->action = $this->request->action();
    }
}