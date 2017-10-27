<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/7/7
 * Time: 16:05
 */

namespace app\admin\controller;
use app\admin\model\Policy as PolicyModel;

/**
 * Class Policy
 * @package app\admin\controller
 * 最多跑一次
 */
class Policy extends Admin {
    /**
    * 主页列表
    */
    public function index() {
        $map = array(
            'status' => array('egt',1),
        );
        $list = $this->lists('Policy',$map);
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
            $Model = new PolicyModel();
            $info = $Model->validate('Policy')->save($data);
            if($info) {
                return $this->success("新增成功",Url('Policy/index'));
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
            $Model = new PolicyModel();
            $info = $Model->validate('Policy')->save($data,['id'=>input('id')]);
            if($info){
                return $this->success("修改成功",Url("Policy/index"));
            }else{
                return $this->get_update_error_msg($Model->getError());
            }
        }else{
            $this->default_pic();
            $id = input('id');
            $msg = PolicyModel::get($id);
            $this->assign('msg',$msg);

            return $this->fetch();
        }
    }

    /**
     * 删除
     */
    public function del() {
        $id = input('id');
        if (empty($id)){
            return $this->error('系统参数错误');
        }
        $data['status'] = '-1';
        $info = PolicyModel::where('id',$id)->update($data);
        if($info) {
            return $this->success("删除成功");
        }else{
            return $this->error("删除失败");
        }
    }
}