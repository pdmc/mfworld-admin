<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:76:"/var/www/us4yo-miraila-admin/public/../admin/problem/view/problem/lists.html";i:1527053820;s:65:"/var/www/us4yo-miraila-admin/public/../admin/extra/view/main.html";i:1524451346;}*/ ?>
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

<!--添加试题start-->
    <div id='motai' style="display:none">
        <form id='data-form' class="layui-form" method="post" enctype="multipart/form-data">
            <table class="layui-table">
                <tbody>
                    <tr>
                        <td><span style="color:red">*</span>题目类型</td>
                        <td>  
                            <select name="cate_id" lay-verify="required">
                                <option value="">--请选择--</option>
                                <?php if(is_array($cateList) || $cateList instanceof \think\Collection || $cateList instanceof \think\Paginator): $i = 0; $__LIST__ = $cateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $vo['id']; ?>"><?php echo str_repeat('&nbsp;&nbsp;',$vo['level']); ?>├<?php echo $vo['name']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>题&nbsp;&nbsp;目</td>
                        <td>  
                            <textarea name="name" rows="4" cols="60"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>正确答案</td>
                        <td>  
                            <input type="text"  name="correct" required  lay-verify="required" placeholder="正确答案"  autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>错误答案</td>
                        <td>  
                            <input type="text"  name="error[]" tmpname='one'  placeholder="错误答案"   class="layui-input" required  lay-verify="required"/>
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>错误答案</td>
                        <td>  
                            <input type="text"  name="error[]" tmpname='two'  placeholder="错误答案"   class="layui-input" required  lay-verify="required">
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>错误答案</td>
                        <td>  
                            <input type="text"  name="error[]" tmpname='thr' required  lay-verify="required" placeholder="错误答案" autocomplete="off"  class="layui-input">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>排序</td>
                        <td>
                            <input type="text" name="sort"  placeholder="排序" value="0" autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' style="text-align: center;">  
                            <button class="layui-btn addProSubmit" lay-submit lay-filter="formDemo" type="button">立即提交</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
<!--添加试题end-->

<!--编辑试题start-->
    <div id='editmotai' style="display:none">
        <form id='editdata-form' class="layui-form" method="post" enctype="multipart/form-data">
            <table class="layui-table">
                <tbody>
                    <tr>
                        <td><span style="color:red">*</span>题目类型</td>
                        <td>  
                            <select name="cate_id" lay-verify="required">
                                <option value="">--请选择--</option>
                                <?php if(is_array($cateList) || $cateList instanceof \think\Collection || $cateList instanceof \think\Paginator): $i = 0; $__LIST__ = $cateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <option value="<?php echo $vo['id']; ?>"><?php echo str_repeat('&nbsp;&nbsp;',$vo['level']); ?>├<?php echo $vo['name']; ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>题&nbsp;&nbsp;目</td>
                        <td>  
                            <textarea name="name" rows="4" cols="60"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>正确答案</td>
                        <td>  
                            <input type="text"  name="correct" required  lay-verify="required" placeholder="正确答案"  autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>错误答案</td>
                        <td>  
                            <input type="text"  name="error[]" tmpname='one'  placeholder="错误答案"   class="layui-input" required  lay-verify="required"/>
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>错误答案</td>
                        <td>  
                            <input type="text"  name="error[]" tmpname='two'  placeholder="错误答案"   class="layui-input" required  lay-verify="required">
                        </td>
                    </tr>
                    <tr>
                        <td> <span style="color:red">*</span>错误答案</td>
                        <td>  
                            <input type="text"  name="error[]" tmpname='thr' required  lay-verify="required" placeholder="错误答案" autocomplete="off"  class="layui-input">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>排序</td>
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
<!--编辑试题end-->
<!--导入EXCEL starte-->
    <div id="import_file" style="display: none;">
        <form class="layui-form layui-form-pane" id="importForm" enctype="multipart/form-data" method="post">
            <table  class="layui-table">
                <tbody>
                    <tr>
                        <td><input type="file" name="import_file"></td>
                    </tr>
                    <tr>
                        <td class="layui-form-item" style="text-align: center;">
                            <button class="layui-btn importsubmit" lay-submit lay-filter="formDemo" type="button">立即提交</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
<!--导入EXCEL end-->

<!--查找重复starte-->
    <div id="repeat" style="display: none;">
        <form class="layui-form layui-form-pane" enctype="multipart/form-data" method="post">
            <table  class="layui-table">
                <tbody id="repeat-tbody">
                    <tr>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
