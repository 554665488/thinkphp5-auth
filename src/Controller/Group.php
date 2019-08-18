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
use thinkAuth\Model\GroupModel;
use thinkAuth\Model\UserModel;

/**
 * Class Auth
 * @package thinkAuth\Controller
 * @Author: yfl
 * @Email: 554665488@qq.com
 * @Date:2019-08-11 21:32:32
 * @Description:权限组控制器
 */
class Group extends Base
{
    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十四日 08:36:01
     * @Description:定义相对关联 获取这个组包含的用户
     * @return mixed
     */
    public function users()
    {
        return $this->belongsToMany(\thinkAuth\Model\GroupModel::class, \AuthGroupAccess::class, 'uid', 'id');
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:权限列表
     * @return mixed
     */
    public function groupList()
    {
        return $this->fetch(AuthBase::VIEW_PATH . 'user/groupList.php', $this->getData());
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十日 23:16:39
     * @Description:layui表格获取权限组数据
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function ajaxGetGroupList()
    {
        if ($this->request->isAjax()) {
            $groupModel = new GroupModel();
            $auths = $groupModel->getGroupsByPage();
            return $this->returnLayuiTableJson($auths->toArray(), $groupModel->getGroupCount());
        }
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 23:17:11
     * @Description:添加权限组规则
     * @return array
     */
    public function ajaxAddGroup()
    {
        if ($this->request->isGet()) {
            if ($this->request->has('type') and $this->request->get('type') == 'select_user_tree_json') {
                $suersGroupsAndRoles = UserModel::getAddGroupsUsersToSelectOption();
                return $suersGroupsAndRoles;
            }
        }
        if ($this->request->isPost()) {
            $groupModel = new GroupModel();
            $groupNewId = $groupModel->createGroup();
            if ($groupNewId) return $this->ajaxSuccess();
            return $this->ajaxFail();
        }
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十一日 21:34:12
     * @Description:编辑权限组
     */
    public function ajaxEditGroup()
    {
        if ($this->request->isGet()) {
            if ($this->request->has('type') and $this->request->get('type') == 'select_user_tree_json') {
                $suersGroupsAndRoles = UserModel::getAddGroupsUsersToSelectOption();
                return $suersGroupsAndRoles;
            }
            if ($this->request->has('type') and $this->request->get('type') == 'ajax_get_group_byId') {
                $groupId = Request::get('id', '', 'intval');
                if (!$groupId) $this->ajaxFail();
                $group = GroupModel::getEditGroupInfo($groupId, ['id']);
                if ($group) return $this->ajaxSuccess(1, '', $group);
                return $this->ajaxFail();
            }
        }
        if ($this->request->isPost()) {
            $groupModel = new GroupModel();
            $updateResult = $groupModel->updateGroup();
            if ($updateResult) return $this->ajaxSuccess();
            return $this->ajaxFail();
        }
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十四日 17:02:01
     * @Description:编辑的时候获取组的信息
     * @return array
     */
    public function ajaxGetGroupById()
    {
        if ($this->request->isGet()) {
            $groupId = Request::get('id', '', 'intval');
            if (!$groupId) $this->ajaxFail();
            $group = GroupModel::getEditGroupInfo($groupId, ['id']);
            if ($group) return $this->ajaxSuccess(1, '', $group);
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
    public function ajaxDelGroup()
    {
        if ($this->request->isPost()) {
            $groupModel = new GroupModel();
            $deltedResult = $groupModel->destroyGroup();
            if ($deltedResult) return $this->ajaxSuccess();
            return $this->ajaxFail();
        }
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十六日 15:45:13
     * @Description:分配权限
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function allocationAuth()
    {
        $groupId =  $this->request->param('group_id', '', 'intval');
        if(!$groupId) return $this->ajaxFail('group_id为空');
        //加载数据
        if ($this->request->isAjax() and $this->request->isGet()) {
            $authModel = new AuthModel();
            $checkedIds = array_column(GroupModel::getAuthByGroupId($groupId)->toArray(),'id');
            $authTree = $authModel->getAllAuthsByChecks();
            $data = ['authTree'=>$authTree, 'checkedIds' => $checkedIds];
            return $this->ajaxSuccess(1, '', $data);
        }
        //保存数据
        if ($this->request->isPost()) {
            if ($this->request->has('checkedData') and !empty($checkedData = $this->request->post('checkedData'))) {
                $checkIds = self::handelCheckDataGetAuthId($checkedData);
                $checkIdArrs = explode(',', trim($checkIds, ','));
                if(!GroupModel::allcationAuth($groupId, $checkIdArrs))  return $this->ajaxFail(0,'分配权限失败');
                return $this->ajaxSuccess();
            } else {
                return $this->ajaxFail(0, '没有选择权限');
            }
        }
        $this->assign('group_id',$groupId);
        echo $this->fetch(AuthBase::VIEW_PATH . 'user/allocationAuth.php', $this->getData());
    }

    /**
     * @param $checkData
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:二〇一九年八月十五日 14:26:49
     * @Description:处理选这的选择规则
     * @return string 返回规则Id 1，2，6
     */
    private static function handelCheckDataGetAuthId($checkData)
    {
        $checKIds = '';
        foreach ($checkData as $index => $checkDatum) {
            $checKIds .= $checkDatum['id'] . ',';
            if (isset($checkDatum['children']) and !empty($checkDatum['children'])) {
                $checKIds .= self::handelCheckDataGetAuthId($checkDatum['children']);
            }
        }
        return $checKIds;
    }

    //获得组以及组下边所有的用户
    public function getGroupsUsersAndRoles()
    {
        if ($this->request->has('type') and $this->request->get('type') == 'select_user_tree_json') {
            GroupModel::getAddGroupsUsersToSelectOption();
        }
    }
}