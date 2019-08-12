<?php

namespace thinkAuth\Lib;
/**
 * Class ArrayHelp
 * @package thinkAuth\Lib
 * @Author: yfl
 * @Email: 554665488@qq.com
 * @Date:2019年8月11日 00:56:53
 * @Description:数组结构的处理类
 */
class ArrayHelp
{

    protected $returnType = '';

    protected $icon = '┝';

    protected $primary = 'id';

    protected $parent_id = 'parent_id';

    /**
     * @param array $data
     * @param int $parent_id
     * @param int $level
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:
     * @Description:递归获得数组的树形结构
     * @return array
     */
    public function getTree(array $data, $parent_id = 0, $level = 0)
    {
        if (empty($data)) return $data;
        $returnArr = [];
        foreach ($data as $index => $datum) {
            if ($datum[$this->parent_id] == $parent_id) {
                $datum['level'] = $level;
                $returnArr[$index] = $datum;
                unset($data[$index]);
                $children = $this->getTree($data, $datum[$this->primary], $level + 1);
                if (!empty($children)) $returnArr[$index]['children'] = $children;
            }
        }
        return $returnArr;
    }

    //引用算法生成树状结构数据
    public function generateTree(array $data)
    {
        //第一步 构造数据
        //$data = array(
        // array('id' => 1, 'parent_id' => 0, 'name' => '河北省'),
        // array('id' => 2, 'parent_id' => 0, 'name' => '北京市'),
        // array('id' => 3, 'parent_id' => 1, 'name' => '邯郸市'),
        // array('id' => 4, 'parent_id' => 2, 'name' => '朝阳区'),
        // array('id' => 5, 'parent_id' => 2, 'name' => '通州区'),
        // array('id' => 6, 'parent_id' => 4, 'name' => '望京'),
        // array('id' => 7, 'parent_id' => 4, 'name' => '酒仙桥'),
        // array('id' => 8, 'parent_id' => 3, 'name' => '永年区'),
        // array('id' => 9, 'parent_id' => 1, 'name' => '武安市'),
        //);
        $items = array();
        foreach ($data as $value) {
            $items[$value['id']] = $value;
        }
        $tree = array();
        foreach ($items as $id => $item) {
            if (isset($items[$item[$this->parent_id]])) {
                $items[$item[$this->parent_id]]['chilren'][] = &$items[$id];
            } else {
                $tree[] =& $items[$id];
            }
        }
        return $tree;
    }

    /**
     * @param array $data
     * @param int $parent_id
     * @param int $level
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月11日 13:23:47
     * @Description:返回layui树型列表数据
     * @return array
     */
    public function getTreeLayuiData(array $data, $parent_id = 0, $level = 0)
    {
        if (empty($data)) return $data;
        $returnArr = [];
        foreach ($data as $index => $datum) {
            if ($datum[$this->parent_id] == $parent_id) {
                $datum['level'] = $level;
                $returnArr[$index] = [
                    'id' => $datum['id'],
                    'title' => $datum['name'] . '-' . '<em style="color: #f550e0">' . $datum['title'] . '</em>' . '-' . '<em style="color: #00B2E2">' . $datum['method'] . '</em>',
                    'auth_title' => $datum['title'],
                    'auth_name' => $datum['name'],
                    'auth_status' => $datum['status'],
                    'parent_id' => $datum['parent_id'],
                    'condition' => $datum['condition'],
                    'condition' => $datum['condition'],
                    'method' => $datum['method'],
                ];
                unset($data[$index]);
                $children = $this->getTreeLayuiData($data, $datum[$this->primary], $level + 1);
                if (!empty($children)) $returnArr[$index]['children'] = array_merge($children);
            }
        }
        return $returnArr;
    }

    /**
     * @param array $data
     * @param int $parent_id
     * @param int $level
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月11日 02:19:02
     * @Description:获取数组顺序结构
     * @return array
     */
    public function getList(array $data, $parent_id = 0, $level = 0)
    {
        if (empty($data)) return $data;
        static $returnArr = [];
        foreach ($data as $index => $datum) {
            if ($datum[$this->parent_id] == $parent_id) {
                $datum['level'] = $level;
                $returnArr[] = $datum;
                unset($data[$index]);
                $this->getList($data, $datum[$this->primary], $level + 1);
            }
        }
        return $returnArr;
    }

    /**
     * @param array $data
     * @Author: yfl
     * @Email: 554665488@qq.com
     * @Date:2019年8月11日 04:11:29
     * @Description:把树状数据组装成option
     * @return array|string
     */
    public function getTreeToHtmlOption(array $data)
    {
        if (empty($data)) return "<option  value= '0'>顶级</option>";

        //是否默认选中某一个元素
        $check_id = $_GET['check_id'] ?? false;
        $optionHtml = "<option value=''>直接选择或搜索选择</option>";

        if ($check_id === '0') {
            $optionHtml .= "<option selected value= '0'>顶级</option>";
        } else {
            $optionHtml .= "<option  value= '0'>顶级</option>";
        }

        $dataList = $this->getList($data);
        foreach ($dataList as $index => $datum) {
            if ($datum['id'] == $check_id) {
                $optionHtml .= "<option selected  value=" . $datum['id'] . "> " . str_repeat($this->icon, $datum['level']) . $datum['name'] . '/' . $datum['title'] . "</option>";
            } else {
                $optionHtml .= "<option value=" . $datum['id'] . "> " . str_repeat($this->icon, $datum['level']) . $datum['name'] . '/' . $datum['title'] . "</option>";
            }
        }
        return $optionHtml;
    }

    /**
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * @param string $parent_id
     */
    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }

    /**
     * @param string $returnType
     */
    public function setReturnType($returnType)
    {
        $this->returnType = $returnType;
    }

    /**
     * @param string $primary
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;
    }

    public static function __callStatic($name, $arguments)
    {
        // TODO: Implement __callStatic() method.
    }


}