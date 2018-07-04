<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:72:"/var/www/us4yo-miraila-admin/public/../admin/user/view/user/anround.html";i:1525862452;s:65:"/var/www/us4yo-miraila-admin/public/../admin/extra/view/main.html";i:1524451346;}*/ ?>
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
            <a><cite>答题列表</cite></a>
        </span>
    </div>
    <form class="layui-form" action="<?php echo url('User/anround'); ?>" method="get" style="margin-top:10px;float:left;margin-bottom: -16px;">
        <div class="layui-form-item" style="margin-left:5px;">
            <div class="layui-inline">
                <input type="text"  name="user_nick" placeholder="用户昵称" value="<?php echo \think\Request::instance()->get('user_nick'); ?>" class="layui-input">
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
                <th style='width:15%;'>用户昵称</th>
                <th style='width:10%;'>总题数</th>
                <th style='width:10%;'>总得分</th>
                <th style='width:10%;'>消耗体力</th>
                <th style='width:10%;'>奖品</th>
                <th style='width:10%;'>结果</th>
                <th style='width:15%;'>创建时间</th>
                <th style='width:15%;'>操作</th>
            </tr> 
        </thead>
        <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $vo['id']; ?></td>
                    <td><?php echo $vo['user_nick']; ?></td>
                    <td><?php echo $vo['total_num']; ?></td>
                    <td><?php echo $vo['total_score']; ?></td>
                    <td><?php echo $vo['consume_num']; ?></td>
                    <td><?php echo $vo['get_reward']; ?></td>
                    <td>
                        <?php if(1 == $vo['result']): ?>
                            <span>成功</span>
                        <?php elseif(2 == $vo['result']): ?>
                            <span>失败</span>
                        <?php else: ?>
                            <span>联系开发人员</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($vo['create_time'] != '0000-00-00 00:00:00'): ?>
                            <?php echo date("Y-m-d H:i:s",$vo['create_time']); endif; ?>
                    </td>
                    <td>
                        <?php 
                            if(showHandle('user/User/anlog')){
                         ?>
                            <button class="layui-btn layui-btn-small view" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>开发进行中...</button>
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
                    url: "<?php echo url('anlog'); ?>",
                    type: 'post',
                    data: {'id':id},
                    success: function(d) {
                        var result = eval("(" + d + ")");
                        if (result.code == 200) {
                            var data = result.data;
                            
                            $('#data-form tr td[name="user_name"]').empty().html(data.user_name);
                            
                            
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
