<?php
namespace app\index\model;

use app\index\model\Board as BoardM;
use app\index\model\Tags as TagsM;
use app\index\model\User as UserM;
use think\Model;

class Post extends Model
{

    protected $table = 'sa_post';
    protected $pk    = 'pid';

    public $error;
    public $result;

    /**
     * 通过版块编号获取帖子列表
     * @param  int     $id       版块id
     * @param  string  $order    排序规则
     * @param  int     $offset   偏移量
     * @param  int     $length   查询长度
     * @return arr               帖子列表
     */
    public function getPostListByBoardId($id, $order = 'desc', $offset = null, $length = null)
    {
        if ($id === null) {
            $this->error = 'id不能为空！';
            return null;
        }
        $this->order($this->pk . ' ' . $order);
        if ($offset !== null) {
            $this->limit($offset, $length);
        }
        $this->result = $this->where('id', $id)->select();
        return $this->result;
    }

    /**
     * 添加帖子
     * @param integer $bid     [description]
     * @param integer $uid     [description]
     * @param string  $title   [description]
     * @param string  $content [description]
     * @param string  $tags    [description]
     */
    public function addPost($bid = 0, $uid = 0, $title = '', $content = '', $tags = '')
    {
        if (BoardM::get($bid) === null) {
            $this->error = '版块不存在，请重试！';
            return false;
        }
        if (UserM::get($uid) === null) {
            $this->error = '用户不存在，请重试！';
            return false;
        }
        if (strlen($title) < 5 || strlen($title) > 255) {
            $this->error = '帖子标题字符数应在5-255之间！（1个汉字为3个字符）';
            return false;
        }
        if (strlen($content) < 5 || strlen($content) > 1000000) {
            $this->error = '帖子内容字符数应在5-1000000之间！（1个汉字为3个字符）';
            return false;
        }
        $this->data([
            'uid'         => $uid,
            'id'          => $bid,
            'title'       => $title,
            'content'     => $content,
            'tags'        => $tags,
            'create_time' => date('Y-m-d H:i:s', time()),
        ]);
        try {
            $this->save();
            $tags = explode(' ', $tags);
            for ($i = 0; $i < sizeof($tags); $i++) {
                $tag   = trim($tags[$i]);
                $tagsM = new TagsM;
                $tagE  = $tagsM->where('name', $tag)->find();
                if ($tagE == null) {
                    $tagsM->save(['name' => $tag, 'count' => 1]);
                } else {
                    $tagsM->where('id', $tagE->id)->update(['count' => ['exp', 'count+1']]);
                }
            }
        } catch (Exception $e) {
            $this->error = '帖子发表失败，请重试！';
            return false;
        }
        return true;
    }

    public function updatePost($pid = 0, $user, $title = '', $content = '', $tags = '')
    {
        $post = Post::get($pid);
        if ($post === null) {
            $this->error = '帖子不存在，请重试！';
            return false;
        }
        if ($user['uid'] != $post['uid']) {
            $this->error = '您没有权限修改该帖子！';
            return false;
        }
        if (strlen($title) < 5 || strlen($title) > 255) {
            $this->error = '帖子标题字符数应在5-255之间！（1个汉字为3个字符）';
            return false;
        }
        if (strlen($content) < 5 || strlen($content) > 1000000) {
            $this->error = '帖子内容字符数应在5-1000000之间！（1个汉字为3个字符）';
            return false;
        }
        $data = [
            'title'       => $title,
            'content'     => $content,
            'tags'        => $tags,
            'update_time' => date('Y-m-d H:i:s', time()),
        ];
        try {
            $this->where('pid', $pid)->update($data);
        } catch (Exception $e) {
            $this->error = '帖子更新失败，请重试！';
            return false;
        }
        return true;
    }

    /**
     * 搜索帖子
     * @param  string $key [description]
     * @return [type]      [description]
     */
    public function searchPost($key = '')
    {
        $key = trim($key);
        if (strlen($key) < 1) {
            $this->error = '关键词不能为空！';
            return false;
        }
        $this->result = $this->where('title|tags', 'like', '%' . $key . '%')->select();
        return true;
    }

    public function deletePostByPid($pid)
    {
        try {
            $replyM = new Reply;
            $replyM->where('pid', $pid)->delete();
            $this->destroy($pid);
        } catch (Exception $e) {
            $this->error = $e->getData();
            return false;
        }
        return true;

    }
}
