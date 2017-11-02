<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/11/1
 * Time: 16:28
 */

namespace app\home\model;


use think\Model;

class VolunteerDetail extends Model {
    /**
     * 获取团队风采列表
     */
    public function getRecruitList($pid) {
        $map = array(
            'status' => 1,
            'pid' => $pid,
        );
        $order = array("create_time desc");
        $top = $this->where($map)->order($order)->limit(3)->select();
        $list = $this->where($map)->order($order)->limit(3,7)->select();
        $data = array(
            'top' => $top,
            'list' => $list
        );
        return $data;
    }

    /**
     * 加载更多
     */
    public function getMoreList($pid,$len=0) {
        $map = array(
            'status' => 1,
            'pid' => $pid,
        );
        $order = array("create_time desc");
        $length = $len + 3;
        $res = $this->where($map)->order($order)->limit($length,7)->select();
        foreach ($res as $value) {
            $path = Picture::get($value['front_cover']);
            $value['path'] = $path['path'];
            $value['time'] = date("Y-m-d",$value['create_time']);
        }
        return $res;
    }
}