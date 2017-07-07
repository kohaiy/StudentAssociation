<?php
namespace app\index\model;

use think\Model;

class Board extends Model
{

    protected $table = 'sa_board';
    protected $pk    = 'id';

    public $error;
    public $result;

    /**
     * 添加版块 前台
     * @param string $name [description]
     */
    public function addBoard($aid = 0, $name = '')
    {
        $aid = intval($aid);
        if ($aid < 1) {
            $this->error = '同乡会编号不存在！';
            return false;
        }
        $name = trim($name);
        if (strlen($name) < 2 || strlen($name) > 50) {
            $this->error = '版块名称必须为2-15为字符！';
            return false;
        }
        $time = date('Y-m-d H:i:s', time());
        $this->data([
            'aid'         => $aid,
            'name'        => $name,
            'sort'        => 0,
            'create_time' => $time,
        ]);
        try {
            $this->result = $this->save();
        } catch (Exception $e) {
            $this->error = '添加版块失败！';
            return false;
        }
        return true;
    }

    public function updateBoard($bid, $bname)
    {
        try {
            $this->where('id', $bid)->update(['name' => $bname]);
        } catch (Exception $e) {
            $this->error = '修改版块失败！';
            return false;
        }
        return true;
    }

    public function deleteBoard($bid)
    {
        try {
            $bid   = intval($bid);
            $postM = new Post;
            $postM->where(['id' => $bid])->delete();
            $this->destroy($bid);
        } catch (Exception $e) {
            $this->error = '删除版块失败！';
            return false;
        }
        return true;
    }

    /**
     * 通过版块编号获取版块信息
     * @param  int $id 版块编号
     * @return res     结果
     */
    public function getBoardById($id)
    {
        if ($id === null) {
            $this->error = '版块编号不能为空！';
            return false;
        }
        $this->result = $this->where($this->pk, $id)->find();
        if ($this->result === null) {
            $this->error = '找不到该版块';
            return false;
        }
        return $this->result;
    }
}
