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
        $this->data = ['staticDir' => AuthBase::LAY_UI_PATH];
    }

    /**
     * @param array $params
     * @return array
     */
    public function getData(array $params = [])
    {
        return array_merge($this->data, $params);
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    protected  function returnLayuiTableJson(array $data = array(), $count = null, $msg = '')
    {
        return [
            'code' => 0,
            'msg' => $msg,
            'count' => $count ?? count($data),
            'data' => $data
        ];
    }

}