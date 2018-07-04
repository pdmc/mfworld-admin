<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"/var/www/us4yo-miraila-admin/public/../admin/task/view/task/lists.html";i:1524808910;s:65:"/var/www/us4yo-miraila-admin/public/../admin/extra/view/main.html";i:1524451346;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<!--<link rel="icon" href="/public/favicon.ico" type="image/x-icon">-->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>北京帕可福优科技有限公司</title>
<link rel="stylesheet" href="_ADMIN_/layer/css/layui.css">
<style type="text/css">

  .header-demo .logo {
      left: 18px;
  }
  .logo {
    position: absolute;
    left: 0;
    top: 16px;
    font-size: 22px;
    color: #fff;
  }

  .header .layui-nav {
    position: absolute;
    left: 202px;
    top: 0;
    padding: 0;
  }
</style>
</head>

<!--添加任务start-->
    <div id='motai' style="display:none">
        <form id='data-form' class="layui-form" method="post">
            <table class="layui-table">
                <tbody>
                    <tr>
                        <td> <span style="color:red">*</span>任务名称：</td>
                        <td>  
                            <input type="text"  name="name" required  lay-verify="required" placeholder="任务名称"  autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td><span style="color:red">*</span>任务类型：</td>
                        <td>  
                            <select name="type" lay-verify="required">
                                <option value="">--请选择--</option>
                                <?php if(is_array(\think\Config::get('task_type')) || \think\Config::get('task_type') instanceof \think\Collection || \think\Config::get('task_type') instanceof \think\Paginator): $i = 0; $__LIST__ = \think\Config::get('task_type');if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $key; ?>"><?php echo $vo; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td> <span style="color:red">*</span>达成条件：</td>
                        <td>  
                            <input type="text"  name="num" required  lay-verify="required" placeholder="达成条件"  autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>任务奖励：</td>
                        <td>  
                            <input type="text"  name="reward" tmpname='one'  placeholder="任务奖励"   class="layui-input" required  lay-verify="required"/>
                        </td>
                    </tr>
                    <tr>
                        <td>排&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp序：</td>
                        <td>
                            <input type="text" name="sort"  placeholder="排序" value="0" autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' style="text-align: center;">  
                            <button class="layui-btn addSubmit" lay-submit lay-filter="formDemo" type="button">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
<!--添加任务end-->

<!--编辑任务start-->
    <div id='editmotai' style="display:none">
        <form id='editdata-form' class="layui-form" method="post" enctype="multipart/form-data">
            <table class="layui-table">
                <tbody>
                    <tr>
                        <td> <span style="color:red">*</span>任务名称：</td>
                        <td>  
                            <input type="text"  name="name" required  lay-verify="required" placeholder="任务名称"  autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td><span style="color:red">*</span>任务类型：</td>
                        <td>  
                            <select name="type" lay-verify="required">
                                <option value="">--请选择--</option>
                                <?php if(is_array(\think\Config::get('task_type')) || \think\Config::get('task_type') instanceof \think\Collection || \think\Config::get('task_type') instanceof \think\Paginator): $i = 0; $__LIST__ = \think\Config::get('task_type');if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $key; ?>"><?php echo $vo; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    
                    <tr>
                        <td> <span style="color:red">*</span>达成条件：</td>
                        <td>  
                            <input type="text"  name="num" required  lay-verify="required" placeholder="达成条件"  autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>任务奖励：</td>
                        <td>  
                            <input type="text"  name="reward" tmpname='one'  placeholder="任务奖励"   class="layui-input" required  lay-verify="required"/>
                        </td>
                    </tr>
                    <tr>
                        <td>排&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp序：</td>
                        <td>
                            <input type="text" name="sort"  placeholder="排序" value="0" autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' style="text-align: center;">  
                            <input type='hidden' name="id">
                            <input type='hidden' name="action" value='post'>
                            <button class="layui-btn editsubmit" lay-submit lay-filter="formDemo" type="button">立即提交</button>
                            <!--<button type="reset" class="layui-btn layui-btn-primary">重置</button>-->
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
<!--编辑任务end-->

