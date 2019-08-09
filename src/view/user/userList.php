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
<div id="addUser" style="display: none">
    <form class="layui-form" lay-filter="userForm">
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
                <button class="layui-btn" lay-submit lay-filter="addUser">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<div id="editUser" style="display: none">
    <form class="layui-form" lay-filter="editForm">
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
                <input type="password" name="password"  placeholder="请输入密码"
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
                <button class="layui-btn" lay-submit lay-filter="editUser">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>

<!--<script type="text/html" id="toolbarDemo">-->
<!--    <div class="layui-btn-container">-->
<!--        <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>-->
<!--        <button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button>-->
<!--        <button class="layui-btn layui-btn-sm" lay-event="isAll">验证是否全选</button>-->
<!--    </div>-->
<!--</script>-->

<!--<div class="userTable">-->
<!--    <div class="layui-inline">-->
<!--        <input class="layui-input" placeholder="搜索ID：" name="id" id="demoReload" autocomplete="off">-->
<!--    </div>-->
<!--    <button class="layui-btn" data-type="reload">搜索</button>-->
<!--</div>-->
<script type="text/html" id="headTool">
    <div class="layui-btn-container">
        <!--        <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>-->
        <!--        <button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button>-->
        <!--        <button class="layui-btn layui-btn-sm" lay-event="isAll">验证是否全选</button>-->
        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" lay-event="addUser"><i
                    class="layui-icon"></i></button>
        <!--        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" lay-event="getCheckData"><i class="layui-icon"></i></button>-->
        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm" lay-event="delUsers"><i
                    class="layui-icon"></i></button>
    </div>
</script>

<table class="layui-hide" id="userTable" lay-filter="userTable"></table>
<script type="text/html" id="action">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>

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
                index = layer.load(1, {time: 2 * 1000});
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
                layer.closeAll();
                //表格重载
                if (isReload) {
                    layui.use('table', function () {
                        var table = layui.table;
                        table.reload('userTable', {
                            where: {} //设定异步数据接口的额外参数
                            //,height: 300
                            , page: {
                                curr: 1 //重新从第 1 页开始
                            }
                        });
                    });
                }
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
        form.on('submit(addUser)', function (data) {
            ajaxRequest('{:url("auth/addUser")}', data.field, 'POST', true);
//            layer.msg(JSON.stringify(data.field));
            return false;
        });

        form.on('submit(editUser)', function (data) {
            //没有填写密码 视为不更新密码
            if(data.field.password.length == 0 ) delete data.field.password;
            console.log(data);
            ajaxRequest('{:url("auth/editUser")}', data.field, 'POST', true);
//            layer.msg(JSON.stringify(data.field));
            return false;
        });
    });

    layui.use('table', function () {
        var table = layui.table;
        //表格渲染
        table.render({
            elem: '#userTable'
            , url: '{:url("auth/getUsers")}'
            , toolbar: '#headTool'
            , title: '用户数据表'
            , cols: [[
                {type: 'checkbox', fixed: 'left'}
                , {field: 'id', title: 'ID', width: 100, fixed: 'left', unresize: true, sort: true, align:'center'}
                , {field: 'user_name', title: '用户名', width: 150, edit: 'text', align:'center'}
                , {
                    field: 'email', title: '邮箱', width: 200, edit: 'text', templet: function (res) {
                        return '<em>' + res.email + '</em>'
                    }, align:'center'
                }
                , {field: 'sex', title: '性别', width: 140, edit: 'text', sort: true, align:'center'}
                // ,{field:'city', title:'城市', width:100}
                , {field: 'status', title: '状态', width: 120, align:'center'}
                , {field: 'experience', title: '积分', width: 80, sort: true, align:'center'}
                , {field: 'ip', title: 'IP', align:'center', width: 200}
                , {field: 'login_count', title: '登入次数', width: 120, sort: true, align:'center'}
                , {field: 'created_at', title: '加入时间', width: 200, align:'center'}
                , {fixed: 'right', title: '操作', toolbar: '#action', width: 300, align:'center'}
            ]]
            , page: true
            , id: 'userTable'
            , height: 'full-30'
            , cellMinWidth: 80
            , limit: 30
            , text: {
                none: '暂无相关数据' //默认：无数据。注：该属性为 layui 2.2.5 开始新增
            }
            , skin: 'line'
            , even: true
        });

        //监听表格头部头工具栏事件
        table.on('toolbar(userTable)', function (obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            switch (obj.event) {
                case 'addUser':
                    layer.open({
                        type: 1,
                        area: '500px',
                        shadeClose: true,
                        content: $('#addUser') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                    });
                    break;
                case 'delUsers':
                    var data = checkStatus.data;
                    if(data.length == 0 ){
                        layer.msg('选中了：' + data.length + ' 个'); return;
                    }
                    var ids = '';
                    $.each(data,function (k,val) {
                        ids += val.id + ',';
                    })
                    ids = ids.substring(0,ids.length-1);

                    ajaxRequest('{:url("auth/delUser")}', {id:ids}, 'post',true);
                    layer.msg('选中了：' + data.length + ' 个');
                    break;
            }
        });
//        //头工具栏事件
//        table.on('toolbar(userTable)', function(obj){
//            var checkStatus = table.checkStatus(obj.config.id);
//            switch(obj.event){
//                case 'getCheckData':
//                    var data = checkStatus.data;
//                    layer.alert(JSON.stringify(data));
//                    break;
//                case 'getCheckLength':
//                    var data = checkStatus.data;
//                    layer.msg('选中了：'+ data.length + ' 个');
//                    break;
//                case 'isAll':
//                    layer.msg(checkStatus.isAll ? '全选': '未全选');
//                    break;
//            };
//        });
        //监听行工具事件
        table.on('tool(userTable)', function (obj) {
                var data = obj.data;
                if (obj.event === 'del') {
                    layer.confirm('真的删除行么', function (index) {
                        ajaxRequest('{:url("auth/delUser")}', {id:data.id}, 'post');
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
                        shadeClose: true,
                        content: $('#editUser') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                    });
//                layer.prompt({
//                    formType: 2
//                    , value: data.email
//                }, function (value, index) {
//                    obj.update({
//                        email: value
//                    });
//                    layer.close(index);
//                });
                }
            }
        );

    });
</script>
</body>
</html>
