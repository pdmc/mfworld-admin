<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:78:"/var/www/us4yo-miraila-admin/public/../admin/guessing/view/guessing/lists.html";i:1529664768;s:65:"/var/www/us4yo-miraila-admin/public/../admin/extra/view/main.html";i:1524451346;}*/ ?>
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

<!--编辑开奖start-->
    <div id='motai' style="display:none">
        <form id='data-form' class="layui-form" method="post" enctype="multipart/form-data">
            <table class="layui-table">
                <tbody>
                    <tr>
                        <td><span style="color:red">*</span>正确答案:</td>
                        <td>
                            <input type="radio" name="correct" option='option_one'>
                            <input type="radio" name="correct" option='option_two'>
                        </td>
                    </tr>
                    <tr>
                        <td>结果说明:</td>
                        <td>
                            <input type="text" name="remark"  placeholder="结果说明" autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2' style="text-align: center;">
                            <input type='hidden' name='action' value='post'>
                            <input type='hidden' name='id'>
                            <button class="layui-btn editWinSubmit" lay-submit lay-filter="formDemo" type="button">立即提交</button>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </form>
    </div>
<!--编辑开奖end-->
<!--查看开奖start-->
    <div id='editmotai' style="display:none">
        <form id='editdata-form' class="layui-form" method="post" enctype="multipart/form-data">
            <table class="layui-table">
                <tbody>
                    <tr>
                        <td>正确答案:</td>
                        <td>
                            <input type="radio" disabled="true" name="correct" option='option_one'>
                            <input type="radio" disabled="true" name="correct" option='option_two'>
                        </td>
                    </tr>
                    <tr>
                        <td>结果说明:</td>
                        <td>
                            <input type="text" disabled="true" name="remark"  placeholder="结果说明" autocomplete="off" class="layui-input">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
