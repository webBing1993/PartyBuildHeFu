<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 下午 4:17
 */

namespace app\home\controller;


/*
 * 组织建设
 */
class Organization extends Base {
    //组织建设首页
    public function index(){

        return $this->fetch();

    }
}