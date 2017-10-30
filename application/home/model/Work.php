<?php
/**
 * Created by PhpStorm.
 * User: laowang <958364865@qq.com>
 * Date: 2017/10/30
 * Time: 9:11
 */

namespace app\home\model;
use app\home\model\Picture;
use think\Model;

/**
 * Class Work
 * @package app\home\model  第一聚焦
 */
class Work extends Model
{
    // 获取列表
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
}