<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/26 0026
 * Time: 下午 5:09
 */

namespace app\home\controller;
use app\home\model\Work as WorkModel;
use app\home\model\Policy;
/*
 * 小镇概况
 */
class Profile extends Base {
   //小镇概况首页
    public function index(){
        $Work = new WorkModel();
        $Policy = new Policy();
        // 第一聚焦  推荐
        $map = array(
            'recommend' => 1,
            'status' => ['egt',1]
        );
        // 第一聚焦 列表
        $maps = array(
            'status' => ['egt',1]
        );
        // 最多跑一次  列表
        $lists = $Policy->get_list($maps);
        $top = $Work->get_list($map,0,true);
        $list = $Work->get_list($maps,0);
        $this->assign('top',$top);
        $this->assign('list',$list);
        $this->assign('lists',$lists);
        return $this->fetch();

    }
    // 下拉加载
    public function more(){
        $type = input('post.type');
        $len = input('post.length');
        $Work = new WorkModel();
        $Policy = new Policy();
        if ($type == 1){
           // 第一聚焦
            $list = $Work->get_list(['status' => ['egt',1]],$len);
        }else{
            // 最多跑一次
            $list = $Policy->get_list(['status' => ['egt',1]],$len);
        }
        return $this->success('加载成功','',$list);
    }
    //第一聚焦&最多跑一次详情页
    public function detail(){
        $type = input('get.type/d');
        $id = input('get.id/d');
        $this->jssdk();
        if ($type == 1){
            // 第一聚焦
            $info = $this->content(1,$id);
        }else{
            // 最多跑一次
            $info = $this->content(2,$id);
        }
        $this->assign('detail',$info);
        return $this->fetch();

    }
}