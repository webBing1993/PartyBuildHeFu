<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/26 0026
 * Time: 下午 5:09
 */

namespace app\home\controller;



/*
 * 小镇概况
 */
class Profile extends Base {
   //小镇概况首页
    public function index(){

        return $this->fetch();

    }


    //第一聚焦&最多跑一次详情页
    public function detail(){

        return $this->fetch();

    }
}