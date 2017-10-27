<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/7/6
 * Time: 14:19
 */

namespace app\admin\validate;


use think\Validate;

class Work extends Validate {
    protected $rule = [
        'front_cover' => 'require',
        'type' => 'require',
        'title' => 'require',
        'publisher' => 'require',
        'content' => 'require',
    ];

    protected $message = [
        'front_cover' => '封面图片不能为空',
        'type' => '类型不能为空',
        'title' =>  '标题不能为空',
        'content'  =>  '内容不能为空',
        'publisher' => '发布者不能为空',
    ];
}