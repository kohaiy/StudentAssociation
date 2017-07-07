<?php
namespace app\index\model;
use think\Model;

class Tags extends Model{

    protected $table = 'sa_tags';
    protected $pk    = 'id';

    public $error;
    public $result;

    public function getTags($offset=0,$lenght=10){
        $this->result = $this->order('count desc')->limit($offset,$lenght)->select();
        return $this->result;
    }
}