<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"E:\git\StudentAssociation\public/../application/admin\view\index\board_manager.html";i:1497773524;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>用户中心</title>
    <link href="__STATIC__/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="__STATIC__/css/admin/index/index.css">
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
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
    <!-- 引入js插件 -->
    <script src="__STATIC__/js/jquery.min.js"></script>
    <script src="__STATIC__/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    var ROOT = '__ROOT__';
    </script>
    <script src="__STATIC__/js/admin/admin/index.js"></script>
</body>

</html>
