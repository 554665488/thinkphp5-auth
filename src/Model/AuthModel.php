<?php

namespace thinkAuth\Model;

use think\facade\Config;
use think\facade\Request;
use think\Model;
use thinkAuth\Lib\ArrayHelp;

/**
 * Class AuthModel
 * @package thinkAuth\Model
 * @Author: yfl
 * @Email: 554665488@qq.com
 * @Date:二〇一九年八月十日 22:46:00
 * @Description:权限管理模型
 */
class AuthModel extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';

    public function getStatusAttr($value)
    {
        $status = [-1 => '删除', 0 => '禁用', 1 => '开启', 2 => '待审核'];
        return $status[$value];
    }

    public function setStatusAttr($value)
    {
        if ($value === 'on') return 1;
        return 0;
    }

    public function setParentIdAttr($value)
    {
        if ($value == -1) return 0;
        return $value;
    }

    public function setTitleAttr($value)
    {
        return str_replace('➥', '', $value);
    }

    public function __construct($data = [])
    {
        parent::__construct($data);
        //设置表名
        $this->table = !empty($authRule = Config::get('auth.table.auth')) ? $authRule : 'auth';
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 20:22:53
     * @Description:获得权限列表
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthsByPage()
    {
        $page = Request::get('page', 1, 'intval');
        $limit = Request::get('limit', 30, 'intval');
        //搜索条件
        $map = [];
        if (Request::has('search')) {
            $map[] = ['title', 'like', Request::get('search') . '%'];
            $map[] = ['name', 'like', Request::get('search') . '%'];
        }
        $auths = $this->field('*')->page($page, $limit)->whereOr($map)->order(['id' => 'desc'])->select();
        $arrayHelp = new ArrayHelp();
        $auths = $arrayHelp->getList($auths->toArray());
        foreach ($auths as $index => $auth) {
            $auths[$index]['title'] = str_repeat('➥', $auth['level']) . $auth['title'];
        }
        return $auths;
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:获取权限列表的数量
     * @return float|string
     */
    public function getAuthsCount()
    {
        $map = [];
        if (Request::has('search')) {
            $map[] = ['title', 'like', Request::get('search') . '%'];
            $map[] = ['name', 'like', Request::get('search') . '%'];
        }
        return $this->field('*')->whereOr($map)->count();
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 22:42:45
     * @Description:创建权限
     * @return bool
     */
    public function createAuth()
    {
        $user = self::create(Request::post());
        return $user['id'] ?? false;
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:更新权限信息
     * @Description:
     * @return AuthModel
     */
    public function updateAuth()
    {
        $updateData = Request::post();
        //没有值就状态就改为关闭
        if (!isset($updateData['status'])) $updateData['status'] = 0;
        $user = self::update($updateData);
        return $user;
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月10日 23:18:56
     * @Description:删除权限规则 一个或者多个
     * @return bool
     */
    public function destroyAuth()
    {
        $id = Request::post('id');
        //删除下面关联的子权限 这样不行不通 #bug 会出现删除不了的子权限 出现 垃圾数据 改为不管是批量删除还是单个删除 下边有子权限必须先删除子权限
//        self::destroy(function ($query) use ($id) {
//            $query->where('parent_id', 'in', $id);
//        });
        return self::destroy($id);
    }

    /**
     * @param string $type
     * @param string $cacheKey 缓存key
     * @param int $expire 大于零缓存
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:获取所有权限树状结构或者顺序结构
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllAuths($type = '', $cacheKey = 'auths', $expire = 0)
    {
        $arrayHelp = new ArrayHelp();
        //where 条件
        $map = [];
        if (Request::has('edit_id')) {
            //用排除自己
            $map[] = ['id', 'neq', Request::param('edit_id')];
        }
        if ($expire) {
            $authList = $this->field('*')->where($map)->order('id', 'desc')->cache($cacheKey, $expire)->select();
        } else {
            $authList = $this->field('*')->where($map)->order('id', 'desc')->select();
        }
        //直接返回
        if (empty($type)) return $authList->toArray();
        //处理后返回结果
        return $arrayHelp->$type($authList->toArray());
    }

    /**
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:获得所有的权限并设置为选中状态
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAllAuthsByChecks()
    {
        $arrayHelp = new ArrayHelp();
        $map = [];
        $authList = $this->field('*')->where($map)->order('id', 'desc')->select();
        return $arrayHelp->getTreeLayuiDataToGroupAuth($authList->toArray());
    }

    /**
     * @param $parentId 父级ID
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月13日 15:24:38
     * @Description:根据parent_id分批返回树状select的数据 TODO 分批获取遇到一个问题 （点击一级菜单触发了远程查询，展示不了子菜单）
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAuthsByParentIdToSelectData($parentId)
    {
        $map[] = ['parent_id', '=', $parentId];
        $authList = $this->field('id as value, CONCAT_WS("$$",name,title) as name')->where($map)->order('id', 'desc')->select();
        return $authList->toArray();
    }

    /**
     * @param string $ids
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月13日 18:42:03
     * @Description:获取下边的子权限   判断要删除的权限下边是否有子权限
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getChildrenAuthByIds($ids = '')
    {
        if (!$ids) $ids = Request::param('id');
        $map[] = ['parent_id', 'in', $ids];
        $authList = $this->field('*')->where($map)->select();
        return $authList;
    }
}