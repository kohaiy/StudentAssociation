<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"E:\git\StudentAssociation\public/../application/index\view\board\test.html";i:1499084195;}*/ ?>
<div>
<ul>
<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$post): $mod = ($i % 2 );++$i;?>
    <li> <?php echo $post['pid']; ?></li>
<?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
<?php echo $list->render(); ?>