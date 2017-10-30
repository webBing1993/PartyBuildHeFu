<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 上午 10:26
 */

namespace app\home\controller;
use app\home\model\Constitution;
use app\home\model\Learn as LearnModel;
/*
 * 小镇概况
 */
class Learn extends Base {
    //两学一做首页
    public function index(){
        //主页信息
        // 手机党校
        $Learn = new LearnModel();
        $map = array(
            'recommend' => 1,
            'status' => ['egt',1]
        );
        $top = $Learn->get_list($map,0,true);
        $info = $Learn->get_list(['status' => ['egt',1]],0);
        $this->assign('top',$top);
        $this->assign('info',$info);
        // 党章 
        $list = Constitution::all();
        $this->assign('list',$list);
        return $this->fetch();

    }
    // 手机党校 加载更多
    public function more(){
        $len = input('post.length');
        $Learn = new LearnModel();
        $list =  $Learn->get_list(['status' => ['egt',1]],$len);
        return $this->success('加载成功','',$list);
    }

    //党章主页
    public function chapter(){
        $id = input('id/d');
        //党章内容
        $msg = Constitution::get($id);
        switch ($msg['id']){
            case 1:
                $msg['title'] = "第一章 总 纲";
                break;
            case 2:
                $msg['title'] = "第二章 党 员";
                break;
            case 3:
                $msg['title'] = "第三章 党的组织制度";
                break;
            case 4:
                $msg['title'] = "第四章 党的中央组织";
                break;
            case 5:
                $msg['title'] = "第五章 党的地方组织";
                break;
            case 6:
                $msg['title'] = "第六章 党的基层组织";
                break;
            case 7:
                $msg['title'] = "第七章 党的干部";
                break;
            case 8:
                $msg['title'] = "第八章 党的纪律";
                break;
            case 9:
                $msg['title'] = "第九章 党的纪律检查机关";
                break;
            case 10:
                $msg['title'] = "第十章 党 组";
                break;
            case 11:
                $msg['title'] = "第十一章 党和共产主义青年团的关系";
                break;
            case 12:
                $msg['title'] = "第十二章 党徽党旗";
                break;
        }
        $this->assign('msg',$msg);
        return $this->fetch();
    }
    /**
     * 视频课程
     */
    public function video(){
        $this->jssdk();
        $id = input('id');
        if (empty($id)){
            $this ->error('参数错误!');
        }
        $this->assign('detail',$this->content(3,$id));
        return $this->fetch();
    }

    /**
     * 图文课程
     */
    public function article(){
        $this->jssdk();
        $id = input('id');
        if (empty($id)){
            $this ->error('参数错误!');
        }
        $this->assign('detail',$this->content(3,$id));
        return $this->fetch();
    }
}