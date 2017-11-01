<?php
/**
 * Created by PhpStorm.
 * User: stiff <1570004138@163.com>
 * Date: 2017/6/20
 * Time: 15:50
 */
namespace app\home\controller;
use app\home\model\Pioneer as PioneerModel;
use app\home\model\Browse;
use app\home\model\Comment;
use app\home\model\Like;
use app\home\model\Picture;
use app\home\model\WechatUser;
// 党员风采
class Style extends Base {
    /**
     * 党员风采详情页
     */
    public function detail()
    {

        return $this ->fetch();

    }


    /**
     * 党员风采首页
     * @return mixed
     */
    public function index(){

        return $this ->fetch();
    }

}