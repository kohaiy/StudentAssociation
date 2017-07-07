<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"E:\git\StudentAssociation\public/../application/admin\view\index\user_center.html";i:1498372936;}*/ ?>
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