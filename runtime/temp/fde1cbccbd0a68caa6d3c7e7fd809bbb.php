<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:81:"/var/www/us4yo-miraila-admin/public/../admin/guessing/view/guessing/addGuess.html";i:1525941610;s:65:"/var/www/us4yo-miraila-admin/public/../admin/extra/view/main.html";i:1524451346;}*/ ?>
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
            <a href="javascript:;">竞猜</a>
            <a href="<?php echo url('Guessing/lists'); ?>">竞猜列表</a>
            <a><cite>添加竞猜</cite></a>
        </span>
    </div>
    <form class="layui-form layui-form-pane1" method="post" action="<?php echo url('addGuess'); ?>" style="width:700px;" enctype="multipart/form-data">
        <table class="layui-table" style="margin:16px 0px 0px 180px">
            <tbody>
                <tr>
                    <td><span style="color:red">*</span>竞猜类型:</td>
                    <td>
                        <select name="cate_id" lay-verify="required">
                            <?php if(is_array($cateList) || $cateList instanceof \think\Collection || $cateList instanceof \think\Paginator): $i = 0; $__LIST__ = $cateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $vo['id']; ?>"><?php echo str_repeat('&nbsp;&nbsp;&nbsp;',$vo['level']); ?><?php echo $vo['name']; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><span style="color:red">*</span>竞猜标题:</td>
                    <td>
                        <textarea rows="3" cols="70" name="title" lay-verify="required"></textarea>
                    </td>
                </tr>
                <tr>
                    <td><span style="color:red">*</span>选&nbsp &nbsp &nbsp项A:</td>
                    <td>
                        <input type="text"  name="option_one" autocomplete="off" placeholder="选项A"  lay-verify="required" class="layui-input">
                    </td>
                </tr>
                <tr>
                    <td><span style="color:red">*</span>选&nbsp &nbsp &nbsp项B:</td>
                    <td>
                        <input type="text"  name="option_two" autocomplete="off" placeholder="选项B"  lay-verify="required" class="layui-input">
                    </td>
                </tr>
                <tr>
                    <td><span style="color:red">*</span>截止时间:</td>
                    <td>
                        <input type="text" name="close_time" autocomplete="off" placeholder="年-月-日 时:分:秒" lay-verify="required" onclick="layui.laydate({elem: this, istime: true,format: 'YYYY-MM-DD hh:mm:ss'})" class="layui-input">
                    </td>
                </tr>
                <tr>
                    <td><span style="color:red">*</span>下注单位:</td>
                    <td>
                        <input type="text"  name="size" autocomplete="off"  placeholder="设置下注单位"  lay-verify="required" class="layui-input">
                    </td>
                </tr>
                <tr>
                    <td><span style="color:red">*</span>平台比例:</td>
                    <td>
                        <input type="text"  name="seller_proportion" autocomplete="off"  placeholder="平台抽成比例(如:0.12相当于12%) "  lay-verify="required" class="layui-input">
                    </td>
                </tr>
                <tr>
                    <td>最大金额:</td>
                    <td>
                        <input type="text"  name="max" autocomplete="off"  placeholder="下注最大金额" class="layui-input">
                    </td>
                </tr>
                <!--<tr>
                    <td>注&nbsp &nbsp &nbsp &nbsp释:</td>
                    <td>
                        <textarea rows="2" cols="60" name="remark"></textarea>
                    </td>
                </tr>-->
                <tr>
                    <td>排&nbsp &nbsp &nbsp &nbsp序:</td>
                    <td>
                        <input type="text"  name="sort" autocomplete="off" placeholder="排序" value='0' class="layui-input">
                    </td>
                </tr>
                <tr>
                    <td colspan='2' style="text-align: center;">  
                        <button class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
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
            layui.use(['form', 'jquery', 'laypage','laydate'], function() {
                var $ = layui.jquery, layer = layui.layer,form = layui.form();
            });
        });
    </script>

</body>
</html>
