<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:72:"/var/www/us4yo-miraila-admin/public/../admin/login/view/login/login.html";i:1527230218;}*/ ?>
<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="_ADMIN_/login/login.css">
    <link rel="stylesheet" href="_ADMIN_/layer/css/layui.css">
    <script type="text/javascript" src="_ADMIN_/login/jquery.min.js"></script>
    <title>北京帕可福优科技有限公司</title>
</head>
<body>
    <div id="login_top">
        <div id="welcome">欢迎使用未来世界管理系统</div>
        <div id="back">
                <!--<a href="#">返回首页</a>&nbsp;&nbsp; | &nbsp;&nbsp;
                <a href="#">帮助</a>-->
        </div>
    </div>
    <div id="login_center">
        <div id="login_area">
            <div id="login_form">
                <form onsubmit="return false;" id="loginform">
                    <div id="login_tip">
                        用户登录&nbsp;&nbsp;UserLogin
                    </div>
                    <div><input type="text" name="username" class="username"></div>
                    <div><input type="password" name="password" class="pwd"></div>
                    <div id="btn_area">
                        <input type="submit" class="layui-btn" value="登&nbsp;&nbsp;录" style="margin-left:190px;height:44px;width:150px;background-color:#0CAFE6;text-align:center;border-radius:25px;color:white;font-size:14px;">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="login_bottom" style="color:white;">版权所有 ©北京帕可福优科技有限公司</div>
    <script src="_ADMIN_/layer/layui.js"></script>
    <script>
        if (window.location.href.indexOf('#') > -1) {
            window.location.href = window.location.href.split('#')[0];
        }
        layui.use(['layer','form','jquery'],function(){
            var layer = layui.layer, $ = layui.jquery, form = layui.form();
            $('.layui-btn').click(function(){
                var username = $("#loginform input[name='username']").val();
                var password = $("#loginform input[name='password']").val();
                if (username.length < 1) {
                    layer.msg('请输入用户名！');
                    return false;
                }
                if (password.length < 1) {
                    layer.msg('请输入密码！');
                    return false;
                }
                
                var From =  $('#loginform').serialize();
                $.ajax({
                    url: "<?php echo url('login'); ?>",
                    type: 'POST',
                    data: From,
                    success:function(d){
                        var result = eval("(" + d + ")");
                        if (result.flag == 3) {
                            layer.msg(result.msg);
                            window.location.href = "<?php echo url('/index/Index/index'); ?>";
                        } else {
                            layer.msg(result.msg);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>