<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{$layui_css}" media="all">
    <link rel="stylesheet" href="{$formSelectsCss}" media="all">
    <script src="{$jquery}" charset="utf-8"></script>
    <script src="{$layui_js}" charset="utf-8"></script>
    <script src="{$extend_config}" charset="utf-8"></script>

</head>
<body>
<!--add group html start-->
<div id="addGroupDiv" style="display: none">
    <form class="layui-form reset-form" lay-filter="addGroupForm" id="addGroupForm">
        <div class="layui-form-item">
            <label class="layui-form-label">权限组名</label>
            <div class="layui-input-block" style="width: 300px">
                <input type="text" name="title" required lay-verify="required" placeholder="请输入权限组名"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">选择用户</label>
            <div class="layui-input-block" style="width: 300px">
                <select name="users_ids" xm-select="add_group_select_users" xm-select-search=""
                        xm-select-search-type="dl">
                    <option value="">选择用户</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" lay-skin="switch" lay-text="开启|禁用">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="addGroupSubmit">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<!--add group html end-->
<!--edit group html start-->
<div id="editGroupDiv" style="display: none">
    <form class="layui-form reset-form" lay-filter="editGroupForm" id="editGroupForm">
        <div class="layui-form-item">
            <label class="layui-form-label">权限组名</label>
            <div class="layui-input-block" style="width: 300px">
                <input type="text" name="title" required lay-verify="required" placeholder="请输入权限组名"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">选择用户</label>
            <div class="layui-input-block" style="width: 300px">
                <select name="users_ids" xm-select="edit_group_select_users" xm-select-search=""
                        xm-select-search-type="dl">
                    <option value="">选择用户</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" lay-skin="switch" lay-text="开启|禁用">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" name="have_user_ids" value=""/>
                <input type="hidden" name="id" value=""/>
                <button class="layui-btn" lay-submit lay-filter="editGroupSubmit">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<!--edit group html end-->
<!--search html start-->
<div id="searchDiv" style="display: none">
    <form class="layui-form" lay-filter="searchForm">
        <div class="layui-form-item">
            <label class="layui-form-label">查询条件</label>
            <div class="layui-input-block" style="width: 300px">
                <input type="text" name="search" required lay-verify="required" placeholder="权限组名称"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="searchGroupSubmit">搜索</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<!--search html end-->
<!--table head tools html start-->
<script type="text/html" id="headTool">
    <div class="layui-btn-container">
        <button type="button" class="layui-btn  layui-btn-sm" lay-event="addGroupEvent"><i
                    class="layui-icon"></i></button>
        <button type="button" class="layui-btn layui-btn-danger layui-btn-sm" lay-event="delGroupEvent"><i
                    class="layui-icon"></i></button>
        <button type="button" class="layui-btn layui-btn-normal layui-btn-sm" lay-event="searchGroupEvent">
            <i class="layui-icon">&#xe615;</i></button>
        <button type="button" class="layui-btn layui-btn-warm layui-btn-sm" lay-event="refreshGroupEvent">
            <i class="layui-icon">&#xe669;</i></button>

    </div>