<!--查看开奖end-->

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
            <a><cite>竞猜列表</cite></a>
        </span>
    </div>
    <form class="layui-form" action="<?php echo url('Guessing/lists'); ?>" method="get" style="margin-top:10px;float:left;margin-bottom: -16px;">
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
                <input type="text"  name="title" placeholder="关键字" value="<?php echo \think\Request::instance()->get('title'); ?>" class="layui-input">
            </div>
            <div class="layui-inline">
                <button class="layui-btn">查找</button>
            </div>
        </div>
    </form>

    <div style="float:right;">
        <?php 
            if(showHandle('guessing/Guessing/addGuess')){
         ?>
            <a  href ="<?php echo url('guessing/Guessing/addGuess'); ?>"  class="layui-btn" style="margin-bottom:5px;">添加竞猜</a>
        <?php 
            }
         ?>
    </div>


    <table lay-even class="layui-table" style="margin-top:-16px;">
        <thead>
            <tr> 
                <th style='width:3%;'>ID</th>
                <th style='width:6%;'>竞猜类型</th>
                <th style='width:15%;'>竞猜标题</th>
                <th style='width:10%;'>选项A(金额)<br/>选项B(金额)</th>
                <th style='width:8%;'>奖池<br/>平台比例</th>
                <th style='width:9%;'>开奖时时</th>
                <th style='width:9%;'>发布时间</th>
                <th style='width:9%;'>截止时间</th>
                <th style='width:6%;'>结果说明</th>
                <th style='width:7%;'>状态</th>
                <th style='width:15%;'>操作</th>
            </tr> 
        </thead>
        <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <tr>
                    <td><?php echo $vo['id']; ?></td>
                    <td><?php echo $keyval[$vo['cate_id']]; ?></td>
                    <td><?php echo $vo['title']; ?></td>
                    <td><?php echo $vo['option_one']; ?>(<?php echo $vo['option_one_total']; ?>)<br/><?php echo $vo['option_two']; ?>(<?php echo $vo['option_two_total']; ?>)</td>
                    <td><?php echo $vo['option_all_total']; ?><br/><?php echo $vo['seller_proportion']; ?></td>
                    <td>
                        <?php if($vo['prize_time'] != '0'): ?>
                            <?php echo date("Y-m-d H:i:s",$vo['prize_time']); endif; ?>
                    </td>
                    <td>
                        <?php if($vo['pub_time'] != '0'): ?>
                            <?php echo date("Y-m-d H:i:s",$vo['pub_time']); endif; ?>
                    </td>
                    <td>
                        <?php if($vo['close_time'] != '0'): ?>
                            <?php echo date("Y-m-d H:i:s",$vo['close_time']); endif; ?>
                    </td>
                    <td><?php echo $vo['remark']; ?></td>
                    <td>
                        <?php if($vo['status'] == '0'): ?><span>新添加</span><?php endif; if($vo['status'] == '1'): ?><span style="color:green;">进行中</span><?php endif; if($vo['status'] == '2'): ?><span>待开奖</span><?php endif; if($vo['status'] == '3'): ?><span>已开奖</span><?php endif; ?>
                    </td>
                    <td>
                        <?php if($vo['status'] == '0'): 
                                if(showHandle('guessing/Guessing/editGuess')){
                             ?>
                                <a href="<?php echo url('guessing/Guessing/editGuess',['id'=>$vo['id']]); ?>"><button class="layui-btn layui-btn-small" style='font-size:15px;'>编辑</button></a>
                            <?php 
                                }
                                if(showHandle('guessing/Guessing/pubGuess')){
                             ?>
                                <button class="layui-btn layui-btn-small pubGuess" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>发布</button>
                            <?php 
                                }
                             endif; if($vo['status'] == '2'): 
                                if(showHandle('guessing/Guessing/editWin')){
                             ?>
                                <button class="layui-btn layui-btn-small editWin" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>编辑开奖</button>
                            <?php 
                                }
                             endif; if($vo['status'] == '3'): 
                                if(showHandle('guessing/Guessing/viewWin')){
                             ?>
                                <button class="layui-btn layui-btn-small viewWin" data-id=<?php echo $vo['id']; ?> style='font-size:15px;'>查看开奖</button>
                            <?php 
                                }
                             endif; ?>
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
            //发布功能
            $('.pubGuess').click(function(){
                var id = $(this).attr('data-id');
                if (id.length<1){ return false;}
                layer.confirm('确认发布操作？',function(){
                    layer.open({
                        type:3,
                        success: function(layero, index){  
                            $.ajax({
                                url: "<?php echo url('pubGuess'); ?>",
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
            //编辑开奖
            $('.editWin').click(function() {
                var id = $(this).attr('data-id');
                if (id.length<1){ return false;}
                $.ajax({
                    url: "<?php echo url('editWin'); ?>",
                    type: 'post',
                    data: {'id':id,'action':'get'},
                    success: function(d) {
                        var result = eval("(" + d + ")");
                        if (result.flag == 1) {
                            var data = result.data,str = '';
                            $('#data-form input[option="option_one"]').attr('value',data.option_one);
                            $('#data-form input[option="option_one"]').attr('title',data.option_one);
                            $('#data-form input[option="option_two"]').attr('value',data.option_two);
                            $('#data-form input[option="option_two"]').attr('title',data.option_two);
                            $('#data-form input[name="remark"]').val(data.remark);
                            $('#data-form input[name="id"]').val(data.id);
                            form.render();
                            layer.open({
                                closeBtn: 2,
                                type: 1,
                                area: '600px',
                                title: '编辑开奖',
                                content: $('#motai')
                            });
                        }else{
                            layer.msg(result.msg);
                            window.location.reload();//刷新当前页面.
                        }
                    }
                });
            });
            //提交编辑开奖
            $('.editWinSubmit').click(function() {
                if (!$("#data-form input[name='correct']").is(":checked")) {
                    layer.msg('请选择正确答案!');
                    return false;
                }
                var From = $('#data-form').serialize();
                layer.open({
                    type:3,
                    success: function(layero, index){  
                        $.ajax({
                            url: "<?php echo url('editWin'); ?>",
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
            //查看开奖信息
            $('.viewWin').click(function() {
                var id = $(this).attr('data-id');
                if (id.length<1){ return false;}
                $.ajax({
                    url: "<?php echo url('viewWin'); ?>",
                    type: 'post',
                    data: {'id':id},
                    success: function(d) {
                        var result = eval("(" + d + ")");
                        if (result.flag == 1) {
                            var data = result.data,str = '';
                            $('#editdata-form input[option="option_one"]').attr('title',data.option_one);
                            $('#editdata-form input[option="option_two"]').attr('title',data.option_two);
                            $('#editdata-form input[name="remark"]').val(data.remark);
                            $('#editdata-form input[title="'+data.correct+'"]').attr('checked','true');
                            form.render();
                            layer.open({
                                closeBtn: 2,
                                type: 1,
                                area: '600px',
                                title: '查看开奖',
                                content: $('#editmotai')
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
