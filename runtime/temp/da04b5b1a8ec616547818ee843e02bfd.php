<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:76:"E:\git\StudentAssociation\public/../application/index\view\search\index.html";i:1498138059;s:75:"E:\git\StudentAssociation\public/../application/index\view\common\base.html";i:1498888762;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>搜索 - 同乡网</title>
    <link href="__STATIC__/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/index/common/base.css">
    
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
                        <input type="text" name="key" class="form-control" placeholder="搜索帖子" value="<?php echo $skey; ?>">
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
                            <li><a href="#"><span class="glyphicon glyphicon-list-alt"></span> 通知</a></li>
                            <li><a href="#"><span class="glyphicon glyphicon-envelope"></span> 私信</a></li>
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
   
        
<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
    <div class="panel panel-info">
        <ol class="breadcrumb">
            <li>当前位置： <a href="__ROOT__/index.html">首页</a></li>
            <li>帖子搜索</li>
            <li class="active"><?php echo $skey; ?></li>
        </ol>
        <div class="panel-body">
        <?php if($list == null): ?>
            <div class="text-center">
                当前未搜索到任何帖子，赶紧换一个关键词吧！
            </div>
        <?php else: ?>
            <table class="table table-hover">
            <thead>
                <tr>
                    <th class="hidden-xs">帖子编号</th>
                    <th>帖子标题</th>
                    <th>发布者</th>
                    <th class="hidden-xs" style="width: 180px;">发表时间</th>
                </tr>
            </thead>
            <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $ks = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "没有帖子！" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($ks % 2 );++$ks;?>
                <tr>
                    <td class="hidden-xs"><?php echo $vo['pid']; ?></td>
                    <td><a href="__ROOT__/index/post.html?id=<?php echo $vo['pid']; ?>" title="<?php echo $vo['title']; ?>"><?php echo str_replace($skey,"<font color='#d9534f'><b>$skey</b></font>",$vo['title']); ?></a></td>
                    <td><?php echo $vo['user']['nickname']; ?></td>
                    <td class="hidden-xs"><?php echo $vo['create_time']; ?></td>
                </tr>
            <?php endforeach; endif; else: echo "没有帖子！" ;endif; ?>
            </tbody>
            </table>
        <?php endif; ?>
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
    	搜索 @ 柯灰kohai 版权所有 <span class="hidden-xs"> Mail:916309979@qq.com <a href="__ROOT__/admin.html" title="管理网站" style="color: green;background-color: white;">管理网站</a></span>
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
    
</body>

</html>