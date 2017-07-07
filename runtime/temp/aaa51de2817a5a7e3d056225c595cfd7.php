<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"E:\git\StudentAssociation\public/../application/admin\view\user\login.html";i:1497767828;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>后台登录中心</title>
    <link href="__STATIC__/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="bg-success">
    <div class="container">
        <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-xs-12 col-sm-8 col-sm-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">后台登录中心</div>
                <div class="panel-body">
                    <form id="loginForm" method="post">
                        <div class="form-group has-feedback">
                            <label class="control-label" for="username">用户名</label>
                            <input type="text" class="form-control" id="username" placeholder="请输入用户名" name="username">
                            <span id="usernameIcon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span id="usernameHint" class="help-block"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <label class="control-label" for="password">密码</label>
                            <input type="password" class="form-control" id="password" placeholder="请输入密码" name="password">
                            <span id="passwordIcon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            <span id="passwordHint" class="help-block"></span>
                        </div>
                        <button type="submit" class="btn btn-primary pull-right">登录</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- 引入js插件 -->
    <script src="__STATIC__/js/jquery.min.js"></script>
    <script src="__STATIC__/bootstrap/js/bootstrap.min.js"></script>
    <script src="__STATIC__/js/admin/user/login.js"></script>
</body>

</html>
