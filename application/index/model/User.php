<?php
namespace app\index\model;

use app\common\model\Manager as ManagerM;
use think\Model;
use think\Session;
use think\Validate;

class User extends Model
{

    protected $table = 'sa_user';
    protected $pk    = 'uid';

    public $error;
    public $result;

    public static function get($data, $with = [], $cache = false)
    {
        $user           = parent::get($data, $with, $cache);
        $user['school'] = School::get($user['school']);
        return $user;
    }

    /**
     * 用户登录
     * @param  string $username 用户名
     * @param  string $password 密码
     * @return bool             是否登录成功
     */
    public function login($username = '', $password = '')
    {
        $username = trim($username);
        $password = trim($password);
        if (strlen($username) < 3 || strlen($username) > 30) {
            $this->error = '用户名必须为3-10为字符！';
            return false;
        }
        if (strlen($password) < 6 || strlen($password) > 20) {
            $this->error = '密码必须为6-20为字符！';
            return false;
        }

        // 检查用户名是否存在
        if (!$this->checkUsername($username)) {
            return false;
        }
        // 对密码进行加密
        $password     = password($password, $this->result->data['reg_time']);
        $this->result = $this->where(['nickname' => $username, 'password' => $password])->find();
        if (!$this->result) {
            $this->error = '密码错误，登录失败！';
            return false;
        }
        $this->where('uid', $this->result['uid'])->update(['last_login' => date('Y-m-d H:i:s', time())]);
        $this->result = $this->get($this->result['uid']);
        return true;
    }

    /**
     * 注册
     * @param  string $username 用户名
     * @param  string $password 密码
     * @return bool           是否注册成功
     */
    public function register($username = '', $password = '')
    {
        $username = trim($username);
        $password = trim($password);
        if (strlen($username) < 3 || strlen($username) > 30) {
            $this->error = '用户名必须为3-10为字符！';
            return false;
        }
        if (strlen($password) < 6 || strlen($password) > 20) {
            $this->error = '密码必须为6-20为字符！';
            return false;
        }

        // 检查用户名是否存在
        if ($this->checkUsername($username)) {
            return false;
        }

        $this->nickname = $username;
        $this->reg_time = date('Y-m-d H:i:s', time());
        $this->password = password($password, $this->reg_time);
        try {
            $this->save();
        } catch (\Exception $e) {
            $this->error = '注册失败，请重试！';
            return false;
        }
        return true;
    }

    /**
     * 检查用户名是否存在
     * @param  string $username 待检查用户名
     * @return bool             是否存在
     */
    public function checkUsername($username = '')
    {
        $username     = trim($username);
        $this->result = $this->where('nickname', $username)->find();
        if ($this->result != null) {
            $this->error = '用户名已经存在！';
            return true;
        } else {
            $this->error = '用户名不存在！';
            return false;
        }
    }

    /**
     * 设置密码
     * @param [type] $user        [description]
     * @param [type] $oldPassword [description]
     * @param [type] $newPassword [description]
     */
    public function setPassword($user, $oldPassword, $newPassword)
    {
        $validate = new Validate([
            'uid|用户id'          => 'require|number',
            'oldPassword|旧密码' => 'require|length:6,20',
            'newPassword|新密码' => 'require|length:6,20',
        ], [
            'oldPassword.require' => '旧密码不能为空！',
            'newPassword.require' => '新密码不能为空！',
            'oldPassword.length'  => '旧密码必须为6-20字符！',
            'newPassword.length'  => '新密码必须为6-20字符！',
        ]);
        $data = [
            'uid'         => $user->uid,
            'oldPassword' => $oldPassword,
            'newPassword' => $newPassword,
        ];
        if (!$validate->check($data)) {
            $this->error = $validate->getError();
            return false;
        }
        $oldPassword  = password($oldPassword, $user->reg_time);
        $newPassword  = password($newPassword, $user->reg_time);
        $this->result = $this->where(['uid' => $user->uid, 'password' => $oldPassword])->find();
        if ($this->result === null) {
            $this->error = '旧密码输入错误！';
            return false;
        }
        $this->where(['uid' => $user->uid, 'password' => $oldPassword])->update(['password' => $newPassword]);
        return true;
    }

    /**
     * 更新用户信息
     * @param  [type] &$user [description]
     * @param  [type] $data  [description]
     * @return [type]        [description]
     */
    public function updataUserInfo(&$user, $data)
    {
        foreach ($data as $key => $value) {
            if (strlen($value) < 1) {
                unset($data[$key]);
            }
        }
        if (!isset($data['gender'])) {
            $data['gender'] = null;
        }
        try {
            $this->where('uid', $user->uid)->update($data);
        } catch (Exception $e) {
            $this->error = '更新失败，请重试！';
            return false;
        }
        $user = $this->get($user->uid);
        Session::set('user', $user);
        return true;
    }

    /**
     * 更新用户的学校信息
     * @param  obj     &$user     用户
     * @param  integer $schoolId 学校编号
     * @return bool              是否操作成功
     */
    public function updataUserSchool(&$user, $schoolId = 0)
    {
        if ($user['aid'] !== null) {
            $this->error = '请先退出同乡会，再更改学校！';
            return false;
        }
        $schoolId = intval($schoolId);
        if ($schoolId < 1 || School::get($schoolId) === null) {
            $this->error = '学校不存在！';
            return false;
        }
        try {
            $this->where('uid', $user->uid)->update(['school' => $schoolId]);
        } catch (Exception $e) {
            $this->error = '更新学校失败，请重试！';
            return false;
        }
        $applysaM = new ApplySa;
        $applysaM->refuseApply(0, $user->uid, '用户更新了学校');
        $letterM = new Letter;
        $letterM->addLetter('更新学校', '你更改了学校！', $user['uid']);
        $user = $this->get($user->uid);
        Session::set('user', $user);
        return true;
    }

    /**
     * 退出同乡会
     * @param  [type] $user [description]
     * @return [type]       [description]
     */
    public function quitAs($user)
    {
        $managerM = new ManagerM;
        $result   = $managerM->where([
            'aid' => $user['aid'],
            'uid' => $user['uid'],
        ])->find();
        if ($result !== null) {
            if ($result['role'] === 0) {
                $this->error = '您是该同乡会的会长，不能退出该同乡会！';
                return false;
            } else {
                $result->delete();
            }
        }
        try {
            $this->where('uid', $user['uid'])->update(['aid' => null]);
            $letterM = new Letter;
            $letterM->addLetter('退出同乡会', '你退出了同乡会！', $user['uid']);
        } catch (Exception $e) {
            $this->error = '退出同乡会失败，请重试！|' . $e->getData();
            return false;
        }
        return true;
    }
}
