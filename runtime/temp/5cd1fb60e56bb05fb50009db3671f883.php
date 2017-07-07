<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:74:"E:\git\StudentAssociation\public/../application/index\view\user\index.html";i:1499088587;s:75:"E:\git\StudentAssociation\public/../application/index\view\common\base.html";i:1499060521;s:70:"E:\git\StudentAssociation\public/../application/index\view\user\1.html";i:1499003443;s:70:"E:\git\StudentAssociation\public/../application/index\view\user\2.html";i:1498123179;}*/ ?>
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
    <li class="active" id="route">用户中心</li>
</ol>
<div class="panel-body">
    <div class="clearfix" style="min-height: 200px;">
        <div class="col-xs-12 col-sm-6 col-sm-offset-3">
            <form method="post">
                <table class="table table-hover table-bordered table-striped">
                    <tr>
                        <th>ID</th>
                        <td><?php echo \think\Session::get('user.uid'); ?></td>
                    </tr>
                    <tr>
                        <th>用户名</th>
                        <td><?php echo \think\Session::get('user.nickname'); ?></td>
                    </tr>
                    <tr>
                        <th>头像</th>
                        <td>
                            <label for="headicon">
                            <?php if(\think\Session::get('user.head_icon') == null): ?>
                            <img class="head-icon-lg bg-info" src="__STATIC__/img/index/index/logo.png" alt=""> <?php else: ?>
                            <img class="head-icon-lg bg-info" src="__STATIC__<?php echo \think\Session::get('user.head_icon'); ?>" alt=""> <?php endif; ?>
                            </label>
                            <br>
                            <span id="file-path"></span><form id="upload-head">
                            <input type="file" name="headicon" id="headicon" class="hidden"></form>
                            <input type="button" name="" value="上传" class="btn btn-success" for="headicon" id="btn-upload">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <th>姓名</th>
                        <td>
                            <input type="text" class="form-control" id="" placeholder="姓名" name="uname" value="<?php echo \think\Session::get('user.uname'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>性别</th>
                        <td>
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="inlineRadio1" value="" <?php if(\think\Session::get('user.gender') == null): ?>checked<?php endif; ?>>保密
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="inlineRadio2" value="男" <?php if(\think\Session::get('user.gender') == '男'): ?>checked<?php endif; ?>>男
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="inlineRadio3" value="女" <?php if(\think\Session::get('user.gender') == '女'): ?>checked<?php endif; ?>>女
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th>手机</th>
                        <td>
                            <input type="text" class="form-control" id="" placeholder="手机" name="phone" value="<?php echo \think\Session::get('user.phone'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>短号</th>
                        <td>
                            <input type="text" class="form-control" id="" placeholder="短号" name="short_num" value="<?php echo \think\Session::get('user.short_num'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>QQ</th>
                        <td>
                            <input type="text" class="form-control" id="" placeholder="QQ" name="qq" value="<?php echo \think\Session::get('user.qq'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>微信</th>
                        <td>
                            <input type="text" class="form-control" id="" placeholder="微信" name="wechat" value="<?php echo \think\Session::get('user.wechat'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>宿舍</th>
                        <td>
                            <input type="text" class="form-control" id="" placeholder="宿舍" name="dor_num" value="<?php echo \think\Session::get('user.dor_num'); ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>学校</th>
                        <td>
                            <button class="form-control btn btn-default" type="button" data-toggle="modal" data-target="#joinSchool">
                                <?php if(\think\Session::get('user.school') == null): ?> 选择你的学校 <?php else: ?> <?php echo \think\Session::get('user.school')['sname']; endif; ?>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <th>注册时间</th>
                        <td><?php echo \think\Session::get('user.reg_time'); ?></td>
                    </tr>
                </table>
                <button class="btn btn-default" type="button" data-toggle="modal" data-target="#setPassword">修改密码</button>
                <input type="hidden" name="action" value="update">
                <input class="btn btn-primary pull-right" type="submit" value="提交修改">
            </form>
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="setPassword">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">修改密码</h4>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                            <input type="hidden" name="action" value="setPassword">
                            <div class="form-group has-feedback">
                                <label class="control-label" for="oldPassword">旧密码</label>
                                <input type="password" class="form-control" id="oldPassword" placeholder="请输入旧密码" name="oldPassword">
                                <span id="oldPasswordIcon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span id="oldPasswordHint" class="help-block"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="control-label" for="newPassword">新密码</label>
                                <input type="password" class="form-control" id="newPassword" placeholder="请输入新密码" name="newPassword">
                                <span id="newPasswordIcon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span id="newPasswordHint" class="help-block"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label class="control-label" for="newPassword2">验证密码</label>
                                <input type="password" class="form-control" id="newPassword2" placeholder="请再次输入新密码">
                                <span id="newPassword2Icon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <span id="newPassword2Hint" class="help-block"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <button type="submit" class="btn btn-primary">保存修改</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="joinSchool">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">选择你的学校</h4>
                    </div>
                    <form method="post">
                        <div class="modal-body">
                            <table class="table table-border-none">
                                <tr>
                                    <td>
                                        <small class="text-danger">一个账号最多只能更改2次学校！剩余次数为： <big><b>2</b></big> 次。</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select id="provinces" class="form-control">
                                            <option>未选择</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select id="cities" class="form-control">
                                            <option>未选择</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="school" id="schools" class="form-control">
                                            <option>未选择</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                            <input type="hidden" name="action" value="school">
                            <button type="submit" class="btn btn-primary">确认提交</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
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
    
<script src="__STATIC__/js/index/user/index.js"></script>
</body>

</html>
