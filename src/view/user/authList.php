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
<!--create auth start-->
<div id="addAuthDiv" style="display: none">
    <form class="layui-form" lay-filter="addAuthForm">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">权限分组</label>
                <div class="layui-input-block" style="width: 350px">
                    <select name="parent_id" xm-select="add_auth_select_parent" xm-select-radio=""  lay-verify="required", lay-verType="tips" xm-select-max="3" xm-select-search="" xm-select-search-type="dl">
                        <option value="">请选择</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限规则</label>
            <div class="layui-input-block" style="width: 350px">
                <input type="text" name="name" required lay-verify="required" placeholder="请输规则Controller/action"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限名称</label>
            <div class="layui-input-block" style="width: 350px">
                <input type="text" name="title" required placeholder="请输权限中文名称" autocomplete="off"
                       class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">规则表达式</label>
            <div class="layui-input-block" style="max-width: 350px">
                <input type="text" name="condition" placeholder="请输规则表达式"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">请求方式</label>
            <div class="layui-input-block" style="max-width: 350px">
                <input type="text" name="method" placeholder="get/post/put/delete"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" lay-skin="switch" lay-text="开启|禁用" checked>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="addAuthSubmitFilter">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<!--create auth end-->
<!--edit auth start-->
<div id="editAuthDiv" style="display: none">
    <form class="layui-form" lay-filter="editAuthForm">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">权限分组</label>
                <div class="layui-input-block" style="width: 350px">
                    <select name="parent_id" xm-select="edit_auth_select_parent" xm-select-radio=""  lay-verify="required", lay-verType="tips" xm-select-max="3" xm-select-search="" xm-select-search-type="dl">
                        <option value="">请选择</option>

                    </select>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限规则</label>
            <div class="layui-input-block" style="max-width: 350px">
                <input type="text" name="name" required lay-verify="required" placeholder="请输规则Controller/action"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限名称</label>
            <div class="layui-input-block" style="max-width: 350px">
                <input type="text" name="title" required placeholder="请输权限中文名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">规则表达式</label>
            <div class="layui-input-block" style="max-width: 350px">
                <input type="text" name="condition" placeholder="请输规则表达式"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">请求方式</label>
            <div class="layui-input-block" style="max-width: 350px">
                <input type="text" name="method" placeholder="get/post/put/delete"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="checkbox" name="status" lay-skin="switch" lay-text="开启|禁用" checked>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="hidden" name="id"/>
                <button class="layui-btn" lay-submit lay-filter="editAuthSubmitFilter">立即提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<!--edit auth end-->
<!--search html start-->
<div id="searchDiv" style="display: none">
    <form class="layui-form" lay-filter="searchForm">
        <div class="layui-form-item" style="margin-top: 35px">
            <label class="layui-form-label">查询条件</label>
            <div class="layui-input-block" style="width: 300px">
                <input type="text" name="search" required lay-verify="required" placeholder="规则或者名称"
                       autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="searchAuthSubmit">搜索</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</div>
<!--search html end-->
<!--table hear menu start -->
<script type="text/html" id="headTool">
    <div class="layui-btn-container">
        <button type="button" class="layui-btn  layui-btn-sm" lay-event="addAuthEvent"><i
                    class="layui-icon"></i></button>
        <button type="button" class="layui-btn layui-btn-danger layui-btn-sm" lay-event="delAuthEvent"><i
                    class="layui-icon"></i></button>
        <button type="button" class="layui-btn layui-btn-normal layui-btn-sm" lay-event="searchAuthEvent">
            <i class="layui-icon">&#xe615;</i></button>
        <button type="button" class="layui-btn layui-btn-warm layui-btn-sm" lay-event="refreshAuthEvent">
            <i class="layui-icon">&#xe669;</i></button>

    </div>
