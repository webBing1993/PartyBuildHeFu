<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2016/4/21
 * Time: 15:58
 */

namespace app\home\controller;
use think\Config;
use think\Controller;
use com\wechat\TPWechat;
use app\home\model\Picture;
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
    /**
     * 获取公众号签名
     */
    public function jssdk(){
        $Wechat = new TPWechat(Config::get('party'));
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $jsSign = $Wechat->getJsSign($url);
        $this->assign("jsSign", $jsSign);
    }
    /**
     * 获取数据详情 ，$type,$id
     * type值：
     * 1 work 第一聚焦
     * 2 policy 最多跑一次
     * 3 learn  两学一做
     */
    public function content($type,$id){
        switch ($type) {    //根据类别获取表明
            case 1:
                $table = "work";
                break;
            case 2:
                $table = "policy";
                break;
            case 3:
                $table = "learn";
                break;
            default:
                return $this->error("无该数据表");
                break;
        }
        //基本信息
        $list = Db::name($table)->find(['id' => $id]);
        if (empty($list)){
            $this ->error('该内容不存在或已删除!');
        }
        //浏览加一
        Db::name($table)->where('id',$id)->setInc('views');
        //分享图片及链接及描述
        if (isset($list['front_cover'])){ // 封面图
            if (empty($list['front_cover'])){
                $list['share_image'] = '/home/images/common/1.jpg';  // 默认
            }else{
                $image = Picture::where('id',$list['front_cover'])->find();
                $list['share_image'] = "http://".$_SERVER['SERVER_NAME'].$image['path'];
            }
        }else{
            $list['share_image'] = '/home/images/common/1.jpg';  // 默认
        }
        if (isset($list['description'])){
            if (empty($list['description'])){
                $list['desc'] = str_replace('&nbsp;','',strip_tags($list['content']));
            }else{
                $list['desc'] = $list['description'];
            }
        }else{
            $list['desc'] = str_replace('&nbsp;','',strip_tags($list['content']));
        }
        $list['link'] = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REDIRECT_URL'];
        return $list;
    }
}