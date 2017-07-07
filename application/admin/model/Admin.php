<?php
namespace app\admin\model;
use think\Model;

class Admin extends Model{

	protected $table = 'sa_admin';
	protected $pk = 'id';

	public $error;
	public $result;

	/**
	 * 初始化超级管理员账号
	 */
	public function __construct(){
		if($this->where('name','admin')->find() == null){
			$this->data([
					'name'=>'admin',
					'password'=>password('123456','sa'),
					'role'=>0
				]);
			$this->save();
		}
	}

	/**
	 * 管理员登录
	 * @param  string $username 用户名
	 * @param  string $password 密码
	 * @return bool             是否登录成功
	 */
	public function login($username='',$password=''){
		$username = trim($username);
		$password = trim($password);
		if (strlen($username)<3 || strlen($username)>10) {
			$this->error = '用户名必须为3-10为字符！<small>1个中文字符占3个字符！</small>';
			return false;
		}
		if (strlen($password)<6 || strlen($password)>20) {
			$this->error = '密码必须为6-20为字符！';
			return false;
		}
		// 对密码进行加密
		$password = password($password,'sa');
		$this->result = $this->where(['name'=>$username,'password'=>$password])->find();
		if (!$this->result) {
			$this->error = '用户名或密码错误，登录失败！';
			return false;
		}
		$this->result['id'] = intval($this->result['id']);
		$this->result['role'] = intval($this->result['role']);
		return true;
	}

	/**
	 * 设置密码
	 * @param integer $id          管理员id
	 * @param string  $oldPassword 旧密码
	 * @param string  $newPassword 新密码
	 * @return bool                是否设置成功
	 */
	public function setPassword($id=0,$oldPassword='',$newPassword=''){
		if ($id < 1) {
			$this->error = '用户编号错误！';
			return false;
		}
		if (strlen($oldPassword)<6 || strlen($oldPassword)>20) {
			$this->error = '旧密码必须为6-20为字符！';
			return false;
		}
		if (strlen($newPassword)<6 || strlen($newPassword)>20) {
			$this->error = '新密码必须为6-20为字符！';
			return false;
		}
		$oldPassword = password($oldPassword,'sa');
		$newPassword = password($newPassword,'sa');
		$this->result = $this->where(['id'=>$id,'password'=>$oldPassword])->find();
		if ($this->result === null) {
			$this->error = '旧密码输入错误！';
			return false;
		}
		try {			
			$this->save(['password'=>$newPassword],['id'=>$id]);
		} catch (Exception $e) {
			$this->error = '修改失败，请重试！';
			return false;
		}
		return true;
	}

	/**
	 * 获取管理员列表
	 * @return list 管理员列表
	 */
	public function getManagerList(){
		$this->result = $this->order('role asc')->select();
		return $this->result;
	}

	public function addManager($username='',$password='123456'){
		$username = trim($username);
		$password = trim($password);
		if (strlen($username)<3 || strlen($username)>10) {
			$this->error = '用户名必须为3-10为字符！<small>1个中文字符占3个字符！</small>';
			return false;
		}
		if (strlen($password)<6 || strlen($password)>20) {
			$this->error = '密码必须为6-20为字符！';
			return false;
		}
		$password = password($password,'sa');
		$this->data([
				'name'=>$username,
				'password'=>$password,
				'role'=>1
			]);
		try {
			$this->result = $this->save();
		} catch (Exception $e) {
			$this->error = '添加管理员失败！';
			return false;
		}
		return true;
	}
}