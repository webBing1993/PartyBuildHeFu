<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 下午 4:17
 */

namespace app\home\controller;
use app\home\model\Notice;
/*
 * 组织建设
 */
class Organization extends Base {
    /**
     * @return mixed  主页
     */
    public function index(){
        $Notice = new Notice();
        // 三会一课
        $notice = $Notice->get_list(['type' => 1,'status' => ['egt',1]],0,true);  // 相关通知
        $meeting = $Notice->get_list(['type' => 2,'status' => ['egt',1]],0,true); // 会议情况
        $party = $Notice->get_list(['type' => 3,'status' => ['egt',1]],0,true);  // 党课情况
        // 组织生活
        $planing = $Notice->get_list(['type' => 4,'status' => ['egt',1]],0,true);  // 活动招募
        $activity = $Notice->get_list(['type' => 5,'status' => ['egt',1]],0,true); // 活动情况
        $this->assign('notice',$notice);
        $this->assign('meeting',$meeting);
        $this->assign('party',$party);
        $this->assign('planing',$planing);
        $this->assign('activity',$activity);
        return $this ->fetch();
    }
    /**
     * 通知类  更多页面
     */
    public function noticemore(){
        $type = input('get.type/d');
        if (!in_array($type,[1,4])){
            return $this->error('系统参数错误',Url('Organization/index'));
        }
        $Notice = new Notice();
        $list = $Notice->get_list(['type' => $type,'status' => ['egt',1]],0);
        $this->assign('list',$list);
        $this->assign('type',$type);
        return $this->fetch();
    }
    /**
     * 情况类  更多页面
     */
    public function meetingmore(){
        $type = input('get.type/d');
        if (!in_array($type,[2,3,5])){
            return $this->error('系统参数错误',Url('Organization/index'));
        }
        $Notice = new Notice();
        $list = $Notice->get_list(['type' => $type,'status' => ['egt',1]],0);
        $this->assign('list',$list);
        $this->assign('type',$type);
        return $this->fetch();
    }
    /**
     * 通知  情况  加载更多
     */
    public function more(){
        $type = input('post.type/d');
        $len = input('post.length/d');
        $Notice = new Notice();
        $list = $Notice->get_list(['type' => $type,'status' => ['egt',1]],$len);
        return $this->success('加载成功','',$list);
    }
    /**
     * 通知类 详情
     */
    public function noticedetail(){
        $this->jssdk();
        $id = input('id');
        if (empty($id)){
            $this ->error('参数错误!');
        }
        $this->assign('detail',$this->content(4,$id));
        return $this->fetch();
    }
    /**
     * 情况类  详情
     */
    public function meetingdetail(){
        $this->jssdk();
        $id = input('id');
        if (empty($id)){
            $this ->error('参数错误!');
        }
        $this->assign('detail',$this->content(4,$id));
        return $this->fetch();
    }

}