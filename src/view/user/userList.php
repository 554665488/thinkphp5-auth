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
<!--add user html start-->
<div id="addUserDiv" style="display: none">
    <form class="layui-form" lay-filter="addUserForm">
        <div class="layui-form-item">
            <label class="layui-form-label">选择权限组</label>
            <div class="layui-input-block" style="width: 300px">
                <select name="group_id" xm-select="example2_1" lay-verify="required" xm-select-search=""
                        xm-select-search-type="dl">
                    <option value="1">用户组1</option>
                    <option value="2">用户组2</option>
                    <option value="3">用户组3</option>
                    <option value="4">用户组4</option>
                    <option value="5">用户组5</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">选择角色</label>
            <div class="layui-input-block" style="width: 300px">
                <select name="role_id" xm-select="example2_2" lay-verify="required" xm-select-search=""
                        xm-select-search-type="dl">
                    <option value="8">CEO</option>
                    <option value="9">市场经理</option>
                    <option value="1">产品经理</option>
                    <option value="2">项目经理</option>
                    <option value="3">研发PHP</option>
                    <option value="4">研发Java</option>
                    <option value="5">研发C++</option>
                    <option value="6">UI</option>
                    <option value="7">财务</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block" style="width: 300px">
                <input type="text" name="user_name" required lay-verify="required" placeholder="请输入用户名"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block" style="width: 300px">
                <input type="text" name="email" required placeholder="请输入邮箱" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-inline">
                <input type="password" name="password" required lay-verify="required" placeholder="请输入密码"
                       autocomplete="off" class="layui-input">
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" lay-skin="switch" lay-text="开启|禁用">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block">
                <input type="radio" name="sex" value="1" title="男" id="man">
                <input type="radio" name="sex" value="2" title="女" id='woman'>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="addUserSubmit">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<!--add user html end-->
<!--edit user html start-->
<div id="editUserDiv" style="display: none">
    <form class="layui-form" lay-filter="editForm">
        <div class="layui-form-item">
            <label class="layui-form-label">选择权限组</label>
            <div class="layui-input-block" style="width: 300px">
                <select name="group_id" xm-select="example2_3" lay-verify="required" xm-select-search=""
                        xm-select-search-type="dl">
                    <option value="1">用户组1</option>
                    <option value="2">用户组2</option>
                    <option value="3">用户组3</option>
                    <option value="4">用户组4</option>
                    <option value="5">用户组5</option>
                </select>
                <input type="hidden" name="have_group_ids" value="">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">选择角色</label>
            <div class="layui-input-block" style="width: 300px">
                <select name="role_id" xm-select="example2_4" lay-verify="required" xm-select-search=""
                        xm-select-search-type="dl">
                    <option value="8">CEO</option>
                    <option value="9">市场经理</option>
                    <option value="1">产品经理</option>
                    <option value="2">项目经理</option>
                    <option value="3">研发PHP</option>
                    <option value="4">研发Java</option>
                    <option value="5">研发C++</option>
                    <option value="6">UI</option>
                    <option value="7">财务</option>
                </select>
                <input type="hidden" name="have_role_ids" value="">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block" style="width: 300px">
                <input type="text" name="user_name" required lay-verify="required" placeholder="请输入用户名"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">邮箱</label>
            <div class="layui-input-block" style="width: 300px">
                <input type="text" name="email" required placeholder="请输入邮箱" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-inline">
                <input type="password" name="password" placeholder="请输入密码"
                       autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" lay-skin="switch" lay-text="开启|禁用">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">性别</label>
            <div class="layui-input-block">
                <input type="radio" name="sex" value="1" title="男" id="man">
                <input type="radio" name="sex" value="2" title="女" id='woman'>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" value="" name="id" id="user_id"/>
                <input type="hidden" value="" name="del_group_ids" id="del_group_ids"/>
                <input type="hidden" value="" name="del_role_ids" id="del_role_ids"/>
                <button class="layui-btn" lay-submit lay-filter="editUserSubmit">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<!--edit user html end-->
