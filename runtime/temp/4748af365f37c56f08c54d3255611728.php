<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:70:"/var/www/us4yo-miraila-admin/public/../admin/prop/view/prop/lists.html";i:1525941200;s:65:"/var/www/us4yo-miraila-admin/public/../admin/extra/view/main.html";i:1524451346;}*/ ?>
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

<!--编辑道具start-->
    <div id='editmotai' style="display:none">
        <form id='editdata-form' class="layui-form" method="post" enctype="multipart/form-data">
            <table class="layui-table">
                <tbody>
                    <tr>
                        <td>道具类型:</td>
                        <td>单品
                            <!--<select name="prop_type" lay-verify="required" lay-filter="prop_type">
                                <?php if(is_array(\think\Config::get('prop_type')) || \think\Config::get('prop_type') instanceof \think\Collection || \think\Config::get('prop_type') instanceof \think\Paginator): $i = 0; $__LIST__ = \think\Config::get('prop_type');if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $key; ?>"><?php echo $vo; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>-->
                        </td>
                    </tr>
                    <tr>
                        <td>原图片:</td>
                        <td>
                            <span class="layui-btn layui-btn-small zoomIn" name="oldimg" >查看</span>
                        </td>
                    </tr>
                    <tr>
                        <td><span style="color:red">*</span>道具图片:</td>
                        <td>
                            <div class="layui-box layui-upload-button layui-input-inline">
                                <input type="file" name="image" lay-type="images" class="layui-upload-file"/>
                                <span class="layui-upload-icon"><i class="layui-icon"> </i>上传图片</span>
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
                            <input type='hidden' name="id">
                            <input type='hidden' name="action" value='post'>
                            <input type='hidden' name="prop_type" value='1'>
                            <button class="layui-btn editsubmit" lay-submit lay-filter="formDemo" type="button">立即提交</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

    <div id='editmul' style="display:none">
        <form id='editmul-form' class="layui-form" method="post" enctype="multipart/form-data">
            <table class="layui-table">
                <tbody>
                    <tr>
                        <td width="18%">道具套餐:</td>
                        <td name="mul"></td>
                    </tr>
                    <tr>
                        <td>原图片:</td>
                        <td>
                            <span class="layui-btn layui-btn-small zoomIn" name="oldimg" >查看</span>
                        </td>
                    </tr>
                    <tr>
                        <td><span style="color:red">*</span>道具图片:</td>
                        <td>
                            <div class="layui-box layui-upload-button layui-input-inline">
                                <input type="file" name="image" lay-type="images" class="layui-upload-file"/>
                                <span class="layui-upload-icon"><i class="layui-icon"> </i>上传图片</span>
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
                    <tr>
                        <td>排&nbsp &nbsp &nbsp &nbsp序:</td>
                        <td>
                            <input type="text"  name="sort" autocomplete="off" placeholder="排序" value='0' class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' style="text-align: center;">  
                            <input type='hidden' name="id">
                            <input type='hidden' name="action" value='post'>
                            <input type='hidden' name="prop_type" value='2'>
                            <button class="layui-btn editmulsubmit" lay-submit lay-filter="formDemo" type="button">立即提交</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