<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header header header-demo">
        <div class="layui-main">
            <a class="logo" href="<?php echo url('index/Index/index'); ?>"> PK4YO后台管理</a>
            <ul style="left:90%;" class="layui-nav">
                <li class="layui-nav-item">
                    <a href="javascript:;"><?php echo \think\Session::get('nick_name'); ?>(<?php echo \think\Session::get('user_name'); ?>)</a>
                    <dl class="layui-nav-child">
                       <dd><a href="<?php echo url('index/Index/personaldata'); ?>">个人中心</a></dd>
                       <dd><a href="<?php echo url('login/Login/logout'); ?>">退出</a></dd>
                    </dl>
                </li>
            </ul>
        </div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
    </div>
    <div class="layui-side layui-bg-gray">
        <div class="layui-side-scroll" id="sidebar">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                <?php if(is_array($menuData) || $menuData instanceof \think\Collection || $menuData instanceof \think\Paginator): $m = 0; $__LIST__ = $menuData;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($m % 2 );++$m;?>
                    <li class="layui-nav-item layui-nav-itemed has-sub  child-menu<?php echo $vo['id']; if($vo['id'] == $currentpriId): ?>open<?php endif; ?>">
                        <a class="" href="javascript:;"><?php echo $vo['title']; ?></a>
                        <dl class="layui-nav-child sub"  <?php if($vo['id'] != $currentpriId): ?>style="display:none;"<?php endif; ?>>
                            <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?>
                                <dd <?php if($v2['name'] == $path): ?>class='layui-this'<?php endif; ?>><a href="<?php echo url($v2['name']); ?>" style="margin-left:20px;" ><?php echo $v2['title']; ?></a></dd>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </dl>
                    </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
    <div class="layui-body">
        <!-- 内容主体区域 -->
        
    <div style="width:100%;height:50px;border-bottom:1px solid #E2E2E2;line-height:50px;padding-left:30px;">
        <span class="layui-breadcrumb" style="font-size:20px">
            <a href="javascript:;">任务</a>
            <a><cite>任务列表</cite></a>
        </span>
    </div>
    <div style="float:right;">
        <?php 
            if(showHandle('task/Task/addTask')){
         ?>
            <span class="layui-btn addTask" style="margin-bottom:5px;">添加任务</span>
        <?php 
            }
         ?>
    </div>
    <table lay-even class="layui-table" style="margin-top:-16px;">
        <thead>
            <tr> 
                <th style='width:5%;'>ID</th>
                <th style='width:15%;'>任务名称</th>
                <th style='width:10%;'>任务类型</th>
                <th style='width:10%;'>达成条件</th>
                <th style='width:10%;'>任务奖励</th>
                <th style='width:8%;'>状态</th>
                <th style='width:5%;'>排序</th>
                <th style='width:15%;'>添加时间</th>
                <th style='width:22%;'>操作</th>
            </tr> 
        </thead>
        <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $vo['id']; ?></td>
                    <td><?php echo $vo['name']; ?></td>
                    <td><?php echo \think\Config::get('task_type')[$vo['type']]; ?></td>
                    <td><?php echo $vo['num']; ?></td>
                    <td><?php echo $vo['reward']; ?></td>
                    <td><?php if(1 == $vo['status']): ?>
                            <span style="color:green;">启用</span>
                        <?php else: ?>
                            <span >禁用</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $vo['sort']; ?></td>
                    <td>
                        <?php if($vo['create_time'] != '0000-00-00 00:00:00'): ?>
                            <?php echo date("Y-m-d H:i:s",$vo['create_time']); endif; ?>
                    </td>
                    <td>
                        <?php 
                            if(showHandle('task/Task/editTask')){
                         ?>
                            <button class="layui-btn layui-btn-small editTask" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>编辑</button>
                        <?php 
                            }
                            if(showHandle('task/Task/onOffTask')){
                         if($vo['status'] != '1'): ?>
                                <button class="layui-btn layui-btn-small onOffTask" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>开启</button>
                            <?php else: ?>    
                                <button class="layui-btn layui-btn-small onOffTask" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>关闭</button>
                            <?php endif; 
                            }
                            if(showHandle('problem/Problem/delTask')){
                         ?>
                            <button class="layui-btn layui-btn-small delTask" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>删除</button>
                        <?php 
                            }
                         ?>
                    </td>
                </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <?php echo $page; ?>

    </div>
    <!-- <div class="layui-footer"> -->
      <!-- 底部固定区域 -->
    <!-- </div> -->
