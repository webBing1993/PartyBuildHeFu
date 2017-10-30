<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 上午 10:26
 */

namespace app\home\controller;
use app\home\model\Constitution;
use app\admin\model\Question;
use app\home\model\Learn as LearnModel;
use app\home\model\Answer;
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
    /**
     * 答题页面
     */
    public function answer(){
        //取单选
        $arr=Question::all(['type'=>0]);
        foreach($arr as $value){
            $ids[]=$value->id;
        }
        //获取用户已经得到的题目
        $lists=array();
        //随机获取单选的题目
        $num=20;//题目数目
        $data=array();
        while(true){
            if(count($data)==$num){
                break;
            }
            $index=mt_rand(0,count($ids)-1);
            $res=$ids[$index];
            if(!in_array($res,$data) && !in_array($res,$lists)){
                $data[]=$res;
            }
        }
        foreach($data as $value){
            $question[]=Question::get($value);
        }

        //取多选
        $arr2=Question::all(['type'=>1]);
        foreach($arr2 as $value){
            $ids2[]=$value->id;
        }
        //随机获取多选
        $num2=10;//题目数目
        $data2=array();
        while(true){
            if(count($data2)==$num2){
                break;
            }
            $index2=mt_rand(0,count($ids2)-1);
            $res2=$ids2[$index2];
            if(!in_array($res2,$data2) && !in_array($res2,$lists)){
                $data2[]=$res2;
            }
        }
        foreach($data2 as $value){
            $questions[]=Question::get($value);
        }
        $this->assign('question',$question);
        $this->assign('questions',$questions);
        return $this->fetch();
    }
    /*
     * 用户题目提交
     */
    public function submits(){
        //获取用户提交信息
        $data=input('post.');
        $score=0;
        $num = 0;
        $sum = 0;
        foreach($data['arr'] as $value){
            if ($value != 0){
                $sum ++;
            }
        }
        //判断题目的对错,并改变分数
        foreach($data['arrId'] as $key=>$value){
            $question=Question::get($value);
            if($key <20){
                if($data['arr'][$key]==$question->value){
                    $status[$key]=1;
                    $score++;
                    $num ++;
                }else{
                    $status[$key]=0;
                }
            }else{
                if($data['arr'][$key]===explode(':',$question->value)){
                    $status[$key]=1;
                    $score++;
                    $num ++;
                }else{
                    $status[$key]=0;
                }
            }
        }
        //将获取的数据进行json格式转化
        $questions=json_encode($data['arrId']);
        $rights=json_encode($data['arr']);
        $status=json_encode($status);
        $users= md5(uniqid()); //不重复随机id
        //若该用户不存在则添加数据
        $Answer=new Answer();
        $Answer->userid=$users;
        $Answer->question_id=$questions;
        $Answer->value=$rights;
        $Answer->status=$status;
        $Answer->score=$score;
        $Answer->exist=1;
        if($id = $Answer->save()){
            return $this->success('提交成功','',['score' => $score ,'id' => $id]);
        }else{
            return $this->error('提交失败');
        }
    }
    /*
     * 查看错题
     */
    public function errors(){
        $id = input('id/d');
        $Answer=Answer::get(['id'=>$id]);
        if (empty($Answer)){
            return $this->error('系统参数错误');
        }
        $arr=json_decode($Answer->status,true);
        $lists=json_decode($Answer->question_id,true);
        $rights=json_decode($Answer->value,true);
        foreach($arr as $key=>$value){
            if($value == 0){
                $Question=Question::get($lists[$key]);
                if($key <20 ){
                    $re[$key]=$Question;
                    $right1[$key]=$rights[$key];
                }else{
                    $res[$key]=$Question;
                    $right2[$key]=$rights[$key];
                }
            }
        }
        $this->assign('question',$re);
        $this->assign('questions',$res);
        $this->assign('right1',$right1);
        $this->assign('right2',$right2);
        return $this->fetch();
    }









}



