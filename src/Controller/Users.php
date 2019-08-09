<?php

namespace thinkAuth\Controller;


use thinkAuth\Config\AuthBase;
use thinkAuth\Model\UserModel;

class Users extends Base
{

    public function userList()
    {
        //echo AuthBase::VIEW_PATH .'user/create.php';
        $this->view->engine->layout(false);
        return $this->fetch(AuthBase::VIEW_PATH . 'user/userList.php', $this->getData());
    }

    public function getUserList(array $params = [])
    {
        $userModel = new UserModel();
        $users = $userModel->getUsersByPage();
        return $this->returnLayuiTableJson($users->toArray(), $userModel->getUsersCount());
    }

    public function addUser()
    {
        if ($this->request->isPost()) {
            $userModel = new UserModel();
            $userId = $userModel->createUser();
            if($userId) return $this->ajaxSuccess();
            return $this->ajaxFail();
        }
    }

    public function editUser()
    {
        if ($this->request->isPost()) {
            $userModel = new UserModel();
            $updateResult = $userModel->updateUser();
            if($updateResult) return $this->ajaxSuccess();
            return $this->ajaxFail();
        }
    }
}