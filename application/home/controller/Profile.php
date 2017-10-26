<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/26 0026
 * Time: 下午 5:09
 */

namespace app\home\controller;



//小镇概况
class Profile extends Base {

    public function index(){

        return $this->fetch();

    }
}