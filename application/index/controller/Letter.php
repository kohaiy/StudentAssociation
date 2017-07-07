<?php
namespace app\index\controller;

use app\index\model\Letter as LetterM;

class Letter extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->checkUserStatus();
    }

    public function index()
    {
        return $this->fetch();
    }

    public function getLetterList()
    {
        $letterM = new LetterM;
        if ($letterM->getLetterListByUid($this->user['uid'])) {
            $data['code']   = 0;
            $data['result'] = $letterM->result;
        } else {
            $data['code']   = 1;
            $data['result'] = $letterM->error;
        }
        return json($data);
    }

    public function setLetterStatus()
    {
        $letterM = new LetterM;
        $letterM->where('id', request()->post('id'))->update(['status' => 0]);
        return json(0);
    }

    public function countLetterStatus()
    {
        $letterM = new LetterM;
        $count   = $letterM->where([
            'status' => 1,
            'accepter'    => $this->user['uid'],
        ])->count();
        return json($count);
    }
}
