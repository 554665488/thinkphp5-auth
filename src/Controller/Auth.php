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
        if ($this->request->isGet()) {
            return $this->getAuthAll();
        }
        if ($this->request->isPost()) {
            $postData = $this->request->post();
            $auth = AuthModel::where(function ($query) use ($postData) {
                $query->where(['name' => $postData['name']])->where(['title' => $postData['title']]);
            })->select();
            if (!$auth->isEmpty()) return $this->ajaxFail(0, '规则或者名称已存在');
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
        if ($this->request->isGet()) {
            return $this->getAuthAll();
        }
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
            $isHasChildrenAuth = $authModel->getChildrenAuthByIds();
            //检查是否有子权限 有的话 不能删除
            if ($isHasChildrenAuth->isEmpty() == false) return $this->ajaxFail(0, '请先删除子权限');

            $deltedResult = $authModel->destroyAuth();
            if ($deltedResult) return $this->ajaxSuccess();
            return $this->ajaxFail();
        }
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:递归获取所有权限 返回josn 或者 拼接好的select options 或者返回 array
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthAll()
    {
        if ($this->request->isGet()) {
            $authModel = new AuthModel();
            if (Request::has('type') and Request::param('type') == 'select_tree_json') {
                // 分批获取有问题，现改为一次性获取全部
                //$parent_id = Request::get('parent_id', 0 , 'intval');
                //$auths = $authModel->getAuthsByParentIdToSelectData($parent_id);
                //if(empty($auths))  return ['auths' => 'notChildren',];
                // 取消权限规则无限极分类
                $auths = $authModel->getAllAuths('getTreeLayuiSelectJsonData');
                //顶级返回 value = 0 的时候 前台select 选中不了 返回 -1 模型的修改器 处理为 0
                array_unshift($auths, array('name' => "顶级", 'value' => -1));
                return ['auths' => $auths];
            }

            if (Request::has('type') and Request::param('type') == 'treejson') {
                $auths = $authModel->getAllAuths('getTreeLayuiData');
                return ['auths' => $auths];
            }
            //取消下边的返回形式
            $auths = $authModel->getAllAuths('getTreeToHtmlOption');
            return ['auths' => $auths];
        }
    }
    //动态分批根据parent_id获取权限信息 select 显示有问题
//    public function getAuthsByBatcheToTreeSelect($patent = 0)
//    {
//        if($this->request->isGet()){
//            $authModel = new AuthModel();
//            $auth = $authModel->getAuthsByParentIdToSelectData($patent);
//        }
//    }
}