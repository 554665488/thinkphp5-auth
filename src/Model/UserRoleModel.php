<?php

namespace thinkAuth\Model;

use think\facade\Config;
use think\facade\Request;
use think\Model;

/**
 * Class UserModel
 * @package thinkAuth\Model
 * @Author: yfl
 * @Email: 554665488@qq.com
 * @Date:二〇一九年八月十二日 23:17:28
 * @Description:用户角色信息模型
 */
class UserRoleModel extends Model
{

    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->table = !empty($userRole = Config::get('auth.table.user_role')) ? $userRole : 'user_role';

    }

}