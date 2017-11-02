<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27
 * Time: 11:02
 */
namespace app\home\controller;
use app\home\model\Volunteer as VolunteerModel;
use app\home\model\VolunteerDetail;


class Volunteer extends Base{

    /*
     *  志愿服务
     * */
    public function index(){
        $Model = new VolunteerModel();
        $list = $Model->getIndexList();
        $this->assign('list',$list);
        return $this->fetch();
    }
    
    /*
     *  团队介绍
     * */
    public function team(){
        $id = input('id');
        $Model = new VolunteerModel();
        $detail = $Model->get($id);
        $this->assign('detail',$detail);
        return $this->fetch();
    }
    
    /*
     *  团队风采
     * */
    public function recruit(){
        $Model = new VolunteerDetail();
        $pid = input('pid');
        $list = $Model->getRecruitList($pid);
        $this->assign('list',$list);
        return $this->fetch();
    }

    /*
     *  详情
     * */
    public function detail(){
        $this->jssdk();
        $id = input('id');
        if (empty($id)){
            $this ->error('参数错误!');
        }
        $detail = $this->content(6,$id);
        $this->assign('detail',$detail);

        return $this ->fetch();
    }
    
    /**
     * 加载更多
     */
    public function more() {
        $Model = new VolunteerDetail();
        $data = input('post.');
        $res = $Model->getRecruitList($data['pid'],$data['lenth']);
        if($res) {
            return $this->success("加载成功","",$res);
        }else {
            return $this->error("加载失败");
        }
    }


}