<!--编辑道具end-->

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
            <a><cite>道具列表</cite></a>
        </span>
    </div>
    <div style="float:right;">
        <?php 
            if(showHandle('prop/Prop/addProp')){
         ?>
            <a href="<?php echo url('prop/Prop/addProp'); ?>"><span class="layui-btn" style="margin-bottom:5px;">添加道具</span></a>
        <?php 
            }
         ?>
    </div>
    <form class="layui-form" action="<?php echo url('Prop/lists'); ?>" method="get" style="margin-top:10px;float:left;margin-bottom: -16px;">
        <div class="layui-form-item" style="margin-left:5px;">
            <div class="layui-inline">
                <select name="prop_type" lay-verify="required">
                    <option value="0">--请选择类型--</option>
                    <?php if(is_array(\think\Config::get('prop_type')) || \think\Config::get('prop_type') instanceof \think\Collection || \think\Config::get('prop_type') instanceof \think\Paginator): $i = 0; $__LIST__ = \think\Config::get('prop_type');if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $key; ?>" <?php if(\think\Request::instance()->get('prop_type') == $key): ?>selected<?php endif; ?> ><?php echo $vo; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <div class="layui-inline">
                <input type="text"  name="name" placeholder="道具名称关键字" value="<?php echo \think\Request::instance()->get('name'); ?>" class="layui-input">
            </div>
            <div class="layui-inline">
                <button class="layui-btn">查找</button>
            </div>
        </div>
    </form>
    <table lay-even class="layui-table" style="margin-top:-16px;">
        <thead>
            <tr> 
                <th style='width:3%;'>ID</th>
                <th style='width:10%;'>道具图片</th>
                <th style='width:10%;'>道具名称</th>
                <th style='width:5%;'>类型</th>
                <th style='width:5%;'>数值</th>
                <th style='width:10%;'>持续时间</th>
                <th style='width:10%;'>冷却时间</th>
                <th style='width:5%;'>价格</th>
                <th style='width:5%;'>状态</th>
                <th style='width:5%;'>排序</th>
                <th style='width:10%;'>添加时间</th>
                <th style='width:22%;'>操作</th>
            </tr> 
        </thead>
        <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $vo['id']; ?></td>
                    <td>
                        <img src="<?php echo $vo['img']; ?>" width="150px"  class="zoomIn" >
                    </td>
                    <td><?php echo $vo['name']; ?></td>
                    <td>
                        <?php if(1 == $vo['prop_type']): ?>
                            <span>单品</span>
                        <?php else: ?>
                            <span>套餐</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $vo['propnum']; ?></td>
                    <td>
                        <?php if($vo['keep_time'] != '0'): ?><?php echo $vo['keep_time']; ?>(分钟)<?php endif; ?>
                    </td>
                    <td>
                        <?php if($vo['cool_time'] != '0'): ?><?php echo $vo['cool_time']; ?>(分钟)<?php endif; ?>
                    </td>
                    <td><?php echo $vo['price']; ?></td>
                    <td>
                        <?php if(1 == $vo['status']): ?>
                            <span style="color:green;">启用</span>
                        <?php else: ?>
                            <span >禁用</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $vo['sort']; ?></td>
                    <td><?php echo date("Y-m-d H:i:s",$vo['creade_time']); ?></td>
                    <td>
                        <?php 
                            if(showHandle('prop/Prop/editProp')){
                         ?>
                            <button class="layui-btn layui-btn-small editProp" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>编辑</button>
                        <?php 
                            }
                            if(showHandle('prop/Prop/onOffProp')){
                         if($vo['status'] != '1'): ?>
                                <button class="layui-btn layui-btn-small onOffProp" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>开启</button>
                            <?php else: ?>    
                                <button class="layui-btn layui-btn-small onOffProp" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>关闭</button>
                            <?php endif; 
                            }
                            if(showHandle('prop/Prop/delProp')){
                         ?>
                            <button class="layui-btn layui-btn-small delProp" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>删除</button>
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
            //放大图片
            $('.zoomIn').click(function(){
                var src = $(this).attr('src');
                layer.open({
                    closeBtn: 2,
                    type: 1, 
                    area: ['225','200px'],
                    title:'查看图片',
                    content: "<img src="+src+" width='100%' height='100%'>"
                });
            });
            
            //编辑道具
            $('.editProp').click(function() {
                var id = $(this).attr('data-id');
                if (id.length<1){ return false;}
                //layer.open({
                    //type:3,
                    //success: function(layero, index){
                        $.ajax({
                            url: "<?php echo url('editProp'); ?>",
                            type: 'post',
                            data: {'id':id,'action':'get'},
                            success: function(d) {
                                var result = eval("(" + d + ")");
                                if (result.flag == 1) {
                                    var data = result.data;
                                    if(data.prop_type == 1){
                                        //$('#editdata-form select[name="prop_type"]').find("option[value='"+data.prop_type+"']").attr("selected",true);
                                        $('#editdata-form span[name="oldimg"]').attr('src',data.img);
                                        $('#editdata-form input[name="name"]').val(data.name);
                                        $('#editdata-form input[name="price"]').val(data.price);
                                        $('#editdata-form textarea[name="describe"]').val(data.describe);
                                        $('#editdata-form input[name="propnum"]').val(data.propnum);
                                        $('#editdata-form select[name="use_type"]').find("option[value='"+data.use_type+"']").attr("selected",true);
                                        $('#editdata-form input[name="keep_time"]').val(data.keep_time); 
                                        $('#editdata-form input[name="cool_time"]').val(data.cool_time);
                                        $('#editdata-form input[name="sort"]').val(data.sort);
                                        $('#editdata-form input[name="id"]').val(data.id);
                                        form.render();
                                        layer.open({
                                            closeBtn: 2,
                                            type: 1,
                                            area: '600px',
                                            title: '编辑道具',
                                            content: $('#editmotai')
                                        }); 
                                    }else{
                                        var string = '',i = 1;
                                        $.each(data.prop_mul, function(key,val) {
                                            string +="<input type='text' class='layui-input' style='width:18%;float:left;' disabled value='"+val.name+"'><input type='hidden' name='sid[]' value='"+val.id+"'><input type='text' name='snum[]' value='"+val.num+"' style='width:10%;float:left;margin-right:3%' class='layui-input'>";
                                            if(i%3 == 0){
                                                string += '<br/><br/>';
                                            }
                                            ++i;
                                        });
                                        $('#editmul-form td[name="mul"]').empty().append(string);
                                        $('#editmul-form span[name="oldimg"]').attr('src',data.img);
                                        $('#editmul-form input[name="name"]').val(data.name);
                                        $('#editmul-form input[name="price"]').val(data.price);
                                        $('#editmul-form textarea[name="describe"]').val(data.describe);
                                        $('#editmul-form input[name="propnum"]').val(data.propnum);
                                        $('#editmul-form input[name="sort"]').val(data.sort);
                                        $('#editmul-form input[name="id"]').val(data.id);
                                        form.render();
                                        layer.open({
                                            closeBtn: 2,
                                            type: 1,
                                            area: '700px',
                                            title: '编辑道具',
                                            content: $('#editmul')
                                        }); 
                                    }

                                }else{
                                    layer.msg(result.msg);
                                    window.location.reload();//刷新当前页面.
                                }
                            }
                        });
                   // }
                //});
            });
            //提交编辑道具表单
            $('.editsubmit').click(function() {
                /*var prop_type = $('#editdata-form select[name="prop_type"]').val();
                if (prop_type.length < 1) {
                    layer.msg('请选择类型!');
                    return false;
                }*/
                var name = $("#editdata-form input[name='name']").val();
                if (name.length < 1) {
                    layer.msg('请填写道具名称!');
                    return false;
                }
                var price = $("#editdata-form input[name='price']").val();
                if (price.length < 1) {
                    layer.msg('请填写道具价格!');
                    return false;
                }
                var describe = $('#editdata-form textarea[name="describe"]').val();
                if (describe.length < 1) {
                    layer.msg('请填写道具说明!');
                    return false;
                }
                var propnum = $("#editdata-form input[name='propnum']").val();
                if (propnum.length < 1) {
                    layer.msg('请填写道具数量!');
                    return false;
                }
                
                var From = new FormData(document.getElementById('editdata-form'));
                layer.open({
                    type:3,
                    success: function(layero, index){  
                        $.ajax({
                            url: "<?php echo url('editProp'); ?>",
                            type: 'POST',
                            data: From,
                            processData: false,
                            contentType: false,
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
            $('.editmulsubmit').click(function() {
                var name = $("#editmul-form input[name='name']").val();
                if (name.length < 1) {
                    layer.msg('请填写道具名称!');
                    return false;
                }
                var price = $("#editmul-form input[name='price']").val();
                if (price.length < 1) {
                    layer.msg('请填写道具价格!');
                    return false;
                }
                var describe = $('#editmul-form textarea[name="describe"]').val();
                if (describe.length < 1) {
                    layer.msg('请填写道具说明!');
                    return false;
                }
                var propnum = $("#editmul-form input[name='propnum']").val();
                if (propnum.length < 1) {
                    layer.msg('请填写道具数量!');
                    return false;
                }
                
                var From = new FormData(document.getElementById('editmul-form'));
                layer.open({
                    type:3,
                    success: function(layero, index){  
                        $.ajax({
                            url: "<?php echo url('editProp'); ?>",
                            type: 'POST',
                            data: From,
                            processData: false,
                            contentType: false,
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
            //开启关闭道具
            $('.onOffProp').click(function(){
                var id = $(this).attr('data-id');
                if (id.length<1){ return false;}
                layer.confirm('确认此操作？',function(){
                    layer.open({
                        type:3,
                        success: function(layero, index){  
                            $.ajax({
                                url: "<?php echo url('onOffProp'); ?>",
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
             //删除道具
            $('.delProp').click(function(){
                var id = $(this).attr('data-id');
                if (id.length<1){ return false;}
                layer.confirm('确认删除此操作？',function(){
                    layer.open({
                        type:3,
                        success: function(layero, index){  
                            $.ajax({
                                url: "<?php echo url('delProp'); ?>",
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
