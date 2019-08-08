<?php

namespace thinkAuth\Controller;


use thinkAuth\Config\AuthBase;
use thinkAuth\Model\UserModel;

class Users extends Base
{

    public function create()
    {
        //echo AuthBase::VIEW_PATH .'user/create.php';

        $this->view->engine->layout(false);
        return $this->fetch(AuthBase::VIEW_PATH . 'user/create.php', $this->getData());


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
            dump($_POST);die;
        }
    }
}