<?php

namespace thinkAuth\Controller;


use think\facade\Request;
use thinkAuth\Config\AuthBase;
use thinkAuth\Model\UserModel;

/**
 * Class Users
 * @package thinkAuth\Controller
 * @Author: yfl
 * @Email: 554665488@qq.com
 * @Date:
 * @Description:用户控制器
 */
class Users extends Base
{
    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:用户列表
     * @return mixed
     */
    public function userList()
    {
//        dump(UserModel::getUserRoles(1));
//        dump(UserModel::getUserGroups(1));
        //echo AuthBase::VIEW_PATH .'user/create.php';
        $this->view->engine->layout(false);
        return $this->fetch(AuthBase::VIEW_PATH . 'user/userList.php', $this->getData());
    }

    /**
     * @param array $params
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十一日 00:43:04
     * @Description:layui table get user data
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ajaxGetUserList(array $params = [])
    {
        if ($this->request->isAjax()) {
            $userModel = new UserModel();
            $users = $userModel->getUsersByPage();
            return $this->returnLayuiTableJson($users->toArray(), $userModel->getUsersCount());
        }
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:添加用户
     * @return array
     */
    public function ajaxAddUser()
    {
        if ($this->request->isPost()) {
            $userModel = new UserModel();
            $userId = $userModel->createUser();
            if ($userId) return $this->ajaxSuccess();
            return $this->ajaxFail();
        }
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月13日 08:41:38
     * @Description:获取用户信息及所属角色和所属组
     * @return array
     */
    public function ajaxGetUser()
    {
        if ($this->request->isPost()) {
            $uid = Request::post('id', '', 'intval');
            if (!$uid) $this->ajaxFail();
            $user = UserModel::get($uid);
            //获取组
            $groupIdArrs = UserModel::getUserGroups($uid, ['id']);
            //获取角色
            $roleIdArrs = UserModel::getUserRoles($uid, ['id']);
            $user['groupIds'] = array_column($groupIdArrs->toArray(),'id');
            $user['roleIds'] =  array_column($roleIdArrs->toArray(),'id');
            if ($user) return $this->ajaxSuccess(1, '', $user);
            return $this->ajaxFail();
        }
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:编辑用户
     * @return array
     */
    public function ajaxEditUser()
    {
        if ($this->request->isPost()) {
            $userModel = new UserModel();
            $updateResult = $userModel->updateUser();
            if ($updateResult) return $this->ajaxSuccess();
            return $this->ajaxFail();
        }
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十一日 00:44:28
     * @Description:删除一个或者多个用户
     * @return array
     */
    public function ajaxDelUser()
    {
        if ($this->request->isPost()) {
            $userModel = new UserModel();
            $deltedResult = $userModel->destroyUser();
            if ($deltedResult) return $this->ajaxSuccess();
            return $this->ajaxFail();
        }
    }
}