</script>
<!--table head tools html end-->
<table class="layui-hide" id="groupTableHtmlId" lay-filter="groupTableFilter"></table>
<!--table list action start-->
<script type="text/html" id="action">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-xs" lay-event="allocationAuth">分配权限</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<!--table list action end-->
<script>
    function resetForm() {
        $('.reset-form')[0].reset();
        //重置选择权限组
        layui.formSelects.value('add_group_select_users', []);
        layui.formSelects.value('edit_group_select_users', []);
    }

    //初始化select赋值
    function formSelectValue(select, value) {
        // console.log(select);
        // console.log(value);
        layui.use(['jquery', 'formSelects'], function () {
            var formSelects = layui.formSelects;
            formSelects.value(select, value)
        });
    }

    function ajaxRequest(url, data, type, isReload) {
        var index;
        $.ajax({
            url: url,
            type: type,
            dataType: 'json',
            data: data,
            cache: false,
            async: true,
            beforeSend: function () {
                var index = layer.load(1, {
                    shade: [0.1, '#fff'], time: 2 * 1000 //0.1透明度的白色背景
                });
            },
            complete: function () {
                layer.close(index);
            },
            success: function (res) {
                if (res.code) {
                    layer.msg(res.msg, {icon: 1});
                } else {
                    layer.msg(res.msg, {icon: 5});
                }
                //表格重载
                setTimeout(function () {
                    if (isReload) {
                        layui.use('table', function () {
                            var table = layui.table;
                            table.reload('groupTableReload', {
                                where: {} //设定异步数据接口的额外参数
                                //,height: 300
                                , page: {
                                    curr: 1 //重新从第 1 页开始
                                }
                            });
                        });
                    }
                    layer.closeAll();
                }, 1000)
                return false;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.alert('网络失败，请刷新页面后重试', {icon: 2});
            }
        });
    }

    function AddGroupAjaxgetAllUserlist() {
        layui.use(['jquery', 'formSelects'], function () {
            var formSelects = layui.formSelects;
            formSelects.opened('add_group_select_users', function (id) {
                formSelects.data('add_group_select_users', 'server', {
                    url: '{:url("auth/ajax_add_group")}' + '?type=select_user_tree_json',
                    keyword: ''
                });
            });
            //自定义显示的内容
            layui.formSelects.render('add_group_select_users', {
                template: function (name, value, selected, disabled) {
                    // console.log(name);
                    // console.log(value);
                    // console.log(selected);
                    var str = '';
                    return value.name + '<span style="position: absolute; right: 0; color: #A0A0A0; font-size: 12px;" title=' + value.group_name + '>' + value.group_name + '</span>';
                }
            });
            //这里也算是给自己挖了一手好坑吧, 简单的一种处理方式, 在多选第一次打开的时候收缩所有的子节点, 目前处理的很粗鲁, 就是为了一种效果, 收缩全部节点
            var isFirst = true;
            // layui.formSelects.opened('add_group_select_users', function(id){
            //     if(isFirst){
            //         isFirst = false;
            //         $('[fs_id="add_group_select_users"]').find('.xm-cz i.icon-caidan').click();
            //     }
            // });
        });
    }

    function editGroupAjaxgetAllUserlist(userIds) {
        layui.use(['jquery', 'formSelects'], function () {
            var formSelects = layui.formSelects;
            formSelects.data('edit_group_select_users', 'server', {
                url: '{:url("auth/ajax_edit_group")}' + '?type=select_user_tree_json&selected_user_ids=' + userIds,
                keyword: ''
            });
            //自定义显示的内容
            layui.formSelects.render('edit_group_select_users', {
                template: function (name, value, selected, disabled) {
                    // console.log(name);
                    // console.log(value);
                    // console.log(selected);
                    var str = '';
                    return value.name + '<span style="position: absolute; right: 0; color: #A0A0A0; font-size: 12px;" title=' + value.group_name + '>' + value.group_name + '</span>';
                }
            });
        });
    }
</script>

