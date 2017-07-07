<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:80:"E:\git\StudentAssociation\public/../application/index\view\user\association.html";i:1499071635;s:75:"E:\git\StudentAssociation\public/../application/index\view\common\base.html";i:1499060521;s:70:"E:\git\StudentAssociation\public/../application/index\view\user\1.html";i:1499003443;s:70:"E:\git\StudentAssociation\public/../application/index\view\user\2.html";i:1498123179;}*/ ?>
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
   
         <div class="container-fuild">
    <div class="col-md-2">
        <div class="panel panel-default text-center">
            <table class="table table-hover">
                <tr>
                    <td><a href="__ROOT__/index/user/index.html">个人中心</a></td>
                </tr>
                <tr>
                    <td><a href="__ROOT__/index/user/association.html">同乡会</a></td>
                </tr>
                <tr>
                    <td><a href="__ROOT__/index/user/post.html">我的帖子</a></td>
                </tr>
                <?php if($role == '0'): ?>
                <tr>
                    <td><a href="__ROOT__/index/user/as_manager.html">同乡会管理</a></td>
                </tr><?php endif; ?>
            </table>
        </div>
    </div>
    <div class="col-md-10">
        <div class="panel panel-default">

<ol class="breadcrumb">
    <li>首页</li>
    <li class="active" id="route">同乡会中心</li>
</ol>
<div class="panel-body">
    <div class="clearfix" style="min-height: 200px;">
        <div id="as-content-panel" class="text-center">
            <?php if(\think\Session::get('user.aid') === null): ?> 没有加入同乡会！
            <button id="join-btn" class="btn btn-primary" type="button" data-toggle="modal" data-target="#join">加入一个同乡会</button>
            <?php if($count === 0): ?>
            <button class="btn btn-link" type="button" data-toggle="modal" data-target="#create">没有找到？申请创建一个同乡会</button>
            <?php endif; if(count($applyList) !== 0): ?>
            <table class="table table-hover">
                <caption class="text-center h4">申请记录
                    <abbr class="small" title="更改学校后所有已有申请将被拒绝，您可以重新申请！">帮助</abbr>
                </caption>
                <thead>
                    <tr>
                        <th class="text-center">学校名称</th>
                        <th class="text-center">申请名称</th>
                        <th class="text-center">申请理由</th>
                        <th class="text-center">申请时间</th>
                        <th class="text-center">回复时间</th>
                        <th class="text-center">申请结果</th>
                        <th class="text-center">备注</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($applyList) || $applyList instanceof \think\Collection || $applyList instanceof \think\Paginator): $i = 0; $__LIST__ = $applyList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td><?php echo $vo['school']['sname']; ?></td>
                        <td><?php echo $vo['sname']; ?></td>
                        <td><?php echo $vo['reason']; ?></td>
                        <td><?php echo $vo['create_time']; ?></td>
                        <td><?php echo $vo['reply_time']; ?></td>
                        <td><?php switch($vo['status']): case "0": ?>
                            <span class="text-info glyphicon glyphicon-refresh">
                                审核中</span> <?php break; case "1": ?>
                            <span class="text-success glyphicon glyphicon-ok-sign">
                                通过</span> <?php break; default: ?>
                            <span class="text-danger glyphicon glyphicon-remove-sign">
                                不通过</span> <?php endswitch; ?>
                        </td>
                        <td><?php echo $vo['msg']; ?></td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
            <?php endif; else: ?>
            <div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">我的同乡会</a></li>
                    <li role="presentation"><a href="#address" aria-controls="address" role="tab" data-toggle="tab">通讯录</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>同乡会名称</th>
                                    <td><?php echo $as['aname']; ?></td>
                                </tr>
                                <tr>
                                    <th>同乡会简介</th>
                                    <td><?php echo $as['abstract']; ?></td>
                                </tr>
                                <tr>
                                    <th>管理员</th>
                                    <td><?php if(is_array($managers) || $managers instanceof \think\Collection || $managers instanceof \think\Paginator): $i = 0; $__LIST__ = $managers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> <?php echo $vo['user']['nickname']; endforeach; endif; else: echo "" ;endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>创建时间</th>
                                    <td><?php echo $as['create_time']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <form method="post">
                            <input type="hidden" name="action" value="quit">
                            <button type="submit" class="btn btn-danger">退出同乡会</button>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="address">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">用户名</th>
                                    <th class="text-center">姓名</th>
                                    <th class="text-center">性别</th>
                                    <th class="text-center">手机</th>
                                    <th class="text-center">QQ</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($users) || $users instanceof \think\Collection || $users instanceof \think\Paginator): $i = 0; $__LIST__ = $users;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <tr>
                                    <td><?php echo $vo['uid']; ?></td>
                                    <td><?php echo $vo['nickname']; ?></td>
                                    <td><?php echo $vo['uname']; ?></td>
                                    <td><?php echo $vo['gender']; ?></td>
                                    <td><?php echo $vo['phone']; ?></td>
                                    <td><?php echo $vo['qq']; ?></td>
                                </tr>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php if(\think\Session::get('user.aid') === null): ?>
        <div class="modal fade" tabindex="-1" role="dialog" id="join">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">加入一个同乡会</h4>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="control-label" for="school">所属学校</label>
                                <input type="text" class="form-control" id="school" placeholder="所属学校" name="school" value="<?php echo \think\Session::get('user.school')['sname']; ?>" disabled>
                                <span id="schoolHint" class="help-block">请从
                                <a href="__ROOT__/index/user/index.html" title="个人中心">个人中心</a>
                                修改</span>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="as">选择已有同乡会</label>
                                <select class="form-control" id="as" name="as">
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <input type="hidden" name="action" value="join">
                            <button type="submit" class="btn btn-primary">立即加入</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="create">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">申请一个同乡会</h4>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                            <div class="form-group has-feedback">
                                <label class="control-label" for="school">所属学校</label>
                                <input type="text" class="form-control" id="school" placeholder="所属学校" name="school" value="<?php echo \think\Session::get('user.school')['sname']; ?>" disabled>
                                <span id="schoolIcon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span id="schoolHint" class="help-block">请从
                                <a href="__ROOT__/index/user/index.html" title="个人中心">个人中心</a>
                                修改</span>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="control-label" for="title">同乡会名称</label>
                                <input type="text" class="form-control" id="title" placeholder="同乡会名称" name="title">
                                <span id="titleIcon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span id="titleHint" class="help-block"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="control-label" for="reason">申请理由</label>
                                <textarea class="form-control" id="reason" placeholder="申请理由" name="reason"></textarea>
                                <span id="reasonIcon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span id="reasonHint" class="help-block"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <input type="hidden" name="action" value="create">
                            <button type="submit" class="btn btn-primary">立即申请</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <?php endif; ?>
    </div>
</div>
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
    	用户中心 @ 柯灰kohai 版权所有 <span class="hidden-xs"> Mail:916309979@qq.com <a href="__ROOT__/admin.html" title="管理网站" style="color: green;background-color: white;">管理网站</a></span>
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
    
<script src="__STATIC__/js/index/user/association.js"></script>
</body>

</html>
