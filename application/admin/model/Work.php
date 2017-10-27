<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/7/4
 * Time: 16:30
 */

namespace app\admin\model;


class Work extends Base { 
    protected $insert = [
        'views' => 0,
        'likes' => 0,
        'comments' => 0,
        'create_time' =>  NOW_TIME,
    ];
}