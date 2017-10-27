<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27
 * Time: 11:02
 */
namespace app\home\controller;
use app\home\model\Picture;
use app\home\model\VolunteerRecruit;
use app\home\model\VolunteerRecruitReceive;
use app\home\model\WechatUser;


class Volunteer extends Base{

    /*
     *  团队风采
     * */
    public function recruit(){

        return $this->fetch();
    }

    /*
     *  详情
     * */
    public function detail(){

        return $this->fetch();
    }


}