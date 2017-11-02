<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/1/3
 * Time: 14:00
 */

namespace app\home\controller;

use app\home\model\Picture;
use app\home\model\Redbook;
use app\home\model\Redfilm;
use app\home\model\Redmusic;
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
        $Model = new Redfilm();
        $list = $Model->getIndexList();
        $this->assign('list',$list);
        return $this->fetch();
    }

    /**
     * 经典电影更多
     */
    public function morefilm() {
        $Model = new Redfilm();
        if(IS_POST) {
            //加载更多
            $len = input('length');
            $res = $Model->getMoreList($len);
            if($res) {
                return $this->success("加载成功","",$res);
            }else {
                return $this->error("加载失败");
            }
        }else {
            $list = $Model->getMoreList();
            $this->assign('list',$list);
            return $this->fetch();
        }
    }

    /**
     * 电影详情
     */
    public function filmdetail() {
        $this->jssdk();
        $id = input('id');
        if (empty($id)){
            $this ->error('参数错误!');
        }
        $detail = $this->content(7,$id);
        $this->assign('detail',$detail);
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
        $Model = new Redmusic();
        $list = $Model->getIndexList();
        $this->assign('list',$list);
        return $this->fetch();

    }

    /**
     * 音乐详情
     */
    public function musicdetail() {
        $this->jssdk();
        $id = input('id');
        if (empty($id)){
            $this ->error('参数错误!');
        }
        $detail = $this->content(8,$id);
        $this->assign('detail',$detail);
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
        $list = $musicModel->where($map)->order('create_time desc')->limit($len,8)->select();
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
        $Model = new Redbook();
        if(IS_POST) {
            $len = input('length');
            $res = $Model->getIndexList($len);
            if($res) {
                return $this->success("加载成功","",$res);
            }else {
                return $this->error("加载失败");
            }
        }else {
            $list = $Model->getIndexList();
            $this->assign('list',$list);
            return $this->fetch(); 
        }
    }

    /**
     * 书籍详情
     */
    public function bookdetail() {
        $Model = new Redbook();
        $id = input('id');
        if (empty($id)){
            $this ->error('参数错误!');
        }
        $Model->where('id',$id)->setInc('views');
        $detail = $Model->get($id);
        $this->assign('detail',$detail);
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
        $id = input('id');
        $res = Redbook::where('id',$id)->setInc('have_read');
        if($res){
            return $this->success("成功读过此书");
        }else{
            return $this->error("新增失败");
        }
    }

}