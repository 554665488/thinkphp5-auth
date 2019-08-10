<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/8/10 0010
 * Time: 14:18
 */

namespace thinkAuth\Controller;


use thinkAuth\Config\AuthBase;

class Auth extends Base
{
    public function authList()
    {
        return $this->fetch(AuthBase::VIEW_PATH . 'user/authList.php', $this->getData());
    }

    public function ajaxGetAuthList()
    {

    }

    public function ajaxAddAuth()
    {
        
    }

    public function ajaxEditAuth()
    {
        
    }

    public function ajaxDelAuth()
    {

    }
}