<?php
namespace app\admin\model;

use think\Model;

class User extends Model
{
    protected $table = 'sa_user';
    protected $pk    = 'uid';
}
