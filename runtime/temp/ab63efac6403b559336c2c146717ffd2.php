<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"/var/www/us4yo-miraila-admin/public/../admin/user/view/user/lists.html";i:1525862700;s:65:"/var/www/us4yo-miraila-admin/public/../admin/extra/view/main.html";i:1524451346;}*/ ?>
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

<!--查看更多start-->
    <div id='motai' style="display:none">
        <form id='data-form' class="layui-form" method="post" enctype="multipart/form-data">
            <table class="layui-table">
                <tbody>
                    <tr>
                        <td width="18%">用户姓名：</td>
                        <td name="user_name"></td>
                        <td width="18%">用户昵称：</td>
                        <td name="user_nick"></td>
                    </tr>
                    <tr>
                        <td>手机号：</td>
                        <td name="user_mobile"></td>
                        <td>能量：</td>
                        <td name="energy"></td>
                    </tr>
                    <tr>
                        <td>彩钻：</td>
                        <td name="color"></td>
                        <td>答题得分：</td>
                        <td name="total_score"></td>
                    </tr>
                    <tr>
                        <td>状态：</td>
                        <td name="user_status"></td>
                        <td>创建时间：</td>
                        <td name="create_time"></td>
                    </tr>
                    <tr>
                        <td colspan='4' style="text-align: center;">  
                        </td>
                    </tr>
                   
                </tbody>
            </table>
        </form>
    </div>
<!--查看更多end-->

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
            <a href="javascript:;">用户</a>
            <a><cite>用户列表</cite></a>
        </span>
    </div>
    <form class="layui-form" action="<?php echo url('User/lists'); ?>" method="get" style="margin-top:10px;float:left;margin-bottom: -16px;">
        <div class="layui-form-item" style="margin-left:5px;">
            <div class="layui-inline">
                <select name="user_status" lay-verify="required">
                    <option value="0">--用户状态--</option>
                    <option value="1" <?php if(\think\Request::instance()->get('user_status') == '1'): ?>selected<?php endif; ?>>启用</option>
                    <option value="-1" <?php if(\think\Request::instance()->get('user_status') == '-1'): ?>selected<?php endif; ?>>禁用</option>
                </select>
            </div>
            <div class="layui-inline">
                <input type="text"  name="user_name" placeholder="昵称或姓名" value="<?php echo \think\Request::instance()->get('user_name'); ?>" class="layui-input">
            </div>
            <div class="layui-inline">
                <button class="layui-btn">查找</button>
            </div>
        </div>
    </form>
    <table lay-even class="layui-table" style="margin-top:-16px;">
        <thead>
            <tr> 
                <th style='width:5%;'>ID</th>
                <th style='width:10%;'>昵称</th>
                <th style='width:10%;'>姓名</th>
                <th style='width:10%;'>手机号</th>
                <th style='width:5%;'>性别</th>
                <th style='width:10%;'>邀请码</th>
                <th style='width:10%;'>状态</th>
                <th style='width:15%;'>创建时间</th>
                <th style='width:15%;'>操作</th>
            </tr> 
        </thead>
        <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $vo['user_id']; ?></td>
                    <td><?php echo $vo['user_nick']; ?></td>
                    <td><?php echo $vo['user_name']; ?></td>
                    <td><?php echo $vo['user_mobile']; ?></td>
                    <td>
                        <?php if(1 == $vo['user_sex']): ?>
                            <span>男</span>
                        <?php elseif(2 == $vo['user_sex']): ?>
                            <span>女</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $vo['invite_code']; ?></td>
                    <td>
                        <?php if(1 == $vo['user_status']): ?>
                            <span style="color:green;">启用</span>
                        <?php elseif(-1 == $vo['user_status']): ?>
                            <span >禁用</span>
                        <?php else: ?>
                            <span style="color:red;">联系开发人员</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($vo['create_time'] != '0000-00-00 00:00:00'): ?>
                            <?php echo date("Y-m-d H:i:s",$vo['create_time']); endif; ?>
                    </td>
                    <td>
                        <?php 
                            if(showHandle('user/User/viewmore')){
                         ?>
                            <button class="layui-btn layui-btn-small view" data-id=<?php echo $vo['user_id']; ?> style='font-size:15px;'>查看更多</button>
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
            //查看更多
            $('.view').click(function() {
                var id = $(this).attr('data-id');
                if (id.length<1){ return false;}
                $.ajax({
                    url: "<?php echo url('viewmore'); ?>",
                    type: 'post',
                    data: {'id':id},
                    success: function(d) {
                        var result = eval("(" + d + ")");
                        if (result.code == 200) {
                            var data = result.data;
                            $('#data-form tr td[name="user_name"]').empty().html(data.user_name);
                            $('#data-form tr td[name="user_nick"]').empty().html(data.user_nick);
                            $('#data-form tr td[name="user_mobile"]').empty().html(data.user_mobile);
                            $('#data-form tr td[name="energy"]').empty().html(data.energy);
                            $('#data-form tr td[name="color"]').empty().html(data.color);
                            $('#data-form tr td[name="total_score"]').empty().html(data.total_score);
                            $('#data-form tr td[name="user_status"]').empty().html(data.user_status);
                            $('#data-form tr td[name="create_time"]').empty().html(data.create_time);
                            form.render();
                            layer.open({
                                closeBtn: 2,
                                type: 1,
                                area: '600px',
                                title: '查看更多',
                                content: $('#motai')
                            });
                        }else{
                            layer.msg(result.msg);
                            window.location.reload();//刷新当前页面.
                        }
                    }
                });
            });
        });
    });
</script>

</body>
</html>