</script>
<!--table hear menu end -->
<!-- Tab start-->
<div class="layui-tab layui-tab-brief" lay-filter="authListTabBrief">
    <ul class="layui-tab-title">
        <li class="layui-this">权限列表</li>
        <li>树形列表</li>
    </ul>
    <div class="layui-tab-content" style="height: 100px;">
        <div class="layui-tab-item layui-show">
            <table class="layui-hide" id="authTablelistId" lay-filter="authTableFilter"></table>
        </div>
        <div class="layui-tab-item">
            <div class="layui-btn-container">
<!--                <button type="button" class="layui-btn layui-btn-sm" lay-demo="getChecked">获取选中节点数据</button>-->
<!--                <button type="button" class="layui-btn layui-btn-sm" lay-demo="setChecked">勾选指定节点</button>-->

                <button type="button" class="layui-btn layui-btn-sm" lay-demo="reload">重新加载</button>
            </div>
            <div id="authTree" class="demo-tree demo-tree-box" style="overflow: scroll;"></div>
        </div>
    </div>
</div>
<!-- Tab end-->
<!--list action start-->
<script type="text/html" id="action">
    <a class="layui-btn layui-btn-xs" lay-event="editAuthEvent">编辑</a>
    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delAuthEvent">删除</a>
    <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="testAuthEvent">测试</a>
