<?php
/**
 * Created by PhpStorm.
 * User: laowang <958364865@qq.com>
 * Date: 2017/10/30
 * Time: 9:15
 */

namespace app\home\model;

use think\Model;

/**
 * Class Policy
 * @package app\home\model 最多跑一次
 */
class Policy extends Model
{
    // 获取列表
    public function get_list($where,$len=0){
        $list = $this->where($where)->order('create_time desc')->limit($len,7)->select();
        foreach($list as $value){
            $value['create_time'] = date('Y-m-d',$value['create_time']);
        }
        return $list;
    }
}