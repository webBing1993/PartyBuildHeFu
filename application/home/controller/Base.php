<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2016/4/21
 * Time: 15:58
 */

namespace app\home\controller;

use app\home\model\Browse;
use app\home\model\Comment;
use app\home\model\Like;
use app\user\model\WechatUser;
use think\Config;
use think\Controller;
use com\wechat\TPQYWechat;
use think\Db;

class Base extends Controller {
    /**
     * 默认图片
     * $front_pic 封面图片id：1-10
     * $list_pic 列表图片id：35-44
     * $carousel_pic 轮播图片id: 45-54
     */
    public function default_pic(){
        //随机轮播图
        $c = array('1'=>'a','2'=>'b','3'=>'c','4'=>'d','5'=>'e','6'=>'f','7'=>'g','8'=>'h','9'=>'i','10'=>'j','11'=>'k','12'=>'l','13'=>'m','14'=>'n','15'=>'o',
            '16'=>'p','17'=>'q','18'=>'r','19'=>'s','20'=>'t','21'=>'u','22'=>'v','23'=>'w','24'=>'x','25'=>'y','26'=>'z');
        $carousel_pic1 = array_rand($c,1);
        $this->assign('p1',$carousel_pic1);
        $carousel_pic2 = array_rand($c,1);
        $this->assign('p2',$carousel_pic2);
        $carousel_pic3 = array_rand($c,1);
        $this->assign('p3',$carousel_pic3);

    }
}