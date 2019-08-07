<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/7 0007
 * Time: 16:30
 */

namespace thinkAuth\Controller;

use think\Controller;
use think\Request;
use thinkAuth\Config\AuthBase;

class Base extends Controller
{
    protected $request;
    protected $param;
    protected $post;
    protected $data;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        include_once __DIR__ . '/../Helper.php';

        $this->request = $request;
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


}