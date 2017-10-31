<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/10/31
 * Time: 10:06
 */

namespace app\admin\model;


class Volunteer extends Base {
    protected $insert = [
        'create_time' => NOW_TIME,
        'times' => 0,
        'status' => 1,
    ];

}