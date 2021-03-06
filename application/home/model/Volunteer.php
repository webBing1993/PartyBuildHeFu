<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/11/1
 * Time: 16:08
 */

namespace app\home\model;


use think\Model;

class Volunteer extends Model {
    /**
     * 获取主页列表
     */
    public function getIndexList($len = 0) {
        $map = array(
            'status' => 1
        );
        $order = array("create_time desc");
        $res = $this->where($map)->order($order)->limit($len,6)->select();
        foreach ($res as $value) {
            $path = Picture::get($value['front_cover']);
            $value['path'] = $path['path'];
        }
        return $res;
    }

  
}