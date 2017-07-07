<?php
namespace app\index\model;

use think\Model;

class Province extends Model
{

    protected $table = 'sa_province';
    protected $pk    = 'pid';

    public $error;
    public $result;

    public function add($name = '')
    {
        $name = trim($name);
        if (strlen($name) < 2 || strlen($name) > 50) {
            $this->error = '省份名称为2-15字符！';
            return false;
        }
        if ($this->where('pname', $name)->find() !== null) {
            $this->error = '该省份已经存在了！';
            return false;
        }
        try {
            $this->save(['pname' => $name]);
        } catch (Exception $e) {
            $this->error = $e->getData();
            return false;
        }

        return true;
    }
}
