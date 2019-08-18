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
class RoleModel extends Model
{

    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';

    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->table = !empty($userRole = Config::get('auth.table.role')) ? $userRole : 'role';

    }

    public function users()
    {
        return $this->belongsToMany(\thinkAuth\Model\UserModel::class,\thinkAuth\Model\UserRoleAccess::class,'uid', 'role_id');
    }

}