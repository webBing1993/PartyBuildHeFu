<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/10/31
 * Time: 10:05
 */

namespace app\admin\controller;

use app\admin\model\Volunteer as VolunteerModel;
use app\admin\model\VolunteerDetail;

/**
 * Class Volunteer
 * @package app\admin\controller
 * 志愿服务
 */
class Volunteer extends Admin {
    /**
     * 主页
     */
    public function index() {
        $map = array(
            'status' => array('eq',1),
        );
        $list = $this->lists('Volunteer',$map);
        int_to_string($list,array(
            'status' => array(1=>'已发布'),
        ));
        $this->assign('list',$list);
        return $this->fetch();
    }

    /**
     * 新增
     */
    public function add() {
        if(IS_POST) {
            $data = input('post.');
            $data['create_user'] = $_SESSION['think']['user_auth']['id'];
            if(empty($data['id'])) {
                unset($data['id']);
            }
            $Model = new VolunteerModel();
            $info = $Model->validate('Volunteer.index')->save($data);
            if($info) {
                return $this->success("新增成功",Url('Volunteer/index'));
            }else{
                return $this->get_update_error_msg($Model->getError());
            }
        }else{
            $this->default_pic();
            $this->assign('msg','');

            return $this->fetch('edit');
        }
    }

    /**
     * 修改
     */
    public function edit() {
        if(IS_POST) {
            $data = input('post.');
            $Model = new VolunteerModel();
            $info = $Model->validate('Volunteer.index')->save($data,['id'=>input('id')]);
            if($info){
                return $this->success("修改成功",Url("Volunteer/index"));
            }else{
                return $this->get_update_error_msg($Model->getError());
            }
        }else{
            $this->default_pic();
            $id = input('id');
            $msg = VolunteerModel::get($id);
            $this->assign('msg',$msg);

            return $this->fetch();
        }
    }

    /**
     * 删除
     */
    public function del() {
        $id = input('id');
        $data['status'] = '-1';
        $info = VolunteerModel::where('id',$id)->update($data);
        if($info) {
            VolunteerDetail::where('pid',$id)->update($data); //删除下属活动信息
            return $this->success("删除成功");
        }else{
            return $this->error("删除失败");
        }
    }
    
    /**
     * 志愿服务活动主页
     */
    public function index2() {
        $id = input('id');
        $map = array(
            'pid' => $id,
            'status' => array('eq',1),
        );
        $list = $this->lists('VolunteerDetail',$map);
        int_to_string($list,array(
            'status' => array(1=>'已发布'),
            'recommend' => array(0=>"否",1=>"是")
        ));
        $this->assign('list',$list);
        
        $res = VolunteerModel::get($id);
        $this->assign('res',$res);
        return $this->fetch();
    }

    /**
     * 活动新增
     */
    public function d_add() {
        if(IS_POST) {
            $data = input('post.');
            $data['create_user'] = $_SESSION['think']['user_auth']['id'];
            if(empty($data['id'])) {
                unset($data['id']);
            }
            $Model = new VolunteerDetail();
            $info = $Model->validate('Volunteer.detail')->save($data);
            if($info) {
                VolunteerModel::where('id',$data['pid'])->setInc('times');
                return $this->success("新增成功",Url('Volunteer/index2?id='.$data['pid']));
            }else{
                return $this->get_update_error_msg($Model->getError());
            }
        }else{
            $this->default_pic();
            $this->assign('msg','');
            $pid = input('pid');
            $this->assign('pid',$pid);
            return $this->fetch('d_edit');
        }
    }

    /**
     * 活动修改
     */
    public function d_edit() {
        if(IS_POST) {
            $data = input('post.');
            $Model = new VolunteerDetail();
            $info = $Model->validate('Volunteer.detail')->save($data,['id'=>input('id')]);
            if($info){
                return $this->success("修改成功",Url("Volunteer/index2?id=".$data['pid']));
            }else{
                return $this->get_update_error_msg($Model->getError());
            }
        }else{
            $this->default_pic();
            $id = input('id');
            $msg = VolunteerDetail::get($id);
            $this->assign('msg',$msg);
            return $this->fetch();
        }
    }

    /**
     * 活动删除
     */
    public function d_del() {
        $id = input('id');
        $pid = input('pid');
        $data['status'] = '-1';
        $info = VolunteerDetail::where('id',$id)->update($data);
        if($info) {
            VolunteerModel::where('id',$pid)->setDec('times');
            return $this->success("删除成功");
        }else{
            return $this->error("删除失败");
        }
    }
}