<!--search html start-->
<div id="searchDiv" style="display: none">
    <form class="layui-form" lay-filter="searchForm">
        <div class="layui-form-item">
            <label class="layui-form-label">查询条件</label>
            <div class="layui-input-block" style="width: 300px">
                <input type="text" name="search" required lay-verify="required" placeholder="用户名或邮箱"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="searchUserSubmit">搜索</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<!--search html end-->
<!--table head tools html start-->
<script type="text/html" id="headTool">
    <div class="layui-btn-container">

        <button type="button" class="layui-btn  layui-btn-sm" lay-event="addUserEvent"><i
                    class="layui-icon"></i></button>
        <!--        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" lay-event="getCheckData"><i class="layui-icon"></i></button>-->
        <button type="button" class="layui-btn layui-btn-danger layui-btn-sm" lay-event="delUsersEvent"><i
                    class="layui-icon"></i></button>
        <button type="button" class="layui-btn layui-btn-normal layui-btn-sm" lay-event="searchUsersEvent">
            <i class="layui-icon">&#xe615;</i></button>
        <button type="button" class="layui-btn layui-btn-warm layui-btn-sm" lay-event="refreshUsersEvent">
            <i class="layui-icon">&#xe669;</i></button>

    </div>
</script>
<!--table head tools html end-->
<table class="layui-hide" id="userTableId" lay-filter="userTableFilter"></table>
<!--table list action start-->
<!--<div class="layui-form">-->
<!--    <select name="city" xm-select="example2_22">-->
<!--        <option value="1" selected="selected">北京</option>-->
<!--        <option value="2">上海</option>-->
<!--        <option value="3">广州</option>-->
<!--        <option value="4">深圳</option>-->
<!--        <option value="5">天津</option>-->
<!--    </select>-->
<!--    <button class="layui-btn example-btn" onclick="test()">赋值 北京,上海</button>-->
<!--</div>-->
<script type="text/html" id="action">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<!--table list action end-->
<script>
    //重置添加用户的表单
    function resetForm(form) {
        layui.use(['form', 'formSelects'], function () {
            var form = layui.form;
            var formSelects = layui.formSelects;
            //重置选择权限组
            layui.formSelects.value('example2_1', []);
            //重置选择角色
            layui.formSelects.value('example2_2', []);
            //表单初始复制
            form.val('addUserForm', {
                "user_name": ''
                , "email": ''
                , "status": ''
                , "sex": ''
                , "password": ''
                , 'group_id': ''
                , 'role_id': ''
            });
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
                    resetForm();
                    layer.msg(res.msg, {icon: 1});
                } else {
                    layer.msg(res.msg, {icon: 5});
                }
                //表格重载
                setTimeout(function () {
                    if (isReload) {
                        layui.use('table', function () {
                            var table = layui.table;
                            table.reload('userTableReload', {
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
</script>
<!--selectfrom js start-->
<script>
    //设置select选中
    function formSelectValue(select, value) {
        layui.use(['jquery', 'formSelects'], function () {
            var formSelects = layui.formSelects;
            formSelects.value(select, value)
        });
    }

    layui.use(['jquery', 'formSelects'], function () {
        var formSelects = layui.formSelects;
        var del_group_ids = '', del_role_ids = '';
        formSelects.on('example2_3', function (id, vals, val, isAdd, isDisabled) {
            if (isAdd == false) {
                del_group_ids += val.value + ',';
            }
            $('#del_group_ids').val(del_group_ids.substring(0, del_group_ids.length - 1));
            //id:           点击select的id
            //vals:         当前select已选中的值
            //val:          当前select点击的值
            //isAdd:        当前操作选中or取消
            //isDisabled:   当前选项是否是disabled

            //如果return false, 那么将取消本次操作
            // return false;
        });
        formSelects.on('example2_4', function (id, vals, val, isAdd, isDisabled) {

            if (isAdd == false) {
                del_role_ids += val.value + ',';
            }
            $('#del_role_ids').val(del_role_ids.substring(0, del_role_ids.length - 1));
        });
        // layui.formSelects.data('select_user_div', 'local', {
        //     arr: [
        //         {name: '分组1', type: 'optgroup'},
        //         {name: '北京', value: 1, xslkdf: '123', children: [{name: '朝阳', disabled: true, value: 11}, {name: '海淀', value: 12}]},
        //         {name: '分组2', type: 'optgroup'},
        //         {name: '深圳', value: 2, children: [{name: '龙岗', value: 21}]},
        //     ],
        //     tree: {
        //         //在点击节点的时候, 如果没有子级数据, 会触发此事件
        //         nextClick: function(id, item, callback){
        //             //需要在callback中给定一个数组结构, 用来展示子级数据
        //             callback([
        //                 {name: 'test1', value: Math.random()},
        //                 {name: 'test2', value: Math.random()}
        //             ])
        //         },
        //     }
        // });
        //
        // //这里也算是给自己挖了一手好坑吧, 简单的一种处理方式, 在多选第一次打开的时候收缩所有的子节点, 目前处理的很粗鲁, 就是为了一种效果, 收缩全部节点
        // var isFirst = true;
        // layui.formSelects.opened('select_user_div', function(id){
        //     if(isFirst){
        //         isFirst = false;
        //         $('[fs_id="select_user_div"]').find('.xm-cz i.icon-caidan').click();
        //     }
        // });
    });

</script>
<!--selectfrom js end-->
<script>
    //监听表单提交事件
    layui.use('form', function () {
        var form = layui.form;
        //监听提交
        form.on('submit(addUserSubmit)', function (data) {

            ajaxRequest('{:url("auth/ajax_add_user")}', data.field, 'POST', true);
//            layer.msg(JSON.stringify(data.field));
            return false;
        });

        form.on('submit(editUserSubmit)', function (data) {
            //没有填写密码 视为不更新密码
            if (data.field.password.length == 0) delete data.field.password;
//            console.log(data);
            ajaxRequest('{:url("auth/ajax_edit_user")}', data.field, 'POST', true);
//            layer.msg(JSON.stringify(data.field));
            return false;
        });
        form.on('submit(searchUserSubmit)', function (data) {
//            ajaxRequest('{:url("auth/ajaxGetUserList")}', data.field, 'POST', true);
//            layer.msg(JSON.stringify(data.field));
            layui.use('table', function () {
                var table = layui.table;
                table.reload('userTableReload', {
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
            elem: '#userTableId'
            , url: '{:url("auth/ajax_get_user_list")}'
            , toolbar: '#headTool'
            , title: '用户数据表'
            , cols: [[
                {type: 'checkbox', fixed: 'left'}
                , {field: 'id', title: 'ID', width: 100, fixed: 'left', unresize: true, sort: true, align: 'center'}
                , {field: 'user_name', title: '用户名', width: 150, edit: 'text', align: 'center'}
                , {
                    field: 'email', title: '邮箱', edit: 'text', width: 200, templet: function (res) {
                        return '<em>' + res.email + '</em>'
                    }, align: 'center'
                }
                , {field: 'sex', title: '性别', edit: 'text', sort: true, align: 'center'}
                // ,{field:'city', title:'城市', width:100}
                , {field: 'status', title: '状态', align: 'center'}
                , {field: 'experience', title: '积分', sort: true, align: 'center'}
                , {field: 'ip', title: 'IP', align: 'center'}
                , {field: 'login_count', title: '登入次数', sort: true, align: 'center'}
                , {field: 'created_at', title: '加入时间', align: 'center'}
                , {fixed: 'right', title: '操作', toolbar: '#action', align: 'center'}
            ]]
            , page: true
            , id: 'userTableReload' //重载表格
            , height: 'full-30'
            , cellMinWidth: 80
            , limit: '{$limit}' //使用配置的数量 默认30
            , text: {
                none: '暂无相关数据' //默认：无数据。注：该属性为 layui 2.2.5 开始新增
            }
            , skin: 'line'
            , even: true
        });

        //监听表格头部头工具栏事件
        table.on('toolbar(userTableFilter)', function (obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            switch (obj.event) {
                case 'addUserEvent':
                    layer.open({
                        type: 1,
                        area: '500px',
                        title: '添加用户',
                        shadeClose: true,
                        content: $('#addUserDiv') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                    });
                    break;
                case 'delUsersEvent':
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
                        ajaxRequest('{:url("auth/ajax_del_user")}', {id: ids}, 'post', true);
                        layer.msg('选中了：' + data.length + ' 个');
                    });
                    break;
                case 'searchUsersEvent':
                    layer.open({
                        type: 1,
                        area: ['500px', '500px'],
                        title: '搜索',
                        shadeClose: true,
                        content: $('#searchDiv') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                    });
                    break;
                case 'refreshUsersEvent':
                    layui.use('table', function () {
                        var table = layui.table;
                        table.reload('userTableReload', {
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
        table.on('tool(userTableFilter)', function (obj) {
                var data = obj.data;
                if (obj.event === 'del') {
                    layer.confirm('真的删除行么', function (index) {
                        ajaxRequest('{:url("auth/ajax_del_user")}', {id: data.id}, 'post');
                        obj.del();
                        layer.close(index);
                    });
                } else if (obj.event === 'edit') {
                    // console.log(data);
                    //编辑用户
                    // data.status = (data.status == '正常') ? 'on' : '';
                    // data.sex = (data.sex == '女') ? 2 : 1;
                    layui.use(['form'], function () {
                        var form = layui.form
                        //表单初始复制
                        // TODO 编辑用户 修改为动态从数据库获取
                        $.ajax({
                            url: '{:url("auth/ajax_get_user")}',
                            type: 'post',
                            dataType: 'json',
                            data: {id: data.id},
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
                                //console.log(res);
                                res.data.status = (res.data.status == '正常') ? 'on' : '';
                                res.data.sex = (res.data.sex == '女') ? 2 : 1;
                                var groupIds = res.data.groupIds;
                                var roleIds = res.data.roleIds;
                                //编辑前已有的组和角色 取差集 删除
                                var groupIdsStrs = '', roleIdsStr = '';
                                $.each(groupIds, function (k, val) {
                                    groupIdsStrs += val + ',';
                                })
                                $.each(roleIds, function (k, v) {
                                    roleIdsStr += v + ',';
                                })

                                if (res.code) {
                                    form.val("editForm", {
                                        "user_name": res.data.user_name
                                        , "email": res.data.email
                                        , "status": res.data.status
                                        , "sex": res.data.sex
                                        , 'id': res.data.id
                                        , 'have_group_ids': groupIdsStrs
                                        , 'have_role_ids': roleIdsStr
                                    });
                                    //赋值权限组和角色
                                    formSelectValue('example2_3', groupIds);
                                    formSelectValue('example2_4', roleIds);
                                } else {
                                    layer.msg(res.msg, {icon: 5});
                                }
                                //表格重载
                                // setTimeout(function () {
                                //     layui.use('table', function () {
                                //         var table = layui.table;
                                //         table.reload('userTableReload', {
                                //             where: {} //设定异步数据接口的额外参数
                                //             //,height: 300
                                //             , page: {
                                //                 curr: 1 //重新从第 1 页开始
                                //             }
                                //         });
                                //     });
                                //     layer.closeAll();
                                // }, 1000)
                                return false;
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                            }
                        });
                    });
                    layer.open({
                        type: 1,
                        area: ['500px', '600px'],
                        title: '编辑用户',
                        shadeClose: true,
                        content: $('#editUserDiv') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                    });
                }
            }
        );
    });
</script>
</body>
</html>
