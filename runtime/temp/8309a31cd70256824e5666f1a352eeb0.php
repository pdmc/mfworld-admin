<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:79:"/var/www/us4yo-miraila-admin/public/../admin/index/view/index/personaldata.html";i:1524129084;s:65:"/var/www/us4yo-miraila-admin/public/../admin/extra/view/main.html";i:1524451346;}*/ ?>
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

    <!--修改密码start-->
    <div id='editPassword' style="display:none">
        <form id='editForm' class="layui-form" method="post" enctype="multipart/form-data">
            <table class="layui-table">
                <tbody>
                    <tr>
                        <td>
                            原密码
                        </td>
                        <td>
                            <input type="text"  name="oldPassword" required  lay-verify="required" placeholder="原密码"  autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            新密码
                        </td>
                        <td>
                            <input type="text"  name="newPassword" required  lay-verify="required" placeholder="新密码" autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' style="text-align: center;">  
                          <button class="layui-btn editSubmit" lay-submit  type="button">立即提交</button>
                          <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <!--修改密码end-->

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
            <a href="javascript:;">首页</a>
            <a><cite>个人中心</cite></a>
        </span>
    </div>
    <div style="float:right;">
        <?php 
            if(showHandle('index/Index/editpwd')){
         ?>
            <span class="layui-btn editpwd"><i class="layui-icon">&#xe642;</i>修改密码</span>
        <?php 
            }
         ?>
    </div>
    <table class="layui-table" style="margin-top:50px;">
        <colgroup>
            <col width="50">
            <col width="150">
        </colgroup>
        <tbody>
            <tr>
                <td>姓名:</td>
                <td><?php echo $data['user_name']; ?></td>
            </tr>
            <tr>
                <td>用户名:</td>
                <td><?php echo $data['nick_name']; ?></td>
            </tr>
            <tr>
                <td>联系方式:</td>
                <td><?php echo $data['mobile']; ?></td>
            </tr>
            <tr>
                <td>管理员:</td>
                <td>
                    <input type="radio" disabled="" <?php if($data['type'] == '2'): ?> checked=""<?php endif; ?>/>超级&nbsp &nbsp
                    <input type="radio" disabled="" <?php if($data['type'] == '1'): ?> checked=""<?php endif; ?> />普通
                </td>
            </tr>
            <tr>
                <td>开户时间:</td>
                <td><?php echo date("Y年m月d日 H时i分s秒",$data['create_time']); ?></td>
            </tr>
        </tbody>
    </table>

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
            var $ = layui.jquery,layer = layui.layer;
            //修改密码
            $('.editpwd').click(function(){
                layer.open({
                    closeBtn: 2,
                    type: 1, 
                    area: '500px',
                    title:'修改密码',
                    content: $('#editPassword')
                });
            });
            $('.editSubmit').click(function(){
                layer.open({
                    type:3,
                    success: function(layero, index){ 
                        var oldpw = $('#editForm input[name="oldPassword"]').val();
                        var newpw = $('#editForm input[name="newPassword"]').val();
                        $.ajax({
                            url:"<?php echo url('editpwd'); ?>",
                            type:'post',
                            data:{'oldpw':oldpw,'newpw':newpw},
                            success:function(d){
                                var result = eval("(" + d + ")");
                                if (result.flag == 1) {
                                    layer.msg(result.msg,{icon:1,time:2000},function(){
                                        layer.closeAll(); //疯狂模式，关闭所有层
                                        window.location.reload();//刷新当前页面.
                                    });
                                }else{
                                    layer.msg(result.msg,{icon:1,time:2000},function(){
                                        layer.closeAll('loading'); //关闭加载层
                                    });
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
