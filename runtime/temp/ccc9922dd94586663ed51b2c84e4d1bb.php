<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:80:"/var/www/us4yo-miraila-admin/public/../admin/privilege/view/admin/adminlist.html";i:1524553930;s:65:"/var/www/us4yo-miraila-admin/public/../admin/extra/view/main.html";i:1524451346;}*/ ?>
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

<!--添加管理员start-->
    <div id='motai' style="display:none">
        <form id='data-form' class="layui-form" method="post" enctype="multipart/form-data">
            <table class="layui-table">
                <tbody>
                    <tr>
                        <td> <span style="color:red">*</span>真实姓名</td>
                        <td>  
                            <input type="text"  name="username" required  lay-verify="required" placeholder="真实姓名" autocomplete="off"  value="" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>登陆账号</td>
                        <td>  
                            <input type="text"  name="user" required  lay-verify="required" placeholder="登陆账号" value="" autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>登陆密码</td>
                        <td>
                            <input type="text" name="pwd" required lay-verify="required" placeholder="登陆密码" value="" autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>联系方式</td>
                        <td>
                            <input type="text" name="phone" required lay-verify="required" placeholder="联系方式" autocomplete="off" class="layui-input" value="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' style="text-align: center;">  
                            <button class="layui-btn addpersonsubmit" lay-submit lay-filter="formDemo" type="button">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
<!--添加管理员end-->
<!--编辑管理员start-->
    <div id='editmotai' style="display:none">
        <form id='editdata-form' class="layui-form" method="post" enctype="multipart/form-data">
            <table class="layui-table">
                <tbody>
                    <tr>
                        <td> <span style="color:red">*</span>真实姓名</td>
                        <td><input type="text"  name="username" required  lay-verify="required" placeholder="真实姓名" autocomplete="off" class="layui-input"></td>
                    </tr>
                    <tr>
                        <td><span style="color:red">*</span>登陆账号</td>
                        <td><input type="text"  name="user"  required  lay-verify="required" placeholder="登陆账号" autocomplete="off" class="layui-input"></td>
                    </tr>
                    <tr>
                        <td><span style="color:red">*</span>联系方式</td>
                        <td><input type="text" name="phone" required lay-verify="required" placeholder="联系方式" autocomplete="off" class="layui-input"></td>
                    </tr>
                    <tr>
                        <td colspan='2' style="text-align: center;">  
                            <input type='hidden' name="id">
                            <input type='hidden' name="action" value='post'>
                            <button class="layui-btn editsubmit" lay-submit lay-filter="formDemo" type="button">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
