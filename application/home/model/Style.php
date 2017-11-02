<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/11/1
 * Time: 14:41
 */

namespace app\home\model;


use think\Model;

class Style extends Model {
    /**
     * 获取主页/加载更多
     */
    public function getIndexList($len = 0) {
        $map = array(
            'status' => 1
        );
        $order = array("create_time desc");
        $field = array("id,front_cover,name,position");
        $res = $this->where($map)->order($order)->field($field)->limit($len,8)->select();
        return $res;
    }
    
}