<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/1/3
 * Time: 14:00
 */

namespace app\home\controller;
use app\home\model\Comment;
use app\home\model\Like;
use app\home\model\Picture;
use app\home\model\Redbook;
use app\home\model\RedbookRead;
use app\home\model\Redfilm;
use app\home\model\Redmusic;
use app\home\model\Redremark;
use app\home\model\WechatUser;
use app\home\model\Browse;
use think\Db;
/**
 * Class Redcollection
 * @package app\home\controller
 * 红色珍藏
 */
class Redcollection extends Base {
    /**
     * 红色珍藏首页
     */
    public function index(){

        return $this ->fetch();
    }
    /**
     * 红色电影
     */
    public function redfilm() {

        return $this->fetch();
    }

    /**
     * 经典电影更多
     */
    public function morefilm() {

        return $this->fetch();
    }

    /**
     * 电影详情
     */
    public function filmdetail() {

        return $this->fetch();
    }

    /**
     * 电影搜索
     */
    public function filmserch() {
        $val = input('val');
        if($val) {
            $map = array(
                'title' => array('like','%'.$val.'%'),
                'status' => 1,
            );
            $filmModel = new Redfilm();
            $list = $filmModel->where($map)->order('create_time desc')->column('id,title');
            if($list) {
                return $this->success("查询成功","",$list);
            }else{
                return $this->error("未查询到数据");
            }
        }else {
            return $this->error("查询条件不能为空");
        }
    }

    /**
     * 红色音乐
     */
    public function redmusic() {

        return $this->fetch();
    }

    /**
     * 音乐详情
     */
    public function musicdetail() {

        return $this->fetch();
    }

    /**
     * 加载更多音乐
     */
    public function moremusic() {
        $len = input('length');
        $musicModel = new Redmusic();
        $map = array(
            'status' => 1,
        );
        $list = $musicModel->where($map)->order('create_time desc')->limit($len,5)->select();
        if($list) {
            foreach ($list as $value) {
                $img = Picture::get($value['front_cover']);
                $value['path'] = $img['path'];
                $value['time'] = date("Y-m-d",$value['create_time']);
            }
            return $this->success("加载成功","",$list);
        }else{
            return $this->error("加载失败");
        }
    }

    /**
     * 红色文学
     */
    public function redliterature() {

        return $this->fetch();
    }

    /**
     * 书籍详情
     */
    public function bookdetail() {

        return $this->fetch();
    }

    /**
     * 书籍搜索
     */
    public function booksearch() {
        $val = input('val');
        if($val) {
            $map = array(
                'title' => array('like','%'.$val.'%'),
                'status' => 1,
            );
            $map2 = array(
                'name' => array('like','%'.$val.'%'),
            );
            $bookModel = new Redbook();
            $list = $bookModel->where($map)->whereOr($map2)->order('create_time desc')->column('id,title');
            if($list) {
                return $this->success("查询成功","",$list);
            }else{
                return $this->error("未查询到数据");
            }
        }else {
            return $this->error("查询条件不能为空");
        }
    }

    /**
     * 是否读过
     */
    public function is_read() {
        $userId = session('userId');
        $id = input('id');
        $readModel = new RedbookRead();
        $data = array(
            'create_user' => $userId,
            'book_id' => $id,
        );
        $info = $readModel->where($data)->find();
        if(empty($info)) {
            $model = $readModel->create($data);
            if($model) {
                $map['have_read'] = array('exp','`have_read`+1');
                Redbook::where('id',$id)->update($map);
                return $this->success("成功读过此书");
            }else{
                return $this->error("新增失败");
            }
        }else{
            return $this->error("该数据已存在");
        }
    }

    /**
     * 语录详情
     */
    public function quotationdetail() {

        return $this->fetch();
    }

}