</div>
<script src="_ADMIN_/layer/layui.js"></script>
<script>

layui.use(['element','jquery','form',], function() {
    var element = layui.element();
    var $= layui.jquery;
    var layer = layui.layer;
    var form = layui.form();
    //左侧菜单点击
    var handleMainMenu = function () {
        $('#sidebar .has-sub > a').click(function () {
            $('.sub').slideUp(200);
            var last = $('.has-sub.open', $('#sidebar'));
            last.removeClass("open");
            $('.arrow', last).removeClass("open");
            $('.sub', last).slideUp(200);
            var sub = $(this).next();
            if (sub.is(":visible")) {
                $('.arrow', $(this)).removeClass("open");
                $(this).parent().removeClass("open");
                sub.slideUp(200);
            } else {
                $('.arrow', $(this)).addClass("open");
                $(this).parent().addClass("open");
                sub.slideDown(200);
            }
        });
    };
    handleMainMenu();
});


</script>

<!-- JavaScript代码区域 -->

<script> 
    layui.use('layer', function() {
        layui.use(['form', 'jquery', 'laypage'], function() {
            var $ = layui.jquery, layer = layui.layer,form = layui.form();
            //弹出添加任务模态框
            $('.addTask').click(function() {
                layer.open({
                    closeBtn: 2,
                    type: 1,
                    area: '600px',
                    title: '添加任务',
                    content: $('#motai')
                });
            });
            //提交添加任务信息
            $('.addSubmit').click(function() {
                var name = $("#data-form input[name='name']").val();
                var type = $("#data-form select[name='type']").val();
                var num = $("#data-form input[name='num']").val();
                var reward = $("#data-form input[name='reward']").val();
                
                if (name.length < 1) {
                    layer.msg('请填写任务名称!');
                    return false;
                }
                if (type.length < 1) {
                    layer.msg('请选择任务类型!');
                    return false;
                }
                if (num.length < 1) {
                    layer.msg('请填写任务条件!');
                    return false;
                }
                if (reward.length < 1) {
                    layer.msg('请填写任务奖励!');
                    return false;
                }
                
                var From = $('#data-form').serialize();
                layer.open({
                    type:3,
                    success: function(layero, index){ 
                        $.ajax({
                            url: "<?php echo url('addTask'); ?>",
                            data: From,
                            type: 'post',
                            success: function(d) {
                                var res = eval("(" + d + ")");
                                if (res.flag == 1) {
                                    layer.msg(res.msg,{icon:1,time:2000},function(){
                                        layer.closeAll(); //疯狂模式，关闭所有层
                                        window.location.reload();//刷新当前页面.
                                    });
                                }else{
                                    layer.closeAll('loading'); //关闭加载层
                                }
                            }
                        });
                    }
                });
            });
            //编辑任务信息
            $('.editTask').click(function() {
                var id = $(this).attr('data-id');
                if (id.length<1){ return false;}
                $.ajax({
                    url: "<?php echo url('editTask'); ?>",
                    type: 'post',
                    data: {'id':id,'action':'get'},
                    success: function(d) {
                        var result = eval("(" + d + ")");
                        if (result.flag == 1) {
                            var data = result.data;
                            $('#editdata-form input[name="name"]').val(data.name);
                            $('#editdata-form select[name="type"]').find("option[value='"+data.type+"']").attr("selected",true);
                            $('#editdata-form input[name="num"]').val(data.num);
                            $('#editdata-form input[name="reward"]').val(data.reward);
                            $('#editdata-form input[name="sort"]').val(data.sort);
                            $('#editdata-form input[name="id"]').val(data.id);
                            form.render();
                        }else{
                            layer.msg(result.msg);
                            window.location.reload();//刷新当前页面.
                        }
                        layer.open({
                            closeBtn: 2,
                            type: 1,
                            area: '600px',
                            title: '编辑任务',
                            content: $('#editmotai')
                        });
                    }
                });
            });
            //提交编辑试题信息表单
            $('.editsubmit').click(function() {
                var name = $("#editdata-form input[name='name']").val();
                var type = $("#editdata-form select[name='type']").val();
                var num = $("#editdata-form input[name='num']").val();
                var reward = $("#editdata-form input[name='reward']").val();
                if (name.length < 1) {
                    layer.msg('请填写任务名称!');
                    return false;
                }
                if (type.length < 1) {
                    layer.msg('请选择任务类型!');
                    return false;
                }
                if (num.length < 1) {
                    layer.msg('请填写任务条件!');
                    return false;
                }
                if (reward.length < 1) {
                    layer.msg('请填写任务奖励!');
                    return false;
                }
                
                var From = $('#editdata-form').serialize();
                layer.open({
                    type:3,
                    success: function(layero, index){  
                        $.ajax({
                            url: "<?php echo url('editTask'); ?>",
                            type: 'POST',
                            data: From,
                            success: function(d) {
                                var result = eval("(" + d + ")");
                                if (result.flag == 1) {
                                    layer.msg(result.msg,{icon:1,time:2000},function(){
                                        layer.closeAll(); //疯狂模式，关闭所有层
                                        window.location.reload();//刷新当前页面.
                                    });
                                }else{
                                    layer.closeAll('loading'); //关闭加载层
                                    layer.msg(result.msg);
                                }
                            }
                        });
                    }
                });     
            });
            //开启关闭
            $('.onOffTask').click(function(){
                var id = $(this).attr('data-id');
                if (id.length<1){ return false;}
                layer.confirm('确认此操作？',function(){
                    layer.open({
                        type:3,
                        success: function(layero, index){  
                            $.ajax({
                                url: "<?php echo url('onOffTask'); ?>",
                                type: 'POST',
                                data: {'id':id},
                                success: function(d) {
                                    var result = eval("(" + d + ")");
                                    if (result.flag == 1) {
                                        layer.msg(result.msg,{icon:1,time:2000},function(){
                                            layer.closeAll(); //疯狂模式，关闭所有层
                                            window.location.reload();//刷新当前页面.
                                        });
                                    }else{
                                        layer.closeAll('loading'); //关闭加载层
                                        layer.msg(result.msg);
                                    }
                                }
                            });
                        }
                    }); 
                });
            });
            
             //删除任务
            $('.delTask').click(function(){
                var id = $(this).attr('data-id');
                if (id.length<1){ return false;}
                layer.confirm('确认删除此操作？',function(){
                    layer.open({
                        type:3,
                        success: function(layero, index){  
                            $.ajax({
                                url: "<?php echo url('delTask'); ?>",
                                type: 'POST',
                                data: {'id':id},
                                success: function(d) {
                                    var result = eval("(" + d + ")");
                                    if (result.flag == 1) {
                                        layer.msg(result.msg,{icon:1,time:2000},function(){
                                            layer.closeAll(); //疯狂模式，关闭所有层
                                            window.location.reload();//刷新当前页面.
                                        });
                                    }else{
                                        layer.closeAll('loading'); //关闭加载层
                                        layer.msg(result.msg);
                                    }
                                }
                            });
                        }
                    }); 
                });
            });
        });
    });
</script>

</body>
</html>
