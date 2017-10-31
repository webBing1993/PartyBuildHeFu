<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/10/31
 * Time: 10:07
 */

namespace app\admin\model;


use think\Model;

class VolunteerDetail extends Base {
    protected $insert = [
        'create_time' => NOW_TIME,
        'views' => 0,
        'likes' => 0,
        'comments' => 0,
        'status' => 1,
    ];
}