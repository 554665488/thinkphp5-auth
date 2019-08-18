<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/7 0007
 * Time: 14:32
 */

namespace thinkAuth\Config;

use think\facade\Config;
use think\facade\Request;

class AuthBase
{
    const AUTH_ON = true; // 权限开关  false 关闭
    const AUTH_TYPE = 1; // 认证方式，1为实时认证；2为登录认证。
    //视图目录
    const VIEW_PATH = __DIR__ . '/../view/';
    //layuicss所在目录
    const LAY_UI_PATH_CSS = '/static/js/plugins/layui/css/layui.css';
    //layuicss所在目录
    const LAY_UI_PATH_JS = '/static/js/plugins/layui/layui.js';
    //jquery路径
    const JQUERY_PATH = '/static/js/jquery.min.js';
    //layui 扩展配置文件
    const EXTEND_CONFIG = '/static/js/plugins/layui/config.js';
    //layui插件form select 插件css
    const FORM_SELECTS_CSS = '/static/js/plugins/layui/extend/fromSelect/formSelects-v4.css';
    //获取列表数据的数量
    const TABLE_LIMIT = 30;
}