<?php
/**
 * Created by PhpStorm.
 * User: laowang <958364865@qq.com>
 * Date: 2017/10/30
 * Time: 16:58
 */

namespace app\home\model;
use think\Model;

/**
 * Class Answer
 * @package app\home\model 在线答题
 */
class Answer extends Model
{
    protected $insert = [
        'create_time' => NOW_TIME
    ];
}