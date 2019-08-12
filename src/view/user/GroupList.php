<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{$layui_css}" media="all">
    <script src="{$jquery}" charset="utf-8"></script>
    <script src="{$layui_js}" charset="utf-8"></script>

</head>
<body>
<!--add group html start-->
<div id="addGroupDiv" style="display: none">
    <form class="layui-form" lay-filter="addUserForm">
        <div class="layui-form-item">
            <label class="layui-form-label">用户组名</label>
            <div class="layui-input-block" style="width: 300px">
                <input type="text" name="user_name" required lay-verify="required" placeholder="请输入用户组名"
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
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="addUserSubmit">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<!--add group html end-->
<!--edit group html start-->

<!--edit group html end-->
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
        <button type="button" class="layui-btn  layui-btn-sm" lay-event="addGroupEvent"><i
                    class="layui-icon"></i></button>
        <!--        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" lay-event="getCheckData"><i class="layui-icon"></i></button>-->
        <button type="button" class="layui-btn layui-btn-danger layui-btn-sm" lay-event="delGroupEvent"><i
                    class="layui-icon"></i></button>
        <button type="button" class="layui-btn layui-btn-normal layui-btn-sm" lay-event="searchGroupEvent">
            <i class="layui-icon">&#xe615;</i></button>
        <button type="button" class="layui-btn layui-btn-warm layui-btn-sm" lay-event="refreshGroupEvent">
            <i class="layui-icon">&#xe669;</i></button>

    </div>
</script>
<div class="layui-form">
    <div class="layui-fluid">
        <div class="layui-form layui-col-md12">
            <div class="layui-form-item">
                <div class="layui-col-md4">
                    <label class="layui-form-label">城市<span style="color:red">●</span></label>
                    <div class="layui-input-block">
                        <select name="select_base_cityname" id="select_base_cityname" lay-filter="select_base_cityname" xm-select="select_base_cityname" xm-select-type="1">
                            <option value=""></option>
                            <option value="1">北京</option>
                            <option value="2">上海</option>
                            <option value="3">天津</option>
                            <option value="4">重庆</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="layui-row ">
                <div class="test-table-reload-btn" style="margin-bottom: 10px;">
                    <button type="button" class="layui-btn layui-btn-danger" lay-submit lay-filter="btn_submit" id="btn_submit"><i class="layui-icon">&#xe681</i>获取</button>


                </div>
            </div>
        </div>
    </div>
</div>
<!--table head tools html end-->
<!--<table class="layui-hide" id="groupTableHtmlId" lay-filter="groupTableFilter"></table>-->
<!--table list action start-->
<script type="text/html" id="action">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>
<!--table list action end-->
<script>
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
                    shade: [0.1,'#fff'],time: 2 * 1000 //0.1透明度的白色背景
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
                            table.reload('userTableRelod', {
                                where: {} //设定异步数据接口的额外参数
                                //,height: 300
                                , page: {
                                    curr: 1 //重新从第 1 页开始
                                }
                            });
                        });
                    }
                    layer.closeAll();
                },1000)
                return false;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                layer.alert('网络失败，请刷新页面后重试', {icon: 2});
            }
        });
    }
</script>

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
            if(data.field.password.length == 0 ) delete data.field.password;
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
                table.reload('userTableRelod', {
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
            , title: '用户数据表'
            , cols: [[
                {type: 'checkbox', fixed: 'left'}
                , {field: 'id', title: 'ID', width: 100, fixed: 'left', unresize: true, sort: true, align:'center'}
                , {field: 'title', title: '用户组名称', edit: 'text', sort: true, align:'center'}
                , {field: 'status', title: '状态', align:'center'}
                , {field: 'created_at', title: '创建时间', align:'center'}
                , {fixed: 'right', title: '操作', toolbar: '#action', align:'center'}
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
                    if(data.length == 0 ){
                        layer.msg('选中了：' + data.length + ' 个'); return;
                    }
                    var ids = '';
                    $.each(data,function (k,val) {
                        ids += val.id + ',';
                    });
                    ids = ids.substring(0,ids.length-1);
                    layer.confirm('真的删除'+data.length+'行么', function (index) {
                        ajaxRequest('{:url("auth/ajax_del_user")}', {id:ids}, 'post',true);
                        layer.msg('选中了：' + data.length + ' 个');
                    });
                    break;
                case 'searchUsersEvent':
                    layer.open({
                        type: 1,
                        area: '500px',
                        title: '搜索',
                        shadeClose: true,
                        content: $('#searchDiv') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                    });
                    break;
                case 'refreshUsersEvent':
                    layui.use('table', function () {
                        var table = layui.table;
                        table.reload('userTableRelod', {
                            where: {
                                search: ''
                            }
                            //,height: 300
                            , page: {
                                curr: obj.config.page.curr //重新从第 1 页开始
                                ,limit:obj.config.page.limit
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
                        ajaxRequest('{:url("auth/ajaxDelUser")}', {id:data.id}, 'post');
                        obj.del();
                        layer.close(index);
                    });
                } else if (obj.event === 'edit') {
                    data.status = (data.status == '正常') ? 'on' : '';
                    data.sex = (data.sex == '女') ? 2 : 1;
                    layui.use('form', function () {
                        var form = layui.form;
                        //表单初始复制
                        form.val("editForm", {
                            "user_name":  data.user_name
                            ,"email": data.email
                            ,"status": data.status
                            ,"sex": data.sex
                            ,'id':data.id
                        });
                    });
                    layer.open({
                        type: 1,
                        area: '500px',
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