</script>
<!--list action end-->
<!--ajax start-->
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
                            table.reload('authTableId', {
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
    //设置select选中
    function formSelectValue(select, value) {

        layui.use(['jquery', 'formSelects'], function () {
            var formSelects = layui.formSelects;
            formSelects.value(select, value)
        });
    }
    //添加权限加载已有的权限选着所属父级权限 auth select option
    function AddAuthAjaxgetAllAuthlist() {
        layui.use(['jquery', 'formSelects'], function () {
            var formSelects = layui.formSelects;
            $.ajax({
                url: '{:url("auth/get_auth_all")}',
                type: 'GET',
                dataType: 'json',
                data: {type:'select_tree_json'},
                cache: false,
                async: true,
                beforeSend: function () {
                    layer.load(1, {
                        shade: [0.1, '#fff'], time: 2 * 1000 //0.1透明度的白色背景
                    });
                },
                complete: function (){
                    layer.closeAll('loading');
                },
                success: function (res) {
                    // console.log(res);
                    layui.formSelects.data('add_auth_select_parent', 'local', {
                        // arr: [
                        //     {name: '分组1', type: 'optgroup'},
                        //     {name: '北京', value: 1, xslkdf: '123', children: [{name: '朝阳', disabled: true, value: 11}, {name: '海淀', value: 12}]},
                        //     {name: '分组2', type: 'optgroup'},
                        //     {name: '深圳', value: 2, children: [{name: '龙岗', value: 21}]},
                        // ],
                        arr:res.auths,
                        tree: {
                            //在点击节点的时候, 如果没有子级数据, 会触发此事件
                            nextClick: function(id, item, callback){
                                // console.log(id);
                                // console.log(item);
                                //需要在callback中给定一个数组结构, 用来展示子级数据
                                // callback([
                                //     {name: 'test1', value: Math.random()},
                                //     {name: 'test2', value: Math.random()}
                                // ])
                                 layer.msg('没有了'); return ;
                                //TODO 展示不了子选项
                                // $.ajax({
                                //     url: '{:url("auth/get_auth_all")}',
                                //     type: 'GET',
                                //     dataType: 'json',
                                //     data: {type:'select_tree_json',parent_id:item.value},
                                //     cache: false,
                                //     async: true,
                                //     beforeSend: function () {
                                //         // layer.load(1, {
                                //         //     shade: [0.1, '#fff'], time: 2 * 1000 //0.1透明度的白色背景
                                //         // });
                                //     },
                                //     complete: function () {
                                //         // layer.closeAll('loading');
                                //     },
                                //     success: function (res) {
                                //         console.log(res);
                                //         if(res == 'notChildren'){
                                //             layer.msg('没有了'); return ;
                                //         }
                                //          callback(res)
                                //          return false;
                                //     },
                                //     error: function (XMLHttpRequest, textStatus, errorThrown) {
                                //         layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                                //     }
                                // });
                            },
                        }
                    });
                    return false;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                }
            });

            //这里也算是给自己挖了一手好坑吧, 简单的一种处理方式, 在多选第一次打开的时候收缩所有的子节点, 目前处理的很粗鲁, 就是为了一种效果, 收缩全部节点
            var isFirst = true;
            layui.formSelects.opened('add_auth_select_parent', function(id){
                if(isFirst){
                    isFirst = false;
                    $('[fs_id="add_auth_select_parent"]').find('.xm-cz i.icon-caidan').click();
                }
            });
        });
        // $.ajax({
        //     url: '{:url("auth/get_auth_all")}',
        //     type: 'GET',
        //     dataType: 'json',
        //     data: {},
        //     cache: false,
        //     async: true,
        //     beforeSend: function () {
        //         layer.load(1, {
        //             shade: [0.1, '#fff'], time: 2 * 1000 //0.1透明度的白色背景
        //         });
        //     },
        //     complete: function () {
        //         layer.close('loading');
        //     },
        //     success: function (res) {
        //         $("#parent_id").html(res.auths);
        //         //刷新select选择框渲染
        //         layui.use('form', function () {
        //             var form = layui.form;
        //             form.render('select');
        //         })
        //         return false;
        //     },
        //     error: function (XMLHttpRequest, textStatus, errorThrown) {
        //         layer.alert('网络失败，请刷新页面后重试', {icon: 2});
        //     }
        // });
    }

    //编辑加载auth to to html option
    /**
     * 编辑权限加载 auth select option
     * @param editId 编辑的哪一个ID
     * @param checkedID 默认选中的select option
     */
    function editAuthAjaxgetAllAuthlist(checkedID, editID) {
        console.log(checkedID);
        layui.use(['jquery', 'formSelects'], function () {
            var formSelects = layui.formSelects;
            $.ajax({
                url: '{:url("auth/get_auth_all")}',
                type: 'GET',
                dataType: 'json',
                data: {type:'select_tree_json', edit_id: editID},
                cache: false,
                async: true,
                beforeSend: function () {
                    layer.load(1, {
                        shade: [0.1, '#fff'], time: 2 * 1000 //0.1透明度的白色背景
                    });
                },
                complete: function (){
                    layer.closeAll('loading');
                },
                success: function (res) {
                    // console.log(res);
                    layui.formSelects.data('edit_auth_select_parent', 'local', {
                        arr:res.auths,
                        tree: {
                            //在点击节点的时候, 如果没有子级数据, 会触发此事件
                            nextClick: function(id, item, callback){
                                layer.msg('没有了'); return ;
                            },
                        }
                    });
                    // checkedID == 0 的时候选中不了select
                    if(checkedID == 0) checkedID = -1
                    formSelectValue('edit_auth_select_parent', [checkedID]);
                    return false;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                }
            });
            var isFirst = true;
            layui.formSelects.opened('edit_auth_select_parent', function(id){
                if(isFirst){
                    isFirst = false;
                    $('[fs_id="edit_auth_select_parent"]').find('.xm-cz i.icon-caidan').click();
                }
            });
        });
        // $.ajax({
        //     url: '{:url("auth/get_auth_all")}',
        //     type: 'GET',
        //     dataType: 'json',
        //     data: {check_id: checkedID, edit_id: editID},
        //     cache: false,
        //     async: true,
        //     beforeSend: function () {
        //         layer.load(2, {
        //             shade: [0.1, '#fff'], time: 2 * 1000 //0.1透明度的白色背景
        //         });
        //     },
        //     complete: function () {
        //         layer.closeAll('loading');
        //     },
        //     success: function (res) {
        //         $("#edit_parent_id").html(res.auths);
        //         //刷新select选择框渲染
        //         layui.use('form', function () {
        //             var form = layui.form;
        //             form.render('select');
        //         })
        //         return false;
        //     },
        //     error: function (XMLHttpRequest, textStatus, errorThrown) {
        //         layer.alert('网络失败，请刷新页面后重试', {icon: 2});
        //     }
        // });
    }
</script>
<!--ajax end-->
<!--tab start-->
<script>
    //重置编辑表单
    function resetEditFrom() {
        layui.use('form', function () {
            var form = layui.form;
            //表单初始复制
            form.val("editAuthForm", {
                "name": ''
                , "title": ''
                , "status": 'on'
                , "method": ''
                , "condition": ''
                // , "parent_id": data.parent_id
                , 'id': ''
            });
        });
    }

    //tab
    layui.use(['tree', 'util', 'element'], function () {
        var $ = layui.jquery
            , element = layui.element; //Tab的切换功能，切换事件监听等，需要依赖element模块
        var tree = layui.tree
            , layer = layui.layer
            , util = layui.util;

        //加载树形表格数据
        function loadTree() {
            $.ajax({
                url: '{:url("auth/get_auth_all/treejson")}',
                type: 'GET',
                dataType: 'json',
                data: {},
                cache: false,
                async: true,
                beforeSend: function () {
                    layer.load(2, {
                        shade: [0.1, '#fff'], time: 2 * 1000 //0.1透明度的白色背景
                    });
                },
                complete: function () {
                    layer.closeAll();
                },
                success: function (res) {
                    // console.log(res.auths);
                    tree.render({
                        elem: '#authTree'
                        , data: res.auths
                        , id: 'authTreeId'
                        , showCheckbox: true
                        , isJump: true  //link 为参数匹配
                        , onlyIconControl: true  //是否仅允许节点左侧图标控制展开收缩
                        // ,showLine: false  //是否开启连接线
                        , edit: ['add', 'del'] //操作节点的图标
                        , click: function (obj) {
                            var data = obj.data;  //获取当前点击的节点数据
                            // console.log(data);
                            // console.log('状态：'+ obj.state);
                            // layer.msg('状态：'+ obj.state + '<br>节点数据：' + JSON.stringify(data));
                            layer.confirm('纳尼？', {
                                btn: ['编辑', '删除', '取消'] //可以无限个按钮
                                , btn3: function (index, layero) {
                                    //按钮【按钮三】的回调
                                    resetEditFrom();
                                    console.log('取消');
                                }
                            }, function (index, layero) {
                                //按钮【按钮一】的回调
                                // console.log('编辑');
                                //创建编辑树形节点
                                // console.log(data);
                                if (data.title != '未命名' && data.auth_title != 'undefined') {
                                    //编辑数形节点 填充数据
                                    layui.use('form', function () {
                                        var form = layui.form;
                                        editAuthAjaxgetAllAuthlist(data.parent_id, data.id);
                                        //表单初始复制
                                        form.val("editAuthForm", {
                                            "name": data.auth_name
                                            , "title": data.auth_title
                                            , "status": (data.auth_status == '禁用') ? '' : 'on'
                                            , "method": data.method
                                            , "condition": data.condition
                                            // , "parent_id": data.parent_id
                                            , 'id': data.id
                                        });
                                    });
                                    layer.open({
                                        type: 1,
                                        area: '500px',
                                        title: '编辑权限',
                                        shadeClose: true,
                                        content: $('#editAuthDiv'), //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                                        yes: function(index, layero){
                                            layer.msg('yes');
                                            return false;
                                        },
                                        cancel: function(index, layero){
                                            layer.msg('cancel');
                                            layer.closeAll('page');
                                            return false;
                                        }
                                        , end : function(index, layero){
                                            resetEditFrom();
                                            // loadTree();
                                            return false;
                                        }
                                    });
                                } else {
                                    AddAuthAjaxgetAllAuthlist();
                                    layer.open({
                                        type: 1,
                                        area: '500px',
                                        title: '添加权限',
                                        shadeClose: true,
                                        content: $('#addAuthDiv'),
                                        yes: function(index, layero){
                                            layer.msg('yes');
                                            return false;
                                        },
                                        cancel: function(index, layero){
                                            layer.msg('cancel');
                                        }
                                        , end : function(index, layero){
                                            resetEditFrom();
                                            loadTree();
                                            return false;
                                        }
                                    });
                                }
                                return false;

                            }, function (index) {
                                // console.log('删除');
                                //按钮【按钮二】的回调
                                if (data.title != '未命名' && data.auth_title != 'undefined'){
                                    layer.confirm('真的删除权限么', function (index) {
                                        ajaxRequest('{:url("auth/ajax_del_auth")}', {id: data.id}, 'post');
                                    })
                                }
                            });

                        }
                        , operate: function (obj) {
                            var type = obj.type; //得到操作类型：add、edit、del
                            var data = obj.data; //得到当前节点的数据
                            var elem = obj.elem; //得到当前节点元素
                            // console.log(type);
                            // console.log(data);
                            //Ajax 操作
                            var id = data.id; //得到节点索引
                            if (type === 'add') { //增加节点
                                //返回 key 值
                                return 123;
                            } else if (type === 'update') { //修改节点
                                // console.log(elem.find('.layui-tree-txt').html()); //得到修改后的内容
                                return 123;
                            } else if (type === 'del') { //删除节点
                                if (data.title != '未命名' && data.auth_title != 'undefined') {
                                    layer.confirm('真的删除权限么', function (index) {
                                        ajaxRequest('{:url("auth/ajax_del_auth")}', {id: data.id}, 'post');
                                    })

                                }
                            };
                        }
                    });
                    return false;
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                }
            });
        };

        util.event('lay-demo', {
            getChecked: function (othis) {
                var checkedData = tree.getChecked('authTreeId'); //获取选中节点的数据
                layer.alert(JSON.stringify(checkedData), {shade: 0});
                // console.log(checkedData);
            }
            , setChecked: function () {
                tree.setChecked('authTreeId', [12, 16]); //勾选指定节点
            }
            , reload: function () {
                //重载实例
                layer.msg('重载实例');
                loadTree();
                // tree.reload('authTreeId', {
                //     where: {} //设定异步数据接口的额外参数
                //     //,height: 300
                //     , page: {
                //         curr: 1 //重新从第 1 页开始
                //     }
                // });
            }
        });
        //监听tab切换事件
        element.on('tab(authListTabBrief)', function (data) {
            //开启节点操作图标
            if (data.index == 1) {
                loadTree();
            }
        });
    });
</script>
<!--tab end-->
<script>
    //监听表单提交事件
    layui.use('form', function () {
        var form = layui.form;
        //监听提交
        form.on('submit(addAuthSubmitFilter)', function (data) {
            ajaxRequest('{:url("auth/ajax_add_auth")}', data.field, 'POST', true);
//            layer.msg(JSON.stringify(data.field));
            return false;
        });

        form.on('submit(editAuthSubmitFilter)', function (data) {
            // console.log(data);
            ajaxRequest('{:url("auth/ajax_edit_auth")}', data.field, 'POST', true);
//            layer.msg(JSON.stringify(data.field));
            return false;
        });
        form.on('submit(searchAuthSubmit)', function (data) {
            layui.use('table', function () {
                var table = layui.table;
                table.reload('authTableId', {
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
            elem: '#authTablelistId'
            , url: '{:url("auth/ajax_get_auth_list")}'
            , toolbar: '#headTool'
            , title: '权限列表'
            , cols: [[
                {type: 'checkbox', fixed: 'left'}
                , {field: 'id', title: 'ID', width: 60, fixed: 'left', unresize: true, sort: true, align: 'center'}
                , {field: 'name', title: '规则', width: 260, edit: 'text', align: 'center', sort: true}
                , {
                    field: 'title', title: '权限名称', width: 150, edit: 'text', templet: function (res) {
                        return '<em>' + res.title + '</em>'
                    }, align: 'left'
                }
                , {field: 'method', title: '请求方式', align: 'center'}
                , {field: 'status', title: '状态', align: 'center', sort: true}
                , {field: 'condition', title: '规则表达式', align: 'center'}
                , {field: 'created_at', title: '创建时间',  align: 'center', sort: true}
                , {fixed: 'right', title: '操作', toolbar: '#action', align: 'center'}
            ]]
            , page: true
            , id: 'authTableId'
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
        table.on('toolbar(authTableFilter)', function (obj) {
            var checkStatus = table.checkStatus(obj.config.id);
            switch (obj.event) {
                case 'addAuthEvent':
                    //加载所有的权限规则 selete option
                    AddAuthAjaxgetAllAuthlist();
                    layer.open({
                        type: 1,
                        area: '500px',
                        title: '添加权限',
                        shadeClose: true,
                        content: $('#addAuthDiv') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                    });
                    break;
                case 'delAuthEvent':
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
                    layer.confirm('真的删除' + data.length + '行权限么', function (index) {
                        ajaxRequest('{:url("auth/ajax_del_auth")}', {id: ids}, 'post', true);
                    });
                    break;
                case 'searchAuthEvent':
                    layer.open({
                        type: 1,
                        area: '500px',
                        title: '搜索',
                        shadeClose: true,
                        content: $('#searchDiv') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                    });
                    break;
                case 'refreshAuthEvent':
                    layui.use('table', function () {
                        var table = layui.table;
                        table.reload('authTableId', {
                            where: {
                                search: ''
                            }
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
        table.on('tool(authTableFilter)', function (obj) {
                var data = obj.data;
                if (obj.event === 'delAuthEvent') {
                    layer.confirm('真的删除权限么', function (index) {
                        $.ajax({
                            url: '{:url("auth/ajax_del_auth")}',
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
                                layer.close(index);
                            },
                            success: function (res) {
                                if (res.code) {
                                    layer.msg(res.msg, {icon: 1});
                                     obj.del();
                                } else {
                                    layer.msg(res.msg, {icon: 5});
                                }
                                return false;
                            },
                            error: function (XMLHttpRequest, textStatus, errorThrown) {
                                layer.alert('网络失败，请刷新页面后重试', {icon: 2});
                            }
                        });
                        layer.close(index);
                    });
                } else if (obj.event === 'editAuthEvent') {
                    data.status = (data.status == '开启') ? 'on' : '';
                    // console.log(data);
                    //加载所有的权限规则 selete option
                    editAuthAjaxgetAllAuthlist(data.parent_id, data.id);
                    layui.use('form', function () {
                        var form = layui.form;
                        //表单初始复制
                        // var item = $("select[name='parent_id'] option[value=26]").attr("selected", true);//设置Select的Text值为jQuery的项选中
                        // var item = $(".layui-select-group  dd[lay-alue='26']").attr("selected", true);   //设置Select的Text值为jQuery的项选中
                        form.val("editAuthForm", {
                            "name": data.name
                            , "title": data.title
                            , "status": data.status
                            , "method": data.method
                            , "condition": data.condition
                            , 'id': data.id
                            // , 'parent_id': data.parent_id
                        });
                    });
                    layer.open({
                        type: 1,
                        area: '500px',
                        title: '编辑权限',
                        shadeClose: true,
                        content: $('#editAuthDiv') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
                    });
                } else if (obj.event === 'testAuthEvent') {
                    layer.msg('开发中...有兴趣+Q554665488');
                }
            }
        );
    });
</script>
</body>
</html>
