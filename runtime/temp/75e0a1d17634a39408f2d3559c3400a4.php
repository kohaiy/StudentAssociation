<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"E:\git\StudentAssociation\public/../application/admin\view\admin\web_info.html";i:1497450051;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>网站信息</title>
    <link href="__STATIC__/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <table class="table table-hover">
        <?php if(is_array($server) || $server instanceof \think\Collection || $server instanceof \think\Paginator): if( count($server)==0 ) : echo "" ;else: foreach($server as $k=>$vo): ?>
			<tr>
				<td><?php echo $k; ?></td>
				<td><?php echo $vo; ?></td>
			</tr>
		<?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
    <!-- 引入js插件 -->
    <script src="__STATIC__/js/jquery.min.js"></script>
    <script src="__STATIC__/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
    var ROOT = '__ROOT__';
    </script>
</body>

</html>
