<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2016/10/12
 * Time: 10:23
 */

namespace app\home\model;


use think\Model;

class Learn extends Model {
    /**
     * 获取数据
     */
    public function get_list($where,$len=0,$rec=false){
        if ($rec){
            // 推荐
            $num = 3;
        }else{
            // 不推荐
            $num = 7;
        }
        $list = $this->where($where)->order('create_time desc')->limit($len,$num)->select();
        foreach($list as $value){
            $value['front_cover'] = Picture::where('id',$value['front_cover'])->value('path');
            $value['create_time'] = date('Y-m-d',$value['create_time']);
        }
        return $list;
    }
    /**
     * 首页获取推荐的数据
     * @param $length
     * @param string $push 推送数据获取
     */
    public function getDataList($length,$push=0){
        $map = array(
            'status' => ['egt',0],
            'recommend' => 1,
            'push' => ['egt',$push]
        );
        $order = 'create_time desc';
        $limit = "$length,2";
        $list = $this ->where($map) ->order($order) ->limit($limit) ->select();
        if(!empty($list))
        {
            return $list[0] ->data;
        }else{
            return $list;
        }
    }
}