<!--编辑管理员end-->

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
            <a href="javascript:;">权限</a>
            <a><cite>管理员列表</cite></a>
        </span>
    </div>
    <div style="float:right;">
        <?php 
            if(showHandle('privilege/Admin/addPerson')){
         ?>
            <span class="layui-btn addPerson" style="margin-bottom:5px;">添加人员</span>
        <?php 
            }
         ?>
    </div>
    <form class="layui-form" action="<?php echo url('Admin/adminlist'); ?>" method="get" style="margin-top:2px;">
        <div class="layui-form-item" style="margin-left:5px;">
            
            <div class="layui-inline">
                <select name="member_status">
                    <option value="1" selected>正常用户</option>
                    <option value="all" <?php if(\think\Request::instance()->get('member_status') == 'all'): ?>selected<?php endif; ?>>所有用户</option>
                    <option value="-1" <?php if(\think\Request::instance()->get('member_status') == '-1'): ?>selected<?php endif; ?>>禁用用户</option>
                </select>
            </div>
            <div class="layui-inline">
                <button class="layui-btn">搜索</button>
            </div>
        </div>
    </form>
    <table lay-even class="layui-table" style="margin-top:-16px;">
        <thead>
            <tr> 
                <th style='width:5%;'>ID</th>
                <th style='width:10%;'>登陆账号</th>
                <th style='width:10%;'>真实姓名</th>
                <th style='width:10%;'>状态</th>
                <th style='width:10%;'>联系方式</th>
                <th style='width:15%;'>创建时间</th>
                <th style='width:25%;'>操作</th>
            </tr> 
        </thead>
        <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $vo['id']; ?></td>
                    <td><?php echo $vo['nick_name']; ?></td>
                    <td><?php echo $vo['user_name']; ?></td>
                    <td><?php if(2 == $vo['type']): ?>
                            <span style="color:green;">超级用户</span>
                        <?php else: ?>
                           <span class="status" ><?php if(\think\Config::get('normal_status') == $vo['status']): ?>启用</span><?php else: ?><span>禁用</span><?php endif; endif; ?>
                    </td>
                    <td><?php echo $vo['mobile']; ?></td>
                    <td>
                        <?php if($vo['create_time'] != '0000-00-00 00:00:00'): ?>
                            <?php echo date("Y-m-d H:s",$vo['create_time']); endif; ?>
                    </td>
                    <td>
                        <?php 
                            if(showHandle('privilege/Admin/editPassword')){
                         ?>
                            <button class="layui-btn layui-btn-small changpassword" data-id="<?php echo $vo['id']; ?>" title='修改密码'>
                                <i class="layui-icon">&#xe642;</i><span style='font-size:15px;'>修改密码</span>
                            </button>
                        <?php 
                            }
                            if(showHandle('privilege/Admin/changeStatus')){
                         if(\think\Config::get('normal_status') == $vo['status']): ?>
                                <button class="layui-btn layui-btn-small qiyong" data-id="<?php echo $vo['id']; ?>" data-status="<?php echo $vo['status']; ?>" style='font-size:15px;'>
                                    <i class="layui-icon">&#xe640;</i>禁用
                                </button>
                            <?php else: ?>
                                <button class="layui-btn layui-btn-small layui-btn-danger qiyong" data-id="<?php echo $vo['id']; ?>" data-status="<?php echo $vo['status']; ?>" style='font-size:15px;'>
                                    <i class="layui-icon">&#xe640;</i>启用
                                </button>
                            <?php endif; 
                            }
                            if(showHandle('privilege/Admin/editorAdmin')){
                         ?>
                            <button class="layui-btn layui-btn-small editorAdmin" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>
                                <i class="layui-icon">&#xe642;</i>编辑
                            </button>
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
            var $ = layui.jquery, layer = layui.layer;
            //弹出添加管理人员模态框
            $('.addPerson').click(function() {
                layer.open({
                    closeBtn: 2,
                    type: 1,
                    area: '500px',
                    title: '添加管理人员',
                    content: $('#motai'),
                });
            });
            //提交添加管理人员信息
            $('.addpersonsubmit').click(function() {
                var username = $("#data-form input[name='username']").val();
                var user = $("#data-form input[name='user']").val();
                var pwd = $("#data-form input[name='pwd']").val();
                var phone = $("#data-form input[name='phone']").val();

                if (username.length < 1) {
                    layer.msg('请填写真实姓名');
                    return false;
                }
                if (user.length < 1) {
                    layer.msg('请填登陆账号');
                    return false;
                }
                if (pwd.length < 1) {
                    layer.msg('请填用户密码');
                    return false;
                }
                if (phone.length < 1) {
                    layer.msg('请填联系方式');
                    return false;
                }
                var From = $('#data-form').serialize();
                layer.open({
                    type:3,
                    success: function(layero, index){ 
                        $.ajax({
                            url: "<?php echo url('addPerson'); ?>",
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
            //修改密码
            $('.changpassword').on('click', function() {
                var id = $(this).attr('data-id');
                layer.prompt({
                    formType: 3,
                    value: '',
                    title: '请输入新的密码',
                    area: ['100px', '100px']
                }, function(value, index, elem) {
                    //将value传入changepassword
                    $.ajax({
                        url: '<?php echo url("privilege/Admin/editPassword"); ?>',
                        data: {'id': id,'pwd': value},
                        type: 'post',
                        success: function(d) {
                            var result = eval("(" + d + ")");
                            if (result.flag == 1) {
                                layer.msg(result.msg,{icon:1,time:2000},function(){
                                    window.location.reload();//刷新当前页面.
                                });
                            } else{
                                layer.msg(result.msg);
                            }
                        }
                    });
                    layer.close(index);
                });
            });

            //启用和禁用方法
            $('.qiyong').on('click', function() {
                var status = $(this).attr('data-status');
                var id = $(this).attr('data-id');
                layer.open({
                    type:3,
                    success: function(layero, index){  
                        $.ajax({
                            url: "<?php echo url('privilege/Admin/changeStatus'); ?>",
                            type: 'post',
                            data: {'status': status, 'id': id},
                            success: function(d) {
                                var result = eval("(" + d + ")");
                                layer.closeAll(); //疯狂模式，关闭所有层
                                if (result.flag == 1) {
                                    layer.msg(result.msg,{icon:1,time:2000},function(){
                                        window.location.reload();//刷新当前页面.
                                    });
                                }else{
                                    layer.msg(result.msg);
                                }
                            }
                        });
                    }
                });
            });

            //编辑人员信息
            $('.editorAdmin').click(function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: "<?php echo url('editorAdmin'); ?>",
                    type: 'post',
                    data: {'id':id,'action':'get'},
                    success: function(d) {
                        var result = eval("(" + d + ")");
                        if (result.flag == 1) {
                            var data = result.data;
                            $('#editdata-form input[name="user"]').val(data.nick_name);
                            $('#editdata-form input[name="username"]').val(data.user_name);
                            $('#editdata-form input[name="phone"]').val(data.mobile);
                            $('#editdata-form input[name="id"]').val(data.id);
                        }
                        layer.open({
                            closeBtn: 2,
                            type: 1,
                            area: '600px',
                            title: '编辑管理员信息',
                            content: $('#editmotai')
                        });
                    }
                });
            });

            //提交编辑人员信息表单
            $('.editsubmit').click(function() {
                var user = $("#editdata-form input[name='user']").val();
                var username = $("#editdata-form input[name='username']").val();
                var phone = $("#editdata-form input[name='phone']").val();
                if (user.length < 1) {
                    layer.msg('请填登陆账号');
                    return false;
                }
                if (username.length < 1) {
                    layer.msg('请填真实姓名');
                    return false;
                }
                if (phone.length < 1) {
                    layer.msg('请填写用户手机号');
                    return false;
                }
                var From = $('#editdata-form').serialize();
                layer.open({
                    type:3,
                    success: function(layero, index){  
                        $.ajax({
                            url: "<?php echo url('editorAdmin'); ?>",
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
        });
    });
</script>

</body>
</html>
