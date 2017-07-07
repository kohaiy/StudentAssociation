<?php if (!defined('THINK_PATH')) exit(); /*a:9:{s:75:"E:\git\StudentAssociation\public/../application/admin\view\index\index.html";i:1498654580;s:75:"E:\git\StudentAssociation\public/../application/admin\view\common\base.html";i:1498546746;s:74:"E:\git\StudentAssociation\public/../application/admin\view\index\left.html";i:1498654228;s:83:"E:\git\StudentAssociation\public/../application/admin\view\index\board_manager.html";i:1498374051;s:78:"E:\git\StudentAssociation\public/../application/admin\view\admin\web_info.html";i:1498374500;s:77:"E:\git\StudentAssociation\public/../application/admin\view\admin\manager.html";i:1498375217;s:84:"E:\git\StudentAssociation\public/../application/admin\view\index\school_manager.html";i:1498564227;s:83:"E:\git\StudentAssociation\public/../application/admin\view\index\apply_manager.html";i:1498724152;s:81:"E:\git\StudentAssociation\public/../application/admin\view\index\user_center.html";i:1498372936;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>首页 - 后台管理中心</title>
    <link href="__STATIC__/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/admin/common/base.css">
    <link rel="stylesheet" type="text/css" href="__ROOT__/static/css/admin/index/<?php echo \think\Request::instance()->param('a'); ?>.css">
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
                <a class="navbar-brand" id="logo" href="__ROOT__/admin.html">
                    <img alt="Brand" src="__STATIC__/img/index/index/logo.png" alt="同乡网" title="同乡网">
                </a>
                <a class="navbar-brand" href="__ROOT__/admin.html">后台管理中心</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <!-- <ul class="nav navbar-nav">
                    <li class="active"><a href="#">我的同乡会</a></li>
                    <li><a href="#">广场</a></li>
                </ul> -->
                <ul class="nav navbar-nav navbar-right">
                    <li><a>欢迎您，<?php echo \think\Session::get('admin.name'); ?>！</a></li>
                    <li><a href="__ROOT__/admin/user/logout.html"><span class="glyphicon glyphicon-log-out"></span> 注销</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- /导航条 -->
    <!-- 正文内容 -->
    
    <div id="page-content">
        
<div class="col-lg-10 col-lg-offset-1">
    <div class="col-lg-2 panel panel-default">
    <table class="table table-hover">
    <?php if(\think\Session::get('admin.role') == 0): ?>
        <tr>
            <td id="web_info"><a href="<?php echo url("","a=web_info"); ?>">网站信息</a></td>
        </tr>
        <tr>
            <td id="manager"><a href="<?php echo url("","a=manager"); ?>">管理员管理</a></td>
         </tr>
    <?php endif; ?>
        <tr>
            <td id="user_center"><a href="<?php echo url("","a=user_center"); ?>">个人中心</a></td>
        </tr>
        <tr>
            <td id="board_manager"><a href="<?php echo url("","a=board_manager"); ?>">模版管理</a></td>
        </tr>
        <tr>
            <td id="school_manager"><a href="<?php echo url("","a=school_manager"); ?>">学校管理</a></td>
        </tr>
        <tr>
            <td id="apply_manager"><a href="<?php echo url("","a=apply_manager"); ?>">同乡会申请管理</a></td>
        </tr>
    </table>
</div>
    <div class="col-lg-10">
        <div class="panel panel-default clearfix" style="overflow: auto;">
            <ol class="breadcrumb">
                <li>Home</li>
                <li>用户中心</li>
                <li class="active"><?php echo \think\Request::instance()->param('a'); ?></li>
            </ol>
            <?php if(\think\Request::instance()->param('a') == 'board_manager'): ?>
                <div class="col-sm-8 col-sm-offset-2">
    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#setPassword">添加版块</button>
    <?php if($list == null): ?>
    <p class="bg-info">没有数据！</p>
    <?php else: ?>
    <table class="table table-hover">
        <caption class="text-center">版块列表</caption>
        <thead>
            <tr>
                <th>ID</th>
                <th>排序</th>
                <th>版块名称</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td><?php echo $vo['id']; ?></td>
                <td><?php echo $vo['sort']; ?></td>
                <td><?php echo $vo['name']; ?></td>
                <td>
                    <button type="button" class="btn btn-primary">修改</button>
                    <button type="button" class="btn btn-danger">删除</button>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="setPassword">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">添加版块</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="form-group has-feedback">
                        <input type="hidden" name="action" value="addBoard">
                        <label class="control-label" for="name">版块名称</label>
                        <input type="text" class="form-control" id="name" placeholder="版块名称" name="name">
                        <span id="nameIcon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span id="nameHint" class="help-block"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">添加</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
            <?php elseif(\think\Request::instance()->param('a') == 'web_info'): ?>
                <table class="table table-hover">
    <?php if(is_array($_SERVER) || $_SERVER instanceof \think\Collection || $_SERVER instanceof \think\Paginator): if( count($_SERVER)==0 ) : echo "" ;else: foreach($_SERVER as $k=>$vo): ?>
		<tr>
			<td><?php echo $k; ?></td>
			<td><?php echo $vo; ?></td>
		</tr>
	<?php endforeach; endif; else: echo "" ;endif; ?>
</table>

            <?php elseif(\think\Request::instance()->param('a') == 'manager'): ?>
                <div class="col-sm-8 col-sm-offset-2">
    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#addManager">添加管理员</button>
    <?php if($list == null): ?>
    <p class="bg-info">没有数据！</p>
    <?php else: ?>
    <table class="table table-hover">
        <caption class="text-center">管理员列表</caption>
        <thead>
            <tr>
                <th>ID</th>
                <th>用户名</th>
                <th>角色</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td><?php echo $vo['id']; ?></td>
                <td><?php echo $vo['name']; ?></td>
                <td><?php if($vo['role'] == '1'): ?>管理员<?php else: ?><span class="text-primary">超级管理员</span><?php endif; ?>
                </td>
                <td><button type="button" class="btn btn-danger" <?php if($vo['role'] == '0'): ?>disabled="disabled"<?php endif; ?>>删除</button></td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="addManager">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">添加管理员</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <input type="hidden" name="action" value="addManager">
                    <div class="form-group has-feedback">
                        <label class="control-label" for="username">管理员用户名</label>
                        <input type="text" class="form-control" id="username" placeholder="管理员用户名" name="username">
                        <span id="usernameIcon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span id="usernameHint" class="help-block"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="control-label" for="password">密码</label>
                        <input type="password" class="form-control" id="password" placeholder="默认密码为123456" name="password" readonly>
                        <span id="passwordIcon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span id="passwordHint" class="help-block"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">添加</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
            <?php elseif(\think\Request::instance()->param('a') == 'school_manager'): ?>
                <div class="col-sm-8 col-sm-offset-2">
    <table class="table table-border-none">
        <tr>
            <td>
                <select id="provinces" class="form-control">
                    <option>未选择</option>
                </select>
            </td>
            <td>
                <button id="addProvince" class="btn btn-default" type="button" data-toggle="modal" data-target="#addProvincePanel">添加省份</button>
            </td>
        </tr>
        <tr>
            <td>
                <select id="cities" class="form-control">
                    <option>未选择</option>
                </select>
            </td>
            <td>
                <button id="addCity" class="btn btn-default" type="button" data-toggle="modal" data-target="#addCityPanel">添加城市</button>
            </td>
        </tr>
        <tr>
            <td>
                <select id="schools" class="form-control">
                    <option>未选择</option>
                </select>
            </td>
            <td>
                <button id="addSchool" class="btn btn-default" type="button" data-toggle="modal" data-target="#addSchoolPanel">添加学校</button>
            </td>
        </tr>
    </table>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="addProvincePanel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">添加省份</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="form-group has-feedback">
                        <label class="control-label" for="province">省份名称</label>
                        <input type="text" class="form-control" id="province" placeholder="省份名称" name="province">
                        <span id="nameIcon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span id="nameHint" class="help-block"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">添加</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="addCityPanel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">添加城市</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="form-group has-feedback">
                        <label class="control-label" for="city">城市名称</label>
                        <input type="text" class="form-control" id="city" placeholder="城市名称" name="city">
                        <span id="nameIcon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span id="nameHint" class="help-block"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">添加</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="addSchoolPanel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">添加学校</h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="form-group has-feedback">
                        <label class="control-label" for="name">学校名称</label>
                        <input type="text" class="form-control" id="name" placeholder="学校名称" name="name">
                        <span id="nameIcon" class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        <span id="nameHint" class="help-block"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="submit" class="btn btn-primary">添加</button>
                </div>
            </form>
        </div>
    </div>
</div>

            <?php elseif(\think\Request::instance()->param('a') == 'apply_manager'): ?>
                <div class="panel-body">
    <table class="table table-hover">
        <caption class="text-center h4">
            申请列表
        </caption>
        <thead>
            <tr>
                <th>申请编号</th>
                <th>申请人</th>
                <th>学校名称</th>
                <th>申请名称</th>
                <th>申请时间</th>
                <th>申请结果</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <tr>
                <td>
                    <?php echo $vo['id']; ?>
                </td>
                <td>
                    <?php echo $vo['user']['nickname']; ?>
                </td>
                <td>
                    <?php echo $vo['school']['sname']; ?>
                </td>
                <td>
                    <?php echo $vo['sname']; ?>
                </td>
                <td>
                    <?php echo $vo['create_time']; ?>
                </td>
                <td>
                    <?php switch($vo['status']): case "0": ?>
                    <span class="text-info glyphicon glyphicon-refresh">
                        审核中
                    </span> <?php break; case "1": ?>
                    <span class="text-success glyphicon glyphicon-ok-sign">
                        通过
                    </span> <?php break; default: ?>
                    <span class="text-danger glyphicon glyphicon-remove-sign">
                        不通过
                    </span> <?php endswitch; ?>
                </td>
                <td>
                    <button class="btn btn-primary btn-sm action" data="<?php echo $vo['id']; ?>" type="button">
                        详情
                    </button>
                </td>
            </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="detail" role="dialog" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">
                    申请详情
                </h4>
            </div>
            <form method="post">
                <div class="modal-body">
                    <table class="table">
                        <tr>
                            <th>申请人</th>
                            <td id="uid">loading</td>
                        </tr>
                        <tr>
                            <th>所属学校</th>
                            <td id="school">loading</td>
                        </tr>
                        <tr>
                            <th>同乡会名称</th>
                            <td id="sname">loading</td>
                        </tr>
                        <tr>
                            <th>申请理由</th>
                            <td id="reason">loading</td>
                        </tr>
                        <tr>
                            <th>申请结果</th>
                            <td id="status">loading</td>
                        </tr>
                        <tr>
                            <th>申请时间</th>
                            <td id="create-time">loading</td>
                        </tr>
                        <tr>
                            <th>审核时间</th>
                            <td id="reply-time">loading</td>
                        </tr>
                    </table>
                    <div class="form-group">
                        <label class="control-label" for="msg">审核备注</label>
                        <textarea class="form-control" id="msg" name="msg" placeholder="审核备注"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <input name="aid" type="hidden" value="">
                    <input type="hidden" name="action" value="applysa">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button class="btn btn-danger" type="submit" name="reject">拒绝</button>
                    <button class="btn btn-success" type="submit" name="accept">接受</button>
                    </input>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

            <?php else: ?>
                <div class="col-xs-12 col-sm-6 col-sm-offset-3">
    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <td><?php echo \think\Session::get('admin.id'); ?></td>
        </tr>
        <tr>
            <th>用户名</th>
            <td><?php echo \think\Session::get('admin.name'); ?></td>
        </tr>
        <tr>
            <th>角色</th>
            <td><?php switch(\think\Session::get('admin.role')): case "0": ?>超级管理员<?php break; case "1": ?>管理员<?php break; endswitch; ?>
            </td>
        </tr>
    </table>
    <button class="btn btn-default" type="button" data-toggle="modal" data-target="#setPassword">修改密码</button>
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
            <?php endif; ?>
        </div>
    </div>
</div>

    </div>

    <!-- /正文内容 -->

    <div id="toast" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <h4 id="content" class="text-center"></h4>
            </div>
        </div>
    </div>

    <!-- 引入js插件 -->
    <script src="__STATIC__/js/jquery.min.js"></script>
    <script src="__STATIC__/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    var ROOT = '__ROOT__';
    var STATIC = '__STATIC__';
    </script>
    <script src="__STATIC__/js/admin/common/base.js"></script>
    <script src="__ROOT__/static/js/admin/index/<?php echo \think\Request::instance()->param('a'); ?>.js"></script>
</body>

</html>
