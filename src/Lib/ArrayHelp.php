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
                if (!empty($children)) $returnArr[$index]['children'] =$children;
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
                if (!empty($children)) $returnArr[$index]['children'] =array_merge($children);
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
        if (empty($data)) return $data;
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