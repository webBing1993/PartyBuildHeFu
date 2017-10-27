<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/10/27
 * Time: 15:45
 */

namespace app\admin\model;


class Style extends Base {
    protected $insert = [
        'status' => 1,
        'views' => 0,
        'likes' => 0,
        'comments' => 0,
        'create_time' => NOW_TIME,
    ];

}