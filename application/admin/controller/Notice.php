<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2016/10/8
 * Time: 10:29
 */

namespace app\admin\controller;

use app\admin\model\Notice as NoticeModel;
/**
 * Class Notice
 * @package 组织建设
 */
class Notice extends Admin {
    /**
     * 相关通知
     * type: 1
     */
    public function index(){
        $map = array(
            'type' => 1,
            'status' => array('egt',1),
        );
        $list = $this->lists('Notice',$map);
        int_to_string($list,array(
            'status' => array(1=>"已发布"),
            'recommend' => [0 => "否" , 1=> "是"],
            'push' => [0 => "否" , 1=> "是"]
        ));

        $this->assign('list',$list);
        return $this->fetch();
    }

    /**
     * 会议情况
     * type: 2
     */
    public function meet(){
        $map = array(
            'type' => 2,
            'status' => array('egt',1),
        );
        $list = $this->lists('Notice',$map);
        int_to_string($list,array(
            'status' => array(1=>"已发布"),
            'recommend' => [0 => "否" , 1=> "是"],
            'push' => [0 => "否" , 1=> "是"]
        ));

        $this->assign('list',$list);

        return $this->fetch();
    }

    /**
     * 党课情况
     * type: 3
     */
    public function lecture(){
        $map = array(
            'type' => 3,
            'status' => array('egt',1),
        );
        $list = $this->lists('Notice',$map);
        int_to_string($list,array(
            'status' => array(1=>"已发布"),
            'recommend' => [0 => "否" , 1=> "是"],
            'push' => [0 => "否" , 1=> "是"]
        ));

        $this->assign('list',$list);

        return $this->fetch();
    }

    /**
     * 活动招募
     * type: 4
     */
    public function recruit(){
        $map = array(
            'type' => 4,
            'status' => array('egt',1),
        );
        $list = $this->lists('Notice',$map);
        int_to_string($list,array(
            'status' => array(1=>"已发布"),
            'recommend' => [0 => "否" , 1=> "是"],
            'push' => [0 => "否" , 1=> "是"]
        ));

        $this->assign('list',$list);

        return $this->fetch();
    }

    /**
     * 活动情况
     * type: 5
     */
    public function activity(){
        $map = array(
            'type' => 5,
            'status' => array('egt',1),
        );
        $list = $this->lists('Notice',$map);
        int_to_string($list,array(
            'status' => array(1=>"已发布"),
            'recommend' => [0 => "否" , 1=> "是"],
            'push' => [0 => "否" , 1=> "是"]
        ));

        $this->assign('list',$list);

        return $this->fetch();
    }

    /**
     * 相关通知和活动招募 添加
     */
    public function indexadd(){
        if(IS_POST) {
            $data = input('post.');
            $data['create_user'] = $_SESSION['think']['user_auth']['id'];
            $noticeModel = new NoticeModel();
            if (empty($data['time'])){
                return $this->error('请添加时间');
            }
            $data['time'] = strtotime($data['time']);
            $id = $noticeModel->validate('Notice.act')->save($data);
            if($id){
                if($data['type'] == 1){
                    return $this->success("新增相关通知成功",Url('Notice/index'));
                }else{
                    return $this->success("新增活动招募成功",Url('Notice/recruit'));
                }
            }else{
                return $this->error($noticeModel->getError());
            }
        }else {
            $this->default_pic();

            $type = input('type');
            $this->assign('type',$type);
            return $this->fetch();
        }
    }

    /**
     * 相关通知和活动招募 修改
     */
    public function indexedit(){
        if(IS_POST) {
            $data = input('post.');
            $data['create_user'] = $_SESSION['think']['user_auth']['id'];
            $noticeModel = new NoticeModel();
            if (empty($data['time'])){
                return $this->error('请添加时间');
            }
            $data['time'] = strtotime($data['time']);
            $id = $noticeModel->validate('Notice.act')->save($data,['id'=>input('id')]);
            if($id){
                if($data['type'] == 1){
                    return $this->success("修改相关通知成功",Url('Notice/index'));
                }else{
                    return $this->success("修改活动招募成功",Url('Notice/recruit'));
                }
            }else{
                return $this->error("暂无数据更新,修改失败");
            }
        }else{
            $this->default_pic();
            $id = input('id');
            $msg = NoticeModel::get($id);
            $this->assign('msg',$msg);
            return $this->fetch();
        }
    }

    /**
     * 三个情况添加
     */
    public function add(){
        if(IS_POST) {
            $data = input('post.');
            $noticeModel = new NoticeModel();
            if(empty($data['id'])) {
                unset($data['id']);
            }
            $data['create_user'] = $_SESSION['think']['user_auth']['id'];
            $model = $noticeModel->validate('Notice.other')->save($data);
            if($model){
               if ($data['type'] == 3){
                  return $this->success('新增党课情况成功',Url('Notice/lecture'));
               }else if($data['type'] == 5){
                   return $this->success('新增活动情况成功',Url('Notice/activity'));
               }else{
                   return $this->success('新增会议情况成功',Url('Notice/meet'));
               }
            }else{
                 return $this->error($noticeModel->getError());
            }
        }else{
            $this->default_pic();
            $msg = array();
            $msg['type'] = input('type');
            $msg['class'] = 1; // 1为添加 ，2为修改
            $this->assign('msg',$msg);

            return $this->fetch('edit');
        }
    }

    /**
     * 修改
     */
    public function edit(){
        if(IS_POST) {
            $data = input('post.');
            $noticeModel = new NoticeModel();
            $model = $noticeModel->validate('Notice.other')->save($data,['id'=> input('id')]);
            if($model){
                if ($data['type'] == 3){
                    return $this->success('修改党课情况成功',Url('Notice/lecture'));
                }else if($data['type'] == 5){
                    return $this->success('修复活动情况成功',Url('Notice/activity'));
                }else{
                    return $this->success('修改会议情况成功',Url('Notice/meet'));
                }
            }else{
                return $this->get_update_error_msg($noticeModel->getError());
            }
        }else{
            $this->default_pic();

            $id = input('id');
            $msg = NoticeModel::get($id);
            $msg['class'] = 2;
            $this->assign('msg',$msg);

            return $this->fetch();
        }
    }

    /**
     * 删除
     */
    public function del(){
        $id = input('id');
        if (empty($id)){
            return $this->error('系统参数错误');
        }
        $map['status'] = "-1";
        $info = NoticeModel::where('id',$id)->update($map);
        if($info) {
            return $this->success("删除成功");
        }else{
            return $this->error("删除失败");
        }
    }
}