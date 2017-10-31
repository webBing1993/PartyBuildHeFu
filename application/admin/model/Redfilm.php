<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/1/4
 * Time: 10:28
 */

namespace app\admin\model;


use think\Model;

class Redfilm extends Base {
    protected $insert = [
        'create_time' => NOW_TIME,
        'comments' => 0,
        'likes' => 0,
        'views' => 0,
        'status' => 1,
    ];

}