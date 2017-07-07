<?php
namespace app\admin\model;
use think\Model;

class Board extends Model{

	protected $table = 'sa_board';
	protected $pk    = 'id';

	public $error;
	public $result;	

	public function addBoard($name=''){
		$name = trim($name);
		if (strlen($name)<2 || strlen($name)>50) {
			$this->error = '版块名称必须为2-50为字符！<small>1个中文字符占3个字符！</small>';
			return false;
		}
		$time = date('Y-m-d H:i:s',time());
		$this->data([
				'name'=>$name,
				'sort'=>0,
				'create_time'=>$time
			]);
		try {
			$this->result = $this->save();
		} catch (Exception $e) {
			$this->error = '添加版块失败！';
			return false;
		}
		return true;
	}
} 