<?php
/**
 * Created by PhpStorm.
 * User: stiff <1570004138@163.com>
 * Date: 2017/6/8
 * Time: 15:28
 */
namespace app\home\controller;
use think\Controller;
use com\wechat\TPWechat;
use think\Config;
use app\home\model\Learn;
use app\home\model\Notice;
use app\home\model\Volunteer;
use app\home\model\Picture;

class Push extends Controller{
    /**
     * 订阅号每日定时推送
     */
    public function cron(){
        $Wechat = new TPWechat(Config::get('party'));
        $author = '和孚镇党建';//推送作者
        $request = 'http://hfz.0571ztnet.com';//域名
        //获取需要推送的数据
        $list = $this ->pushList();
        //没有需要推送的消息,就只推每日一课
        if(!empty($list)){
            //先上传素材 media_id
            foreach($list as $k => $v){
                //class 1 组织建设  2两学一做 3  志愿服务
                $class = $v['class'];
                $data = array(
                    "media" => '@.'.$v['img']
                );
                $img = $Wechat ->uploadForeverMedia($data,'thumb');
                $v['thumb_media_id'] = $img['media_id'];
                $id = $v['id'];
                if($class == 1)
                {
                    switch ($v['type']){
                        case 1: // 相关通知
                        case 4: // 志愿招募
                        $link = 'Organization/noticedetail';
                            break;
                        case 2:  // 会议情况
                        case 3:  // 党课情况
                        case 5:  // 活动情况
                        $link = 'Organization/meetingdetail';
                            break;
                    }
                } else if($class == 2){
                    switch($v['type']){
                        case 1:
                            $link = 'learn/video';
                            break;
                        case 2:
                            $link = 'learn/article';
                            break;
                    }
                }else if($class == 3){
                    $link = 'Volunteer/detail';
                }
                $v['content_source_url'] = "$request/home/$link/id/$id";
            }
            //图文素材列表
            $article = array();
            foreach ($list as $k =>$v ){
                $article['articles'][$k] = [
                    'thumb_media_id' => $v['thumb_media_id'],
                    'author' => $v['publisher'],
                    'title' => $v['title'],
                    'content_source_url' => $v['content_source_url'],
                    "content" => $v['content'],
                    "digest" => $v['title'],
                    "show_cover_pic" => 0,
                ];
            }
            //最后一条加入每日一课
//            $article['articles'][count($article['articles'])] = [
//                    'thumb_media_id' => $image_id,
//                    'author' => $author,
//                    'title' =>'每日一课',
//                    'content_source_url' => "$request.$answer",
//                    "content" => "每日一课已经等候你多时了,点阅读全文开始答题!",
//                    "digest" => "休息一下,去答一下题吧",
//                    "show_cover_pic" => 1,
//                ];
            $lists =  $article;
            //上传多条图文素材
            $info = $Wechat ->uploadForeverArticles($lists);
            //消息群发
            $send = [
                "filter" => [
                    "is_to_all" =>true
                ],
                "mpnews" =>[
                    "media_id" => $info['media_id']
                ],
                "msgtype" => "mpnews",
                "send_ignore_reprint" => 0
            ];
            $res = $Wechat ->sendGroupMassMessage($send);
            //发送成功 修改对应数据状态
            if($res['errcode'] == 0){
                return  $this->success('推送成功');
            }
        }
//        //预览图文通知
//        $notice = array(
//            "touser" => $openid,
//            "mpnews" =>[
//                "media_id" => $info['media_id']
//            ],
//            "msgtype" => "mpnews"
//        );
//        $info = $Wechat ->previewMassMessage($notice);
//        dump( $Wechat->errMsg);
        //上传图文消息素材
//        $article = array(
//            "articles" => [
//                [
//                    'thumb_media_id' => $image_id,
//                    'author' => $author,
//                    'title' =>'每日一课',
//                    'content_source_url' => "$request.$answer",
//                    "content" => "每日一课已经等候你多时了,点阅读全文开始答题!",
//                    "digest" => "休息一下,去答一下题吧",
//                    "show_cover_pic" => 1,
//                ]
//            ]
//        );
//        $info = $Wechat ->uploadForeverArticles($article);
    }
    /**
     * 获取待推送的8条数据
     * @return array
     */
    public function pushList(){
        $count = 6; //总数据数量
        $count1 = 0;  //从第几条开始取数据
        $count2 = 0;
        $count3 = 0;
        $news = new Notice();  // 组织建设
        $learn = new Learn();  // 两学一做
        $volunteer  = new Volunteer();
        $news_check = false; //新闻数据状态 true为取空
        $learn_check = false;
        $volunteer_check = false;

        $all_list = array();
        //获取数据  取满8条 或者取不出数据退出循环
        while(true)
        {
            // 组织建设
            if(!$news_check &&
                count($all_list) < $count)
            {
                //获取一条数据
                $res = $news->where(['status' => ['egt',1],'push' => 1])->whereTime('create_time','d')->order('id desc')->limit($count1,2)->select();
                if(empty($res))
                {
                    $news_check = true;
                }else {
                    $count1 ++;
                    $all_list = $this ->changeTpye($all_list,$res,1); //给每条数据增加类别判断
                }
            }
            // 两学一做
            if(!$learn_check &&
                count($all_list) < $count)
            {
                $res = $learn ->where(['status' => ['egt',1],'push' => 1])->whereTime('create_time','d')->order('id desc')->limit($count2,2)->select();
                if(empty($res))
                {
                    $learn_check = true;
                }else {
                    $count2 ++;
                    $all_list = $this ->changeTpye($all_list,$res,2);
                }
            }
            // 志愿服务
            if(!$volunteer_check &&
                count($all_list) < $count)
            {
                $res = $volunteer ->where(['status' => ['egt',1],'push' => 1])->whereTime('create_time','d')->order('id desc')->limit($count3,2)->select();
                if(empty($res))
                {
                    $volunteer_check = true;
                }else {
                    $count3 ++;
                    $all_list = $this ->changeTpye($all_list,$res,3);
                }
            }
            if(count($all_list) >= $count ||
                ($news_check && $learn_check && $volunteer_check ))
            {
                break;
            }
        }
        return $all_list;
    }
    /**
     * 进行数据区分
     * @param $list
     * @param $type 1 组织建设 2两学一做 3 志愿服务
     */
    private function changeTpye($all,$list,$type){
        //图片进行转化
        $img = Picture::get($list['front_cover']);
        $list['img'] = $img['path'];
        //增加类别
        $list['class'] = $type;
        array_push($all,$list);
        return $all;
    }
}