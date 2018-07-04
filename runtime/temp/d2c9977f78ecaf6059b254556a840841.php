<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:77:"/var/www/us4yo-miraila-admin/public/../admin/problem/view/problem/config.html";i:1529663602;s:65:"/var/www/us4yo-miraila-admin/public/../admin/extra/view/main.html";i:1524451346;}*/ ?>
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
            <a href="javascript:;">题库</a>
            <a><cite>答题配置</cite></a>
        </span>
    </div>
    <form id='data-form' style="width:600px;">
        <table class="layui-table" style="margin:16px 0px 0px 160px">
            <tbody>
                <tr>
                    <td>答题消耗体力:</td>
                    <td>
                        <input type="text"  name="pro_tili" autocomplete="off"  lay-verify=”required|number” value="<?php echo $data['pro_tili']; ?>" class="layui-input">
                    </td>
                </tr>
                <!--<tr>
                    <td>每轮答题数量:</td>
                    <td>
                        <input type="text"  name="pro_num" autocomplete="off"   value="{$$$$$data.pro_num}" class="layui-input">
                    </td>
                </tr> -->
                <tr>
                    <td>本轮通过分数:</td>
                    <td>
                        <input type="text"  name="pro_error" autocomplete="off" value="<?php echo $data['pro_error']; ?>" class="layui-input">
                    </td>
                </tr>
                <!--<tr>
                    <td>每题答题时间(秒):</td>
                    <td>
                        <input type="text"  name="pro_time" autocomplete="off"  value="{$$$data.pro_time}" class="layui-input">
                    </td>
                </tr>-->
                <tr>
                    <td>每轮胜率获得能量:</td>
                    <td>
                        <input type="text" name="pro_energy" autocomplete="off" value="<?php echo $data['pro_energy']; ?>" class="layui-input">
                    </td>
                </tr>
                <tr>
                    <td colspan='2' style="text-align: center;">  
                        <button class="layui-btn editsubmit" lay-submit lay-filter="formDemo" type="button">更新</button>
                        <!--<button type="reset" class="layui-btn layui-btn-primary">重置</button>-->
                    </td>
                </tr>
            </tbody>
        </table>
    </form>

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
            //提交配置信息
            $('.editsubmit').click(function() {
                var pro_tili   = $('#data-form input[name="pro_tili"]').val();
                var pro_num    = $('#data-form input[name="pro_num"]').val();
                var pro_error  = $('#data-form input[name="pro_error"]').val();
                //var pro_time   = $('#data-form input[name="pro_time"]').val();
                var pro_energy = $('#data-form input[name="pro_energy"]').val();
                
                if (pro_tili.length < 1) {
                    layer.msg('请填写答题消耗体力值');
                    return false;
                }
                if (pro_num.length < 1) {
                    layer.msg('请填写每轮答题数量!');
                    return false;
                }
                if (pro_error.length < 1) {
                    layer.msg('请填写允许答错数量!');
                    return false;
                }
                /*if (pro_time.length < 1) {
                    layer.msg('请填写每题答题时间!');
                    return false;
                }*/
                if (pro_energy.length < 1) {
                    layer.msg('请填写每轮胜率获得能量');
                    return false;
                }
                var From = $('#data-form').serialize();
                layer.open({
                    type:3,
                    success: function(layero, index){  
                        $.ajax({
                            url: "<?php echo url('config'); ?>",
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
