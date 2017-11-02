<?php
/**
 * Created by PhpStorm.
 * User: stiff <1570004138@163.com>
 * Date: 2017/6/20
 * Time: 15:50
 */
namespace app\home\controller;
use app\home\model\Style as StyleModel;
// 党员风采
class Style extends Base {
    /**
     * 党员风采首页
     * @return mixed
     */
    public function index() {
        $Model = new StyleModel;
        $list = $Model->getIndexList();
        $this->assign('list',$list);
        
        return $this ->fetch();
    }

    /**
     * 党员风采详情页
     */
    public function detail() {
        $this->jssdk();
        $id = input('id');
        if (empty($id)){
            $this ->error('参数错误!');
        }
        $detail = $this->content(5,$id);
        $this->assign('detail',$detail);
        
        return $this ->fetch();
    }

    /**
     * 加载更多
     */
    public function more() {
        $len = input('length');
        $Model = new StyleModel;
        $res = $Model->getIndexList($len);
        if($res) {
            return $this->success("加载成功","",$res);
        }else {
            return $this->error("加载失败");
        }
    }


}