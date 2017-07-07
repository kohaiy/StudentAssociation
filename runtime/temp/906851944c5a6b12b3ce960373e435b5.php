<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"E:\git\StudentAssociation\public/../application/index\view\post\index.html";i:1499051706;s:75:"E:\git\StudentAssociation\public/../application/index\view\common\base.html";i:1499060521;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $post['title']; ?> - 同乡网</title>
    <link href="__STATIC__/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/index/common/base.css">
    
<link rel="stylesheet" type="text/css" href="__STATIC__/css/index/post/index.css">
<link rel="stylesheet" type="text/css" href="__ROOT__/ueditor/third-party/SyntaxHighlighter/shCoreDefault.css">
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="bg-success">
    <!-- 导航 -->
    <nav id="navbar" class="navbar navbar-inverse navbar-fixed-top">
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
                <form action="__ROOT__/index/search.html" method="get" class="navbar-form navbar-left hidden-sm">
                    <div class="form-group">
                        <input type="text" name="key" class="form-control" placeholder="搜索帖子" value="">
                    </div>
                    <button type="submit" class="btn btn-primary">搜索</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <?php if((\think\Session::get('user.nickname') == null)): ?>
                    <li><a href="__ROOT__/index/user/login.html">登录</a></li>
                    <li><a href="__ROOT__/index/user/register.html">注册</a></li>
                    <?php else: ?>
                    <li><a href="__ROOT__/index/user.html">欢迎您，<?php echo \think\Session::get('user.nickname'); ?>！</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span> 设置 <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="__ROOT__/index/user.html"><span class="glyphicon glyphicon-user"></span> 个人中心</a></li>
                            <li><a href="__ROOT__/index/user/association.html"><span class="glyphicon glyphicon-home"></span> 我的同乡会</a></li>
                            <!-- <li><a href="#"><span class="glyphicon glyphicon-list-alt"></span> 通知</a></li> -->
                            <li><a href="__ROOT__/index/letter.html"><span class="glyphicon glyphicon-envelope"></span> 信箱 <span id="count-letter" style="background-color: #d9534f;" class="badge">42</span></a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="__ROOT__/index/user/logout"><span class="glyphicon glyphicon-log-out"></span> 注销</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                    <!-- <li class="hidden-xs">
                        <a href="javascript:void(0);" id="navbar-lock" data="<?php echo \think\Cookie::get('topbar'); ?>">
                            <span class="glyphicon glyphicon-lock" data-toggle="tooltip" data-placement="bottom" title="锁定导航栏"></span></span>
                        </a>
                    </li> -->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
     <!-- 轮播图 -->
    <div id="header">
        <img id="bg" src="__STATIC__/img/index/base/bar.jpg" alt="">
        <img class="hidden-xs" id="hzw" src="__STATIC__/img/index/base/hzw.png" alt="">
        <div id="mark"></div>
    </div>
    <!-- 正文 -->
    <div id="page-content" class="clearfix">
   
        
<div id="panel-parent" class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
    <div class="panel panel-info">
        <ol class="breadcrumb">
            <li>当前位置： <a href="__ROOT__/index.html">首页</a></li>
            <li><?php if($post['board']['aid'] == null): ?><a href="__ROOT__/index/square.html" title="广场">广场</a><?php else: ?><a href="__ROOT__/index.html" title="我的同乡会">我的同乡会</a><?php endif; ?></li>
            <li><a href="__ROOT__/index/board.html?id=<?php echo $post['board']['id']; ?>"><?php echo $post['board']['name']; ?></a></li>
            <li class="active"><?php echo $post['title']; ?></li>
        </ol>
        <div class="panel-body">
            <?php if($post['uid'] == \think\Session::get('user.uid')): ?><a class="pull-right btn btn-success glyphicon glyphicon-edit" href="__ROOT__/index/post/edit.html?id=<?php echo $post['pid']; ?>"> 编辑</a><?php endif; ?>
            <h3 class="text-center"><?php echo $post['title']; ?></h3>
            <div class="clearfix">
                <span class="pull-left"><?php echo $post['user']['nickname']; ?></span>
                <span class="pull-right"><?php echo $post['create_time']; ?></span>
            </div>
            <div id="contents" class="">
                <?php echo $post['content']; ?>
            </div>
            <div id="tags" data="<?php echo $post['tags']; ?>">
                <i class="glyphicon glyphicon-tag">Tags:</i>
            </div>
        </div>
        <div class="panel-footer clearfix">
            <div>
                <div style="width: 10%;" class="pull-left">
                	<div style="width: 50px;height: 50px;background-color: #5bc0de;color: white;text-align: center;line-height: 50px;font-size: 30px;border-radius: 50%;box-shadow: 1px 1px 10px 0px gray;cursor: pointer;">
                		<?php if(\think\Session::get('user') == null): ?>空<?php endif; ?>
                		<?php echo mb_substr(\think\Session::get('user.nickname'),0,1,"utf-8"); ?>
                	</div>
                </div>
                <div style="width: 90%;" class="pull-right">
                    <form method="post">
                        <div class="form-group">
                            <label for="reply">帖子回复</label>
                            <textarea name="reply" id="reply" class="form-control" placeholder="帖子回复"></textarea>
                        </div>
                        <input type="hidden" name="pid" value="<?php echo $post['pid']; ?>">
                        <button class="btn btn-primary pull-right" type="submit">提交回复</button>
                    </form>
                </div>
            </div>
            <table id="reply-list" data="<?php echo $post['pid']; ?>" class="table table-hover">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>回复者</th>
                        <th>回复内容</th>
                        <th>回复时间</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

    </div>
    <!-- 正文结束 -->

    <div id="toast" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <h4 id="content" class="text-center"></h4>
            </div>
        </div>
    </div>

    <!-- 底部版权 -->
    <div id="footer">
    	帖子详情 @ 柯灰kohai 版权所有 <span class="hidden-xs"> Mail:916309979@qq.com <a href="__ROOT__/admin.html" title="管理网站" style="color: green;background-color: white;">管理网站</a></span>
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
    
<script type="text/javascript" src="__ROOT__/ueditor/third-party/SyntaxHighlighter/shCore.js"></script>
<script src="__STATIC__/js/index/post/index.js"></script>
</body>

</html>
