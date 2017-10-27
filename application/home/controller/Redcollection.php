<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27
 * Time: 14:55
 */
namespace app\home\controller;
use app\home\model\WechatTest;
use app\home\model\WechatUser;

class Redcollection extends Base{
    /*
     * 红色珍藏主页
     */
    public function index(){
        return $this->fetch();
    }
}