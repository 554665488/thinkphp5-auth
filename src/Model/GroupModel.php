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
 * @Date:二〇一九年八月十日 22:45:32
 * @Description:用户组信息模型
 */
class GroupModel extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';

    public function getStatusAttr($value)
    {
        $status = [-1 => '删除', 0 => '禁用', 1 => '正常', 2 => '待审核'];
        return $status[$value];
    }

    public function setStatusAttr($value)
    {
        if ($value == 'on') return 1;
        return 0;
    }


    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->table = !empty($authGroup = Config::get('auth.table.group')) ? $authGroup : 'group';
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十四日 10:31:03
     * @Description:定义关联 获取每个组下边的用户
     * @return \think\model\relation\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(\thinkAuth\Model\UserModel::class, \thinkAuth\Model\UserGroupAccess::class, 'uid', 'auth_group_id');
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十五日 15:27:29
     * @Description:定义权限组和qx规则的关联 多对多
     * @return \think\model\relation\BelongsToMany
     */
    public function auths()
    {
        return $this->belongsToMany(\thinkAuth\Model\AuthModel::class, \thinkAuth\Model\GroupAuthAccess::class, 'auth_rule_id', 'group_id');
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:获取权限组列表
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getGroupsByPage()
    {
        $page = Request::get('page', 1, 'intval');
        $limit = Request::get('limit', 30, 'intval');
        $map = [];
        if (Request::has('search')) {
            $map[] = ['title', 'like', Request::get('search') . '%'];
        }
        return $this->field('*')->page($page, $limit)->whereOr($map)->order('id', 'desc')->select();
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 22:44:04
     * @Description:获取权限组数量 用于layui分页
     * @return float|string
     */
    public function getGroupCount()
    {
        $map = [];
        if (Request::has('search')) {
            $map[] = ['title', 'like', Request::get('search') . '%'];
        }
        return $this->field('*')->whereOr($map)->count();
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:创建权限组
     * @return bool
     */
    public function createGroup()
    {
        $data = Request::post();
        $group = self::create($data);
        //给新创建的组添加用户
        if (!empty($_POST['users_ids'])) {
            $group->users()->saveAll(explode(',', $data['users_ids']));
        }
        return $group['id'] ?? false;
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 22:44:38
     * @Description:更新权限组信息
     * @return UserModel
     */
    public function updateGroup()
    {
        $editData = Request::post();
        $group = self::update($editData);
        //删除已关联的用户
        if (!empty($editData['have_user_ids'])) {
            $group->users()->detach(explode(',', trim($editData['have_user_ids'], ',')));
        }
        if (!empty($editData['users_ids'])) {
            $group->users()->saveAll(explode(',', $editData['users_ids']));
        }
        return $group;
    }

    /**
     * @param $groupId
     * @param array $authIds
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:给组分配权限
     * @return array|false
     */
    public static function allcationAuth($groupId, array $authIds)
    {
        $group = self::get($groupId);
        if (empty($group)) return false;
        GroupAuthAccess::where('group_id', '=', $groupId)->delete();
        return $group->auths()->saveAll($authIds);
    }

    /**
     * @param $groupId
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月15日 16:16:00
     * @Description:获得权限组已有的权限
     * @return array
     */
    public static function getAuthByGroupId($groupId)
    {
        if (!$groupId) return [];
        $group = self::get($groupId);
//        $group = self::field('*')->with(['auths'=>function($query){
//            $query->field('*')->where('parent_id', 'neq', 0);
//        }])->select();
        //删除parent_id = 0 的
        foreach ($group->auths as $index => $auth) {
            if ($auth['parent_id'] == 0) unset($group->auths[$index]);
        }
        return $group->auths;
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 22:45:08
     * @Description:单个或则批量删除权限组信息
     * @return bool
     */
    public function destroyGroup()
    {
        $groupIds = Request::post('id');
        UserGroupAccess::where(['auth_group_id' => [$groupIds]])->delete();
        return self::destroy($groupIds);
    }

    /**
     * @param string $userFields
     * @param string $groupField
     * @param string $roleFied
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十四日 10:45:22
     * @Description:获得每一组下边的用户及每一用户的角色
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getUserAndRolesByGroup($userFields = '*', $groupField = '*', $roleFied = '*')
    {
        $map = [];
        $groupsHasUsers = self::field($groupField)->with([
            'users' => function ($query) use ($userFields, $roleFied) {
                $query->field($userFields)->with([
                    'roles' => function ($query) use ($roleFied) {
                        $query->field($roleFied);
                    }
                ]);
            }
        ])->where($map)->select();
        return $groupsHasUsers;
    }

    /**
     * @param $groupId
     * @param array $fields
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十四日 17:23:371
     * @Description:编辑组获取组的信息和包含用户信息
     * @return mixed
     */
    public static function getEditGroupInfo($groupId, $fields = array())
    {
        $group = GroupModel::get($groupId);
        //获取包含的角色
        $users = $group->users;
        if ($fields) {
            foreach ($users as $key => $user) {
                $user = $user->toArray();
                foreach ($user as $field => $item) {
                    if (!in_array($field, $fields)) unset($users[$key][$field]);
                }
            }
        }

        $group['userIds'] = array_column($users->toArray(), 'id');
        return $group;
    }

    /**
     * @param array $selectedgroupIds 选中状态的ID
     * @param string $userFields
     * @param string $groupField
     * @param string $roleFied
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十八日 14:50:16
     * @Description:获取所有的组添加用户的时候选择组
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getGroupToAddsUsersToSelectOption(array $selectedgroupIds = array(), $userFields = '*', $groupField = '*', $roleFied = '*')
    {
        $groupsHasUsers = self::getUserAndRolesByGroup($userFields, $groupField, $roleFied);

        $addUserSelectGroupSelectJson = [];
        foreach ($groupsHasUsers as $index => $groupHasUser) {
            $users = '';
            foreach ($groupHasUser['users'] as $user) $users .= $user['user_name'] . ',';
            $checked = false;
            if (in_array($groupHasUser['id'], $selectedgroupIds)) $checked = true;
            $addUserSelectGroupSelectJson[$index] = ['name' => $groupHasUser['title'], 'value' => $groupHasUser['id'], 'users' => $users, 'selected' => $checked];
        }
        return $addUserSelectGroupSelectJson;
    }
}