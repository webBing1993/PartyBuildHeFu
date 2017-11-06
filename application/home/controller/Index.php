<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2016/4/20
 * Time: 13:47
 */

namespace app\home\controller;
use app\home\model\Learn;
use app\home\model\Notice;
use app\home\model\Picture;
use app\home\model\Work;
use think\Controller;

/**
 * 党建主页
 */
class Index extends Controller {
    public function index(){
        $map = array(
            'status' => 1,
            'recommend' => 1,
        );
        $order = array('create_time desc');
        $field = array("id,type,front_cover,title,publisher,create_time");
        $learn = Learn::where($map)->order($order)->field($field)->limit(3)->select();
        foreach ($learn as $value) {
            $value['class'] = 1;
            $value['class_name'] = "两学一做";
        }
        $notice = Notice::where($map)->order($order)->field($field)->limit(3)->select();
        foreach ($notice as $value) {
            $value['class'] = 2;
            $value['class_name'] = "组织建设";
        }
        $work = Work::where($map)->order($order)->field($field)->limit(3)->select();
        foreach ($work as $value) {
            $value['class'] = 3;
            $value['class_name'] = "小镇动态";
        }
        $total = array_merge((array)$learn,(array)$notice,(array)$work); //合并
        $list = object2array($total); //对象转数组
        $sort = array(  //按照时间戳倒序
            'direction' => 'SORT_DESC',
            'field' => 'create_time',
        );
        $arrSort = array();
        foreach ($list as $k => $v){
            foreach ($v as $key => $value){
                $arrSort[$key][$k] = $value;
            }
        }
        if($sort['direction'] && $arrSort){
            array_multisort($arrSort[$sort['field']],constant($sort['direction']),$list);
        }
        $this->assign('list',$list);
        return $this->fetch();
    }

    /**
     * 加载更多
     */
    public function more() {
        $data = input('post.');
        $map = array(
            'status' => 1,
            'recommend' => 1,
        );
        $order = array('create_time desc');
        $field = array("id,type,front_cover,title,publisher,create_time");
        $learn = Learn::where($map)->order($order)->field($field)->limit($data['p1'],3)->select();
        foreach ($learn as $value) {
            $path = Picture::get($value['front_cover']);
            $value['path'] = $path['path'];
            $value['time'] = date("Y-m-d",$value['create_time']);
            $value['class'] = 1;
            $value['class_name'] = "两学一做";
        }
        $notice = Notice::where($map)->order($order)->field($field)->limit($data['p2'],3)->select();
        foreach ($notice as $value) {
            $path = Picture::get($value['front_cover']);
            $value['path'] = $path['path'];
            $value['time'] = date("Y-m-d",$value['create_time']);
            $value['class'] = 2;
            $value['class_name'] = "组织建设";
        }
        $work = Work::where($map)->order($order)->field($field)->limit($data['p3'],3)->select();
        foreach ($work as $value) {
            $path = Picture::get($value['front_cover']);
            $value['path'] = $path['path'];
            $value['time'] = date("Y-m-d",$value['create_time']);
            $value['class'] = 3;
            $value['class_name'] = "小镇动态";
        }
        $total = array_merge((array)$learn,(array)$notice,(array)$work); //合并
        $list = object2array($total); //对象转数组
        $sort = array(  //按照时间戳倒序
            'direction' => 'SORT_DESC',
            'field' => 'create_time',
        );
        $arrSort = array();
        foreach ($list as $k => $v){
            foreach ($v as $key => $value){
                $arrSort[$key][$k] = $value;
            }
        }
        if($sort['direction'] && $arrSort){
            array_multisort($arrSort[$sort['field']],constant($sort['direction']),$list);
        }
        if($list) {
            return $this->success("加载成功","",$list);
        }else {
            return $this->error("加载失败");
        }
    }
}