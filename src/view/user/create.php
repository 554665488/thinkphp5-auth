<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{$staticDir}layui/css/layui.css"  media="all">
    <script src="{$staticDir}layui/layui.js" charset="utf-8"></script>
</head>
<body>


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
<script type="text/html" id="toolbar">
    <div class="layui-btn-container">
        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm"><i class="layui-icon"></i></button>
        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm"><i class="layui-icon"></i></button>
        <button type="button" class="layui-btn layui-btn-primary layui-btn-sm"><i class="layui-icon"></i></button>
    </div>
</script>
<fieldset class="layui-elem-field site-demo-button">

</fieldset>
<table class="layui-hide" id="userTableList" lay-filter="userTableList" ></table>
<script type="text/html" id="barDemo">
    <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
</script>

<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->

<script>
    layui.use('table', function(){
        var table = layui.table;
        table.render({
            elem: '#userTableList'
            ,url:'getUsers'
            ,toolbar: '#toolbar'
            ,title: '用户数据表'
            ,cols: [[
                {type: 'checkbox', fixed: 'left'}
                ,{field:'id', title:'ID', width:80, fixed: 'left', unresize: true, sort: true}
                ,{field:'username', title:'用户名', width:120, edit: 'text'}
                ,{field:'email', title:'邮箱', width:150, edit: 'text', templet: function(res){
                    return '<em>'+ res.email +'</em>'
                }}
                ,{field:'sex', title:'性别', width:80, edit: 'text', sort: true}
                // ,{field:'city', title:'城市', width:100}
                ,{field:'sign', title:'签名'}
                ,{field:'experience', title:'积分', width:80, sort: true}
                ,{field:'ip', title:'IP', width:120}
                ,{field:'logins', title:'登入次数', width:100, sort: true}
                ,{field:'joinTime', title:'加入时间', width:120}
                ,{fixed: 'right', title:'操作', toolbar: '#barDemo', width:150}
            ]]
            ,page: true
            ,id: 'userTableReload'
            ,height: 'full-200'
            ,cellMinWidth: 80
            ,limit:30
        });

        //头工具栏事件
        table.on('toolbar(userTableList)', function(obj){
            var checkStatus = table.checkStatus(obj.config.id);
            switch(obj.event){
                case 'getCheckData':
                    var data = checkStatus.data;
                    layer.alert(JSON.stringify(data));
                    break;
                case 'getCheckLength':
                    var data = checkStatus.data;
                    layer.msg('选中了：'+ data.length + ' 个');
                    break;
                case 'isAll':
                    layer.msg(checkStatus.isAll ? '全选': '未全选');
                    break;
            };
        });

        //监听行工具事件
        table.on('tool(userTableList)', function(obj){
            var data = obj.data;
            //console.log(obj)
            if(obj.event === 'del'){
                layer.confirm('真的删除行么', function(index){
                    obj.del();
                    layer.close(index);
                });
            } else if(obj.event === 'edit'){
                layer.prompt({
                    formType: 2
                    ,value: data.email
                }, function(value, index){
                    obj.update({
                        email: value
                    });
                    layer.close(index);
                });
            }
        });
        var $ = layui.$, active = {
            reload: function(){
                var userTableReload = $('#userTable');

                //执行重载
                table.reload('userTableReload', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    ,where: {
                        key: {
                            id: userTableReload.val()
                        }
                    }
                }, 'data');
            }
        };

        $('.userTable .layui-btn').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
</body>
</html>
