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


<div id="authTree" class="demo-tree-more"></div>

<div class="layui-form-item" style="text-align: center">
    <div class="layui-input-block">
        <div class="layui-btn-container">
            <input type="hidden" name="group_id" id="group_id" value="{$group_id}"/>
            <button type="button" class="layui-btn" lay-demo="getChecked">提交</button>
        </div>
    </div>
</div>
<script>
    //Demo
    $(document).ready(function(){
        layui.use(['tree', 'util', 'form'], function () {
            var form = layui.form, tree = layui.tree, util = layui.util
            var group_id = $('#group_id').val();
            if(group_id.length == 0 ) {
                layer.msg('group_id异常'); return;
            }
               $.ajax({
                   url: '{:url("auth/allocation_auth")}' + '?group_id=' + group_id,
                   type: 'get',
                   dataType: 'json',
                   data: {},
                   cache: false,
                   async: true,
                   beforeSend: function () {
                       var index = layer.load(1, {
                           shade: [0.1, '#fff'], time: 2 * 1000 //0.1透明度的白色背景
                       });
                   },
                   complete: function () {
                       layer.closeAll('loading');
                   },
                   success: function (res) {
                       //console.log(res);
                       if (res.code) {
                           // layer.msg(res.msg, {icon: 1});
                           tree.render({
                               elem: '#authTree'
                               ,data: res.data.authTree
                               ,showCheckbox: true  //是否显示复选框
                               ,id: 'authTreeId'
                               ,isJump: true //是否允许点击节点时弹出新窗口跳转
                               ,onlyIconControl: true  //是否仅允许节点左侧图标控制展开收缩
                               ,click: function(obj){
                                   var data = obj.data;  //获取当前点击的节点数据
                                   layer.msg('状态：'+ obj.state + '<br>节点数据：' + JSON.stringify(data));
                               }
                           });
                           tree.setChecked('authTreeId', res.data.checkedIds); //批量勾选 id 为 2、3 的节点
                       } else {
                           layer.msg('加载失败...', {icon: 5});
                           return  false;
                       }

                       return false;
                   },
                   error: function (XMLHttpRequest, textStatus, errorThrown) {
                       layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                   }
               });
               //按钮事件
               util.event('lay-demo', {
                   getChecked: function(othis){
                       var checkedData = tree.getChecked('authTreeId'); //获取选中节点的数据
                       // console.log(auth_ids);
                       // layer.alert(JSON.stringify(checkedData), {shade:0});
                       $.ajax({
                           url: '{:url("auth/allocation_auth")}',
                           type: 'post',
                           dataType: 'json',
                           data: {checkedData:checkedData,group_id:group_id},
                           cache: false,
                           async: true,
                           beforeSend: function () {
                               var index = layer.load(1, {
                                   shade: [0.1, '#fff'], time: 2 * 1000 //0.1透明度的白色背景
                               });
                           },
                           complete: function () {
                               layer.closeAll('loading');
                           },
                           success: function (res) {
                               // console.log(res);
                               if (res.code) {
                                   layer.msg(res.msg, {icon: 1});

                               } else {
                                   layer.msg(res.msg, {icon: 5});
                                   return  false;
                               }
                               return false;
                           },
                           error: function (XMLHttpRequest, textStatus, errorThrown) {
                               layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                           }
                       });
                       console.log(checkedData);
                   }
                   ,setChecked: function(){
                       tree.setChecked('authTreeId', [12, 16]); //勾选指定节点
                   }
                   ,reload: function(){
                       //重载实例
                       tree.reload('authTreeId', {

                       });

                   }
               });

        });
    })
</script>
</body>
</html>
