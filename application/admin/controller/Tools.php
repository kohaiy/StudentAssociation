<?php
namespace app\admin\controller;

use app\admin\model\ApplySa as ApplySaM;
use app\admin\model\City as CityM;
use app\admin\model\Province as ProvinceM;
use app\admin\model\School as SchoolM;
use app\admin\model\User as UserM;

class Tools extends BaseController
{

    public function get()
    {
        if (request()->param('a') !== null) {
            switch (request()->param('a')) {
                case 'province':
                    $provinceM = new ProvinceM;
                    $list      = $provinceM->order('pname asc')->select();
                    return json($list);
                    break;
                case 'city':
                    $cityM = new CityM;
                    $list  = $cityM->getCityListByPid(request()->param('pid'));
                    if ($list === false) {
                        return json(['code' => 1, 'result' => $cityM->error]);
                    }
                    return json(['code' => 0, 'result' => $list]);
                    break;
                case 'school':
                    $schoolM = new SchoolM;
                    $list    = $schoolM->getSchoolListByCid(request()->param('cid'));
                    if ($list === false) {
                        return json(['code' => 1, 'result' => $schoolM->error]);
                    }
                    return json(['code' => 0, 'result' => $list]);
                    break;
                case 'applysa':
                    $applysaM = new ApplySaM;
                    $data     = $applysaM->get(request()->post('id'));
                    if ($data !== null) {
                        $data['school'] = SchoolM::get($data['sid']);
                        $data['user']   = UserM::get($data['uid']);
                    }
                    return json($data);
                    break;
                default:
                    # code...
                    break;
            }
        }
    }

    public function add()
    {
        if (request()->param('a') !== null) {
            switch (request()->param('a')) {
                case 'province':
                    $provinceM = new ProvinceM;
                    if ($provinceM->add(request()->post('province'))) {
                        $result['code']   = 0;
                        $result['result'] = '添加成功！';
                    } else {
                        $result['code']   = 1;
                        $result['result'] = $provinceM->error;
                    }
                    return json($result);
                    break;
                case 'city':
                    $cityM = new CityM;
                    if ($cityM->add(request()->post('pid'), request()->post('city'))) {
                        $result['code']   = 0;
                        $result['result'] = '添加成功！';
                    } else {
                        $result['code']   = 1;
                        $result['result'] = $cityM->error;
                    }
                    return json($result);
                    break;

                default:
                    # code...
                    break;
            }
        }
    }
}
