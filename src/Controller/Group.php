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
        if ($this->request->isPost()) {
            $groupModel = new GroupModel();
            $groupNewId = $groupModel->createAuth();
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
    public function ajaxDelGroup()
    {
        if ($this->request->isPost()) {
            $authModel = new AuthModel();
            $deltedResult = $authModel->destroyAuth();
            if ($deltedResult) return $this->ajaxSuccess();
            return $this->ajaxFail();
        }
    }
}