<!--查找重复end-->


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
            <a><cite>题库列表</cite></a>
        </span>
    </div>
    <div style="float:right;">
        <?php 
            if(showHandle('problem/Problem/addPro')){
         ?>
            <span class="layui-btn addPro" style="margin-bottom:5px;">添加试题</span>
        <?php 
            }
            if(showHandle('problem/Problem/import')){
         ?>
            <span class="layui-btn import" style="margin-bottom:5px;">批量导入</span>
        <?php 
            }
            if(showHandle('problem/Problem/repeat')){
         ?>
            <span class="layui-btn repeat" style="margin-bottom:5px;">查找重复</span>
        <?php 
            }
         ?>
    </div>
    <form class="layui-form" action="<?php echo url('Problem/lists'); ?>" method="get" style="margin-top:10px;float:left;margin-bottom: -16px;">
        <div class="layui-form-item" style="margin-left:5px;">
            <div class="layui-inline">
                <select name="cate_id" lay-verify="required">
                    <option value="0">--请选择分类--</option>
                    <?php if(is_array($cateList) || $cateList instanceof \think\Collection || $cateList instanceof \think\Paginator): $i = 0; $__LIST__ = $cateList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <option value="<?php echo $vo['id']; ?>"  <?php if(\think\Request::instance()->get('cate_id') == $vo['id']): ?>selected<?php endif; ?> ><?php echo str_repeat('&nbsp;&nbsp;&nbsp;',$vo['level']); ?><?php echo $vo['name']; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
            <div class="layui-inline">
                <input type="text"  name="name" placeholder="问题关键字" value="<?php echo \think\Request::instance()->get('name'); ?>" class="layui-input">
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
                <th style='width:5%;'>题目类型</th>
                <th style='width:20%;'>问题内容</th>
                <th style='width:10%;'>正确答案</th>
                <th style='width:10%;'>错误答案</th>
                <th style='width:4%;'>抽中次数</th>
                <th style='width:4%;'>正确次数</th>
                <th style='width:4%;'>错误次数</th>
                <th style='width:5%;'>状态</th>
                <th style='width:10%;'>添加时间</th>
                <th style='width:20%;'>操作</th>
            </tr> 
        </thead>
        <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $vo['id']; ?></td>
                    <td><?php echo $keyval[$vo['cate_id']]; ?></td>
                    <td><?php echo $vo['name']; ?></td>
                    <td><?php echo $vo['correct']; ?></td>
                    <td><?php echo $allerror[$key][0]; ?><br/><?php echo $allerror[$key][1]; ?><br/><?php echo $allerror[$key][2]; ?></td>
                    <td><?php echo $vo['total_hit']; ?></td>
                    <td><?php echo $vo['right_hit']; ?></td>
                    <td><?php echo $vo['error_hit']; ?></td>
                    <td><?php if(1 == $vo['status']): ?>
                            <span style="color:green;">启用</span>
                        <?php else: ?>
                            <span >禁用</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($vo['create_time'] != '0000-00-00 00:00:00'): ?>
                            <?php echo date("Y-m-d H:i:s",$vo['create_time']); endif; ?>
                    </td>
                    <td>
                        <?php 
                            if(showHandle('problem/Problem/editPro')){
                         ?>
                            <button class="layui-btn layui-btn-small editPro" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>编辑</button>
                        <?php 
                            }
                            if(showHandle('problem/Problem/onOffPro')){
                         if($vo['status'] != '1'): ?>
                                <button class="layui-btn layui-btn-small onOffPro" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>开启</button>
                            <?php else: ?>    
                                <button class="layui-btn layui-btn-small onOffPro" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>关闭</button>
                            <?php endif; 
                            }
                            if(showHandle('problem/Problem/delPro')){
                         ?>
                            <button class="layui-btn layui-btn-small delPro" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>删除</button>
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
            //弹出添加试题模态框
            $('.addPro').click(function() {
                layer.open({
                    closeBtn: 2,
                    type: 1,
                    area: '600px',
                    title: '添加试题',
                    content: $('#motai')
                });
            });
            //提交添加分类信息
            $('.addProSubmit').click(function() {
                var cateId = $("#data-form select[name='cate_id']").val();
                var name = $("#data-form textarea[name='name']").val();
                var correct = $("#data-form input[name='correct']").val();
                if (cateId.length < 1) {
                    layer.msg('请选择分类!');
                    return false;
                }
                if (name.length < 1) {
                    layer.msg('请填写题目!');
                    return false;
                }
                if (correct.length < 1) {
                    layer.msg('请填写正确答案!');
                    return false;
                }
                var oneerror = $("#data-form input[tmpname='one']").val();
                var twoerror = $("#data-form input[tmpname='two']").val();
                var threrror = $("#data-form input[tmpname='thr']").val();
                if(oneerror.length < 1){
                    layer.msg('请填写错误答案!');
                    return false;
                }
                if(twoerror.length < 1){
                    layer.msg('请填写错误答案!');
                    return false;
                }
                if(threrror.length < 1){
                    layer.msg('请填写错误答案!');
                    return false;
                }
                var From = $('#data-form').serialize();
                layer.open({
                    type:3,
                    success: function(layero, index){ 
                        $.ajax({
                            url: "<?php echo url('addPro'); ?>",
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
            //编辑试题信息
            $('.editPro').click(function() {
                var id = $(this).attr('data-id');
                if (id.length<1){ return false;}
                $.ajax({
                    url: "<?php echo url('editPro'); ?>",
                    type: 'post',
                    data: {'id':id,'action':'get'},
                    success: function(d) {
                        var result = eval("(" + d + ")");
                        if (result.flag == 1) {
                            var data = result.data;
                            $('#editdata-form select[name="cate_id"]').find("option[value='"+data.cate_id+"']").attr("selected",true);
                            $('#editdata-form textarea[name="name"]').val(data.name);
                            $('#editdata-form input[name="correct"]').val(data.correct);
                            $('#editdata-form input[tmpname="one"]').val(data.error[0]);
                            $('#editdata-form input[tmpname="two"]').val(data.error[1]);
                            $('#editdata-form input[tmpname="thr"]').val(data.error[2]);
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
                            title: '编辑试题信息',
                            content: $('#editmotai')
                        });
                    }
                });
            });
            //提交编辑试题信息表单
            $('.editsubmit').click(function() {
                var name = $("#editdata-form textarea[name='name']").val();
                var correct = $("#editdata-form input[name='correct']").val();
                if (name.length < 1) {
                    layer.msg('请填写题目!');
                    return false;
                }
                if (correct.length < 1) {
                    layer.msg('请填写正确答案!');
                    return false;
                }
                var oneerror = $("#editdata-form input[tmpname='one']").val();
                var twoerror = $("#editdata-form input[tmpname='two']").val();
                var threrror = $("#editdata-form input[tmpname='thr']").val();
                if(oneerror.length < 1){
                    layer.msg('请填写错误答案!');
                    return false;
                }
                if(twoerror.length < 1){
                    layer.msg('请填写错误答案!');
                    return false;
                }
                if(threrror.length < 1){
                    layer.msg('请填写错误答案!');
                    return false;
                }
                var From = $('#editdata-form').serialize();
                layer.open({
                    type:3,
                    success: function(layero, index){  
                        $.ajax({
                            url: "<?php echo url('editPro'); ?>",
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
            $('.onOffPro').click(function(){
                var id = $(this).attr('data-id');
                if (id.length<1){ return false;}
                layer.confirm('确认此操作？',function(){
                    layer.open({
                        type:3,
                        success: function(layero, index){  
                            $.ajax({
                                url: "<?php echo url('onOffPro'); ?>",
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
            
             //开启关闭
            $('.delPro').click(function(){
                var id = $(this).attr('data-id');
                if (id.length<1){ return false;}
                layer.confirm('确认删除此操作？',function(){
                    layer.open({
                        type:3,
                        success: function(layero, index){  
                            $.ajax({
                                url: "<?php echo url('delPro'); ?>",
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
            
            //批量导入excel表单模态框
            $(".import").bind('click', function(){
                layer.open({
                    closeBtn: 2,
                    type: 1,
                    area: '400px',
                    title: '批量导入excel文件',
                    content: $('#import_file')
                 });
            });
            
            //提交批量导入excel文件
            $('.importsubmit').click(function(){
                layer.confirm('确认此操作？',function(){
                    var From = new FormData(document.getElementById('importForm'));
                    layer.open({
                        type:3,
                        success: function(layero, index){  
                            $.ajax({
                                url: "<?php echo url('import'); ?>",
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
            });
            
            //试题去重
            $(".repeat").bind('click', function(){
                $.ajax({
                    url: "<?php echo url('repeat'); ?>",
                    type: 'POST',
                    success: function(d) {
                        var result = eval("(" + d + ")");
                        if (result.flag == 1) {
                            var data = result.data;
                            var string = '';
                            $.each(data, function(key, val) {
                                string += '<tr><td>'+key+'</td><td>'+val+'</td></tr>';
                            });
                            if(string){
                                $("#repeat-tbody").empty().append(string);
                            }
                            form.render();
                            layer.open({
                                closeBtn: 2,
                                type: 1,
                                area: '400px',
                                title: '重复题目',
                                content: $('#repeat')
                            });
                        }else{
                            layer.msg(result.msg,{icon:1,time:2000},function(){
                                layer.closeAll(); //疯狂模式，关闭所有层
                                window.location.reload();//刷新当前页面.
                            });
                        }
                    }
                });
            });
            
            
            
            
            
        });
    });
</script>

</body>
</html>
