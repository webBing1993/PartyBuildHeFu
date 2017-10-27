<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/10/27
 * Time: 15:44
 */

namespace app\admin\controller;

use app\admin\model\Style as StyleModel;
/**
 * Class Style
 * @package app\admin\controller
 * 党员风采
 */
class Style extends Admin {
    /**
     * 主页
     */
    public function index() {
        $map = array(
            'status' => array('eq',1),
        );
        $list = $this->lists('Style',$map);
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
            $Model = new StyleModel();
            $info = $Model->validate('Style')->save($data);
            if($info) {
                return $this->success("新增成功",Url('Style/index'));
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
            $Model = new StyleModel();
            $info = $Model->validate('Style')->save($data,['id'=>input('id')]);
            if($info){
                return $this->success("修改成功",Url("Style/index"));
            }else{
                return $this->get_update_error_msg($Model->getError());
            }
        }else{
            $this->default_pic();
            $id = input('id');
            $msg = StyleModel::get($id);
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
        $info = StyleModel::where('id',$id)->update($data);
        if($info) {
            return $this->success("删除成功");
        }else{
            return $this->error("删除失败");
        }
    }
}