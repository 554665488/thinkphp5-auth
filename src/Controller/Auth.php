<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/10 0010
 * Time: 14:18
 */

namespace thinkAuth\Controller;


use think\facade\Config;
use think\facade\Request;
use thinkAuth\Config\AuthBase;
use thinkAuth\Model\AuthModel;

/**
 * Class Auth
 * @package thinkAuth\Controller
 * @Author: yfl
 * @Email: 554665488@qq.com
 * @Date:2019年8月10日23:15:50
 * @Description:权限控制器
 */
class Auth extends Base
{
    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:权限列表
     * @return mixed
     */
    public function authList()
    {
        return $this->fetch(AuthBase::VIEW_PATH . 'user/authList.php', $this->getData());
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十日 23:16:39
     * @Description:layui表格获取权限数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ajaxGetAuthList()
    {
        if ($this->request->isAjax()) {
            $authModel = new AuthModel();
            $auths = $authModel->getAuthsByPage();
            return $this->returnLayuiTableJson($auths, $authModel->getAuthsCount());
        }
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 23:17:11
     * @Description:添加权限规则
     * @return array
     */
    public function ajaxAddAuth()
    {
        if ($this->request->isPost()) {
            $authModel = new AuthModel();
            $authId = $authModel->createAuth();
            if ($authId) return $this->ajaxSuccess();
            return $this->ajaxFail();
        }
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:编辑权限规则
     * @Description:
     */
    public function ajaxEditAuth()
    {
        if ($this->request->isPost()) {
            $authModel = new AuthModel();
            $authId = $authModel->updateAuth();
            if ($authId) return $this->ajaxSuccess();
            return $this->ajaxFail();
        }
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019-8-11 0:41:4
     * @Description:删除权限 一个或者多个
     * @return array
     */
    public function ajaxDelAuth()
    {
        if ($this->request->isPost()) {
            $authModel = new AuthModel();
            $deltedResult = $authModel->destroyAuth();
            if ($deltedResult) return $this->ajaxSuccess();
            return $this->ajaxFail();
        }
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:获取所有权限
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthAll()
    {
        if ($this->request->isGet()) {
            $authModel = new AuthModel();
            $auths = $authModel ->getAllAuths('makeTreeLevel');
            dump($auths);die;
            if(Request::has('type') and Request::param('type') == 'treejson'){
                $auths = $authModel ->getAllAuths('getTreeLayuiData');
                return ['auths'=> $auths];
            }
            $auths = $authModel ->getAllAuths('getTreeToHtmlOption');
            return ['auths'=> $auths];
        }
    }
}