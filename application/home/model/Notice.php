<?php
/**
 * Created by PhpStorm.
 * User: laowang <958364865@qq.com>
 * Date: 2017/10/31
 * Time: 14:30
 */

namespace app\home\model;
use think\Model;

/**
 * Class Notice
 * @package app\home\model 组织建设 模型类
 */ 
class Notice extends Model
{
    /**
     * 获取数据
     */
    public function get_list($where,$len=0,$rec=false){
        if ($rec){
            // 推荐
            $num = 2;
        }else{
            // 不推荐
            $num = 10;
        }
        $list = $this->where($where)->order('create_time desc')->limit($len,$num)->select();
        foreach($list as $value){
            if (!empty($value['front_cover'])){
                $value['front_cover'] = Picture::where('id',$value['front_cover'])->value('path');
            }
            $value['create_time'] = date('Y-m-d',$value['create_time']);
        }
        return $list;
    }
}