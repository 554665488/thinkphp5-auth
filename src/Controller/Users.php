<?php

namespace thinkAuth\Controller;


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
        if($this->request->isAjax()){
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
            if($userId) return $this->ajaxSuccess();
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
            if($updateResult) return $this->ajaxSuccess();
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
            if($deltedResult) return $this->ajaxSuccess();
            return $this->ajaxFail();
        }
    }
}