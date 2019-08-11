<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/7 0007
 * Time: 16:30
 */

namespace thinkAuth\Controller;

use think\App;
use think\Controller;
use think\facade\Config;
use think\Request;
use thinkAuth\Config\AuthBase;

class Base extends Controller
{
    protected $param;
    protected $post;
    protected $data;

    public function __construct()
    {
        parent::__construct();
        include_once __DIR__ . '/../Helper.php';
        $this->param = $this->request->param();
        $this->post = $this->request->post();
        $this->data = ['layui_css' => AuthBase::LAY_UI_PATH_CSS, 'jquery' => AuthBase::JQUERY_PATH, 'layui_js' => AuthBase::LAY_UI_PATH_JS, 'limit' => AuthBase::TABLE_LIMIT];
    }

    /**
     * @param array $params
     * @return array
     */
    public function getData(array $params = [])
    {
        //获取自定义配置信息
        if (empty($params)) $params = empty($path = Config::get('auth.path')) ? [] : $path;
        if (!empty(Config::get('auth.table_config'))) $this->data = array_merge($this->data, Config::get('auth.table_config'));
        return array_merge($this->data, $params);
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    protected function returnLayuiTableJson(array $data = array(), $count = null, $msg = '')
    {
        return [
            'code' => 0,
            'msg' => $msg,
            'count' => $count ?? count($data),
            'data' => $data
        ];
    }

    public function ajaxSuccess($code = 1, string $msg = '操作成功', array $data = array())
    {
        return ['code' => $code, 'msg' => $msg, 'data' => $data];
    }

    public function ajaxFail($code = 0, string $msg = '操作失败', array $data = array())
    {
        return ['code' => $code, 'msg' => $msg, 'data' => $data];
    }
}