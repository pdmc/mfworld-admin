<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:72:"/var/www/us4yo-miraila-admin/public/../admin/prop/view/prop/addProp.html";i:1528861490;s:65:"/var/www/us4yo-miraila-admin/public/../admin/extra/view/main.html";i:1524451346;}*/ ?>
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

<!--添加单品start-->
    <div id='motai' style="display:none">
        <form id='data-form' class="layui-form" method="post">
            <table class="layui-table">
                <tbody name='tbody'>
                    
                </tbody>
                <tr>
                    <td style="text-align:center;">  
                        <button class="layui-btn addSubmit" lay-submit lay-filter="formDemo" type="button">确定</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
<!--添加单品end-->

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
            <a href="javascript:;">道具</a>
            <a href="<?php echo url('Prop/lists'); ?>">道具列表</a>
            <a><cite>添加道具</cite></a>
        </span>
    </div>
    <form class="layui-form layui-form-pane1" method="post" action="<?php echo url('prop/Prop/addProp'); ?>" style="width:600px;"  enctype="multipart/form-data">
        <table class="layui-table" style="margin:16px 0px 0px 160px">
            <tbody>
                <tr>
                    <td><span style="color:red">*</span>道具类型:</td>
                    <td>
                        <select name="prop_type" lay-verify="required" lay-filter="prop_type">
                            <?php if(is_array(\think\Config::get('prop_type')) || \think\Config::get('prop_type') instanceof \think\Collection || \think\Config::get('prop_type') instanceof \think\Paginator): $i = 0; $__LIST__ = \think\Config::get('prop_type');if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <option value="<?php echo $key; ?>"><?php echo $vo; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                </tr>
                <tr class='mult' style='display:none;'><td></td><td class='incon'></td></tr>
                <!--<tr>
                    <td><span style="color:red">*</span>道具图片:</td>
                    <td>
                        <div class="layui-box layui-upload-button layui-input-inline">
                            <input type="file" name="image" lay-type="images" class="layui-upload-file"  lay-verify="required" required />
                            <span class="layui-upload-icon"><i class="layui-icon"> </i>上传图片</span>
                        </div>
                    </td>
                </tr> -->
                <tr>
                    <td><span style="color:red">*</span>道具图片:</td>
                    <td>
                        <div class="layui-box  layui-input-inline">
                            <input type="file" name="image"  lay-type="images" lay-verify="required" required />
                        </div>
                    </td>
                </tr> 
                <tr>
                    <td><span style="color:red">*</span>道具名称:</td>
                    <td>
                        <input type="text"  name="name" autocomplete="off" placeholder="道具名称"  lay-verify="required" class="layui-input">
                    </td>
                </tr>
                <tr>
                    <td><span style="color:red">*</span>道具价格:</td>
                    <td>
                        <input type="text"  name="price" autocomplete="off" placeholder="道具价格"  lay-verify="required" class="layui-input">
                    </td>
                </tr>
                <tr>
                    <td><span style="color:red">*</span>道具说明:</td>
                    <td>
                        <textarea rows="3" cols="60" name="describe"  lay-verify="required"></textarea>
                    </td>
                </tr>
                <tr>
                    <td><span style="color:red">*</span>道具数值:</td>
                    <td>
                        <input type="text"  name="propnum" autocomplete="off" placeholder="道具数量" lay-verify="required" class="layui-input">
                    </td>
                </tr>
                <tr class='single'>
                    <td><span style="color:red">*</span>使用方式:</td>
                    <td>
                        <select name="use_type" lay-verify="required">
                            <option value="1">持续使用</option>
                            <option value="2">立即使用</option>
                        </select>
                    </td>
                </tr>
                <tr class='single'>
                    <td>持续时间:</td>
                    <td>
                        <input type="text"  name="keep_time" autocomplete="off"  placeholder="单位分钟" class="layui-input">
                    </td>
                </tr>
                <tr class='single'>
                    <td>冷却时间:</td>
                    <td>
                        <input type="text"  name="cool_time" autocomplete="off"  placeholder="单位分钟" class="layui-input">
                    </td>
                </tr>
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
        layui.use(['form', 'jquery', 'laypage'], function() {
            var $ = layui.jquery, layer = layui.layer,form = layui.form();
            //改变道具类型
            form.on('select(prop_type)', function(data) {
                var type = data['value'];
                if(type == '1'){
                    $('.mult').hide();
                    $('.single').show();
                }
                if(type == '2'){
                    layer.open({
                        type:3,
                        success: function(layero, index){  
                            $.ajax({
                                url: "<?php echo url('selProp'); ?>",
                                type: 'POST',
                                success: function(d) {
                                    var result = eval("(" + d + ")");
                                    if (result.flag == 1) {
                                        var data = result.data;
                                        var string = '',i=1;
                                        $.each(data, function(key, val) {
                                            string += '<input type="checkbox"  name="like' +key+ ']" value="' +key+ '"  title="'+val+'">';
                                            if(i%5 == 0){
                                                string += '<br/><br/>';
                                            }
                                            ++i;
                                        });
                                        layer.open({
                                            closeBtn: 2,
                                            type: 1,
                                            area: '650px',
                                            title: '选择单品',
                                            content: $('#motai')
                                        });
                                        if(string){
                                            $("#data-form tbody[name='tbody']").empty().append(string);
                                        }
                                        form.render();
                                        layer.closeAll('loading'); //关闭加载层
                                    }else{
                                        layer.closeAll('loading'); //关闭加载层
                                        layer.msg(result.msg);
                                    }
                                }
                            });
                        }
                    });  
                }
            });
            
            $('.addSubmit').click(function(){
                form.render();
                var string = '';
                $("#data-form tbody input").each(function(i){
                    if($(this).is(':checked')){
                        string +="<input type='text' class='layui-input' style='width:20%;float:left;' disabled value='"+$(this).attr('title')+"'><input type='hidden' name='sid[]' value='"+$(this).attr('value')+"'><input type='text' name='snum[]' value='1' style='width:20%;float:left;' class='layui-input'><br/><br/>";
                    }
                });
                if(string){
                    $(".incon").empty().append(string);
                }
                $('.single').hide();
                $('.mult').show();
                form.render();
                layer.closeAll();//关闭加载层
            });
            
        });
    });
</script>

</body>
</html>
