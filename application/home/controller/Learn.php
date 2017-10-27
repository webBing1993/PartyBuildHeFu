<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 上午 10:26
 */

namespace app\home\controller;


/*
 * 小镇概况
 */
class Learn extends Base {
    //两学一做首页
    public function index(){

        return $this->fetch();

    }


    //党章主页
    public function chapter(){

        return $this->fetch();

    }
}