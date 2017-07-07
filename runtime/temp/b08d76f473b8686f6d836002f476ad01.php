<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:80:"E:\git\StudentAssociation\public/../application/index\view\user\user_center.html";i:1498119233;s:75:"E:\git\StudentAssociation\public/../application/index\view\common\base.html";i:1498028020;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>用户中心 - 同乡网</title>
    <link href="__STATIC__/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/index/common/base.css">
    
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="bg-success">
    <!-- 导航 -->
    <nav id="navbar" class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped or better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" id="logo" href="__ROOT__/index.html">
                    <img alt="Brand" src="__STATIC__/img/index/index/logo.png" alt="同乡网" title="同乡网">
                </a>
                <a class="navbar-brand" href="__ROOT__/index.html">同乡网</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class=""><a href="__ROOT__/index.html">我的同乡会</a></li>
                    <li class=""><a href="__ROOT__/index/square.html">广场</a></li>
                </ul>
                <form class="navbar-form navbar-left hidden-sm">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-primary">搜索</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <?php if((\think\Session::get('user.nickname') == null)): ?>
                    <li><a href="__ROOT__/index/user/login.html">登录</a></li>
                    <li><a href="__ROOT__/index/user/register.html">注册</a></li>
                    <?php else: ?>
                    <li><a href="javascript:void">欢迎您，<?php echo \think\Session::get('user.nickname'); ?>！</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span> 设置 <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="__ROOT__/index/user/user_center.html"><span class="glyphicon glyphicon-user"></span> 个人中心</a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-list-alt"></span> 通知</a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-envelope"></span> 私信</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="__ROOT__/index/user/logout"><span class="glyphicon glyphicon-log-out"></span> 注销</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <li class="hidden-xs">
                        <a href="javascript:void(0);" id="navbar-lock">
                            <span class="glyphicon glyphicon-lock" data-toggle="tooltip" data-placement="bottom" title="锁定导航栏"></span></span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <!-- 正文 -->
    <div id="content" class="clearfix">
        
<div class="container-fuild">
<div class="col-md-2">
	<div class="panel panel-default text-center">
		<table class="table table-hover">
		    <tr>
		        <td id="user_center"><a href="javascript:void(0);">个人中心</a></td>
		    </tr>
		    <tr>
		        <td id="board_manager"><a href="javascript:void(0);">模版管理</a></td>
		    </tr>
		    <tr>
		        <td><a href="javascript:void">操作3</a></td>
		    </tr>
		    <tr>
		        <td><a href="javascript:void">操作4</a></td>
		    </tr>
		    <tr>
		        <td><a href="javascript:void">操作5</a></td>
		    </tr>
		</table>
    </div>
</div>
<div class="col-md-10">
	<div class="panel panel-default">
	    <ol class="breadcrumb">
	        <li>Home</li>
	        <li class="active" id="route">用户中心</li>
	    </ol>
	    <div style="min-height: 200px;">
	    	
	    </div>
    </div>
</div>
</div>

    </div>
    <!-- 正文结束 -->
    <!-- 底部版权 -->
    <div id="footer" class="bg-primary">
    	用户中心 @ 柯灰kohai 版权所有 <span class="hidden-xs"> Mail:916309979@qq.com</span>
    </div>
    <!-- 底部版权结束 -->
    <!-- 悬浮工具条 -->
    <div id="fixed-tools" class="hidden-xs">
        <div>
            <div id="to-top"><span class="glyphicon glyphicon-menu-up"></span>
            </div>
        </div>
        <div>
            <div id="to-bottom"><span class="glyphicon glyphicon-menu-down"></span>
            </div>
        </div>
    </div>
    <!-- 引入js插件 -->
    <script src="__STATIC__/js/jquery.min.js"></script>
    <script src="__STATIC__/bootstrap/js/bootstrap.min.js"></script>
    <script src="__STATIC__/js/index/common/base.js"></script>
    <script type="text/javascript">
    	var ROOT = '__ROOT__';
    	var STATIC = '__STATIC__';
    </script>
    <script src="__STATIC__/js/index/user/user_center.js"></script>
</body>

</html>
