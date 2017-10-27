<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/7/4
 * Time: 15:10
 */

namespace app\admin\controller;
use app\admin\model\Work as WorkModel;

/**
 * Class Work
 * @package app\admin\controller
 * 第一聚焦
 */
class Work extends Admin {
    /**
     * 主页列表
     */
    public function index() {
        $map = array(
            'status' => array('eq',0),
        );
        $list = $this->lists('Work',$map);
        int_to_string($list,array(
            'status' => array(0=>'已发布'),
            'type' => array(1=>"通知公告",2=>"小镇动态"),
            'recommend' => array(0=>"否",1=>"是")
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
            $Model = new WorkModel();
            $info = $Model->validate('Work')->save($data);
            if($info) {
                return $this->success("新增成功",Url('Work/index'));
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
            $Model = new WorkModel();
            $info = $Model->validate('Work')->save($data,['id'=>input('id')]);
            if($info){
                return $this->success("修改成功",Url("Work/index"));
            }else{
                return $this->get_update_error_msg($Model->getError());
            }
        }else{
            $this->default_pic();
            $id = input('id');
            $msg = WorkModel::get($id);
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
        $info = WorkModel::where('id',$id)->update($data);
        if($info) {
            return $this->success("删除成功");
        }else{
            return $this->error("删除失败");
        }
    }
}