<script>
    //监听表单提交事件
    layui.use('form', function () {
        var form = layui.form;
        //监听提交
        form.on('submit(addGroupSubmit)', function (data) {
            console.log(data);
            ajaxRequest('{:url("auth/ajax_add_group")}', data.field, 'POST', true);
//            layer.msg(JSON.stringify(data.field));
            return false;
        });

        form.on('submit(editGroupSubmit)', function (data) {
//            console.log(data);
            ajaxRequest('{:url("auth/ajax_edit_group")}', data.field, 'POST', true);
//            layer.msg(JSON.stringify(data.field));
            return false;
        });
        form.on('submit(searchGroupSubmit)', function (data) {
            layui.use('table', function () {
                var table = layui.table;
                table.reload('groupTableReload', {
                    where: {
                        search: data.field.search
                    }
                    //,height: 300
                    , page: {
                        curr: 1 //重新从第 1 页开始
                    }
                });
            });
            layer.closeAll();
            return false;
        });
    });

    layui.use('table', function () {
        var table = layui.table;
        //表格渲染
        table.render({
            elem: '#groupTableHtmlId'
            , url: '{:url("auth/ajax_get_group_list")}'
            , toolbar: '#headTool'
            , title: '权限数据表'
            , cols: [[
                {type: 'checkbox', fixed: 'left'}
                , {field: 'id', title: 'ID', width: 100, fixed: 'left', unresize: true, sort: true, align: 'center'}
                , {field: 'title', title: '权限组名称', edit: 'text', sort: true, align: 'center'}
                , {field: 'status', title: '状态', align: 'center'}
                , {field: 'created_at', title: '创建时间', align: 'center'}
                , {fixed: 'right', title: '操作', toolbar: '#action', align: 'center'}
            ]]
            , page: true
            , id: 'groupTableReload' //重载表格
            , height: 'full-30'
            , cellMinWidth: 80
            , limit: '{$limit}'
            , text: {
                none: '暂无相关数据' //默认：无数据。注：该属性为 layui 2.2.5 开始新增
            }
            , skin: 'line'
            , even: true
        });

        //监听表格头部头工具栏事件
        table.on('toolbar(groupTableFilter)', function (obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            switch (obj.event) {
                case 'addGroupEvent':
                    AddGroupAjaxgetAllUserlist();
                    layer.open({
                        type: 1,
                        area: ['500px', '500px'],
                        title: '添加权限组',
                        shadeClose: true,
                        content: $('#addGroupDiv') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                        , end: function () {
                            //重置表单信息
                            resetForm()
                        }
                    });
                    break;
                case 'delGroupEvent':
                    var data = checkStatus.data;
                    if (data.length == 0) {
                        layer.msg('选中了：' + data.length + ' 个');
                        return;
                    }
                    var ids = '';
                    $.each(data, function (k, val) {
                        ids += val.id + ',';
                    });
                    ids = ids.substring(0, ids.length - 1);
                    layer.confirm('真的删除' + data.length + '行么', function (index) {
                        ajaxRequest('{:url("auth/ajax_del_group")}', {id: ids}, 'post', true);
                        layer.msg('选中了：' + data.length + ' 个');
                    });
                    break;
                case 'searchGroupEvent':
                    layer.open({
                        type: 1,
                        area: '500px',
                        title: '搜索',
                        shadeClose: true,
                        content: $('#searchDiv') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                    });
                    break;
                case 'refreshGroupEvent':
                    layui.use('table', function () {
                        var table = layui.table;
                        table.reload('groupTableReload', {
                            where: {
                                search: ''
                            }
                            //,height: 300
                            , page: {
                                curr: obj.config.page.curr //重新从第 1 页开始
                                , limit: obj.config.page.limit
                            }
                        });
                    });
                    break;

            }
        });
        //监听行工具事件
        table.on('tool(groupTableFilter)', function (obj) {
                var data = obj.data;
                if (obj.event === 'del') {
                    layer.confirm('真的删除行么', function (index) {
                        ajaxRequest('{:url("auth/ajax_del_group")}', {id: data.id}, 'post');
                        obj.del();
                        layer.close(index);
                    });
                } else if (obj.event === 'edit') {
                    // console.log(data);
                    // 编辑权限组
                    data.status = (data.status == '正常') ? 'on' : '';
                    layui.use(['form'], function () {
                        var form = layui.form
                        $.ajax({
                            url: '{:url("auth/ajax_edit_group")}',
                            type: 'get',
                            dataType: 'json',
                            data: {id: data.id,type:'ajax_get_group_byId'},
                            cache: false,
                            async: true,
                            beforeSend: function () {
                                var index = layer.load(1, {
                                    shade: [0.1, '#fff'], time: 2 * 1000 //0.1透明度的白色背景
                                });
                            },
                            complete: function () {
                                layer.close('loading');
                            },
                            success: function (res) {
                                // console.log(res);
                                if (res.code == 0) {
                                    layer.msg(res.msg);
                                    return false;
                                }

                                res.data.status = (res.data.status == '正常') ? 'on' : '';
                                var userIds = res.data.userIds;

                                //编辑前已有的组和角色 取差集 删除
                                var userIdsStrs = '';
                                $.each(userIds, function (k, val) {
                                    userIdsStrs += val + ',';
                                })
                                if (res.code) {
                                    form.val("editGroupForm", {
                                        "title": res.data.title
                                        , "status": res.data.status
                                        , 'id': res.data.id
                                        , 'have_user_ids': userIdsStrs
                                    });
                                    //赋值已有的权限组 有问题 赋值失败
                                    editGroupAjaxgetAllUserlist(userIds);
                                } else {
                                    layer.msg(res.msg, {icon: 5});
                                }
                                return false;
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                            }
                        });
                    });
                    layer.open({
                        type: 1,
                        area: ['500px', '500px'],
                        title: '编辑权限组',
                        shadeClose: true,
                        content: $('#editGroupDiv') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                        , end: function () {
                            resetForm();
                        }
                    });
                } else if (obj.event == 'allocationAuth') {

                    var index = layer.open({
                        title: '分配权限',
                        type: 2,
                        shadeClose: true,
                        content: '{:url("auth/allocation_auth")}' + '?group_id=' + data.id,
                        area: ['1200px', '600px'],
                        maxmin: true
                    });
                }
            }
        );
    });
</script>
</body>
</html>
