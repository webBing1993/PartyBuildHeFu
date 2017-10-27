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
class Pioneer extends Base {
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

    /**
     * 判断今日导师点赞
     * @param $data
     * @return mixed
     */
    public function checkLIke($data){
        //获取点赞
        $userId = session('userId');
        $likeModel = new Like;
        foreach($data as $v)
        {
            $like = $likeModel ->checkLike(5,$v['id'],$userId);
            $v['is_like'] = $like;
        }
        return $data;
    }

    /**
     * 导师点赞
     * @return array|void
     */
    public function like()
    {
        $data = input('post.');
        $like = new Like();
        $uid = session('userId');
        $dateStr = date('Y-m-d', time());
        //获取当天0点的时间戳
        $timestamp0 = strtotime($dateStr);
        $map = array(
            'create_time' => ['egt', $timestamp0],
            'type' => 5,
            'aid' => $data['aid'],
            'uid' => $uid
        );
        $res = $like->where($map)->find();
        //今日已点赞
        if (!empty($res)) {
            return $this->error('今日已点赞!');
        } else {
            $data['table'] = 'pioneer';
            $data['uid'] = $uid;
            $res = $like->data($data)->save();
            //点赞成功积分+1
            if ($res) {
                //判断今日积分是否超出
                $check = $this ->score_up();
                if($check){
                    WechatUser::where('userid', $uid)->setInc('score', 1);
                }
                PioneerModel::where('id', $data['aid'])->setInc('likes', 1);
                return $this->success("点赞成功");
            } else {
                return $this->error("点赞失败!");
            }
        }
    }
        /**
         * 加载更多
         * @return array|void
         */
        public function moreList()
        {
            $len = input("length");
            $news = new PioneerModel();
            $map = array('status' => ['egt',0],'type' => 3);
            $order = 'create_time desc';
            $list = $news ->where($map) ->order($order) ->limit($len,5) ->select();
            //图片跟时间戳转化
            foreach($list as $value){
                $img = Picture::get($value['front_cover']);
                $value['path'] = $img['path'];
                $value['time'] = date("Y-m-d",$value['create_time']);
            }
            if(!empty($list))
            {
                return $this->success("加载成功",Null,$list);
            }else {
                return $this->error("加载失败");
            }
        }
}