<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"E:\git\StudentAssociation\public/../application/admin\view\admin\index.html";i:1498369760;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>后台管理中心</title>
    <link href="__STATIC__/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/admin/admin/index.css">
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="bg-success">
    <!-- 导航 -->
    <nav id="navbar" class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" id="logo" href="__ROOT__">
                    <img alt="Brand" src="__STATIC__/img/index/index/logo.png" alt="同乡网" title="同乡网">
                </a>
                <a class="navbar-brand" href="__ROOT__">超级管理员后台管理中心</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">我的同乡会</a></li>
                    <li><a href="#">广场</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a>欢迎您，<?php echo \think\Session::get('admin.name'); ?>！</a></li>
                    <li><a href="__ROOT__/admin/user/logout.html"><span class="glyphicon glyphicon-log-out"></span> 注销</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- /导航条 -->
    <!-- 正文内容 -->
    <div class="col-sm-10 col-sm-offset-1">
        <div class="col-sm-2 panel panel-default">
            <table class="table table-hover">
                <tr>
                    <td id="web_info"><a href="javascript:void(0);">网站信息</a></td>
                </tr>
                <tr>
                    <td id="user_center"><a href="javascript:void(0);">个人中心</a></td>
                </tr>
                <tr>
                    <td id="manager"><a href="javascript:void(0);">管理员管理</a></td>
                </tr>
            </table>
        </div>
        <div class="col-sm-10">
            <div class="panel panel-default">
                <ol class="breadcrumb">
                    <li>Home</li>
                    <li class="active" id="route">Web Information</li>
                </ol>
                <iframe id="iframe" src="__ROOT__/admin/admin/web_info.html" width="100%" height="500" frameborder="none"></iframe>
            </div>
        </div>
    </div>
    <!-- /正文内容 -->
    <!-- 引入js插件 -->
    <script src="__STATIC__/js/jquery.min.js"></script>
    <script src="__STATIC__/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    var ROOT = '__ROOT__';
    </script>
    <script src="__STATIC__/js/admin/admin/index.js"></script>
</body>

</html>
