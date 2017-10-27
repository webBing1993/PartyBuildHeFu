<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/7/7
 * Time: 18:01
 */

namespace app\admin\validate;


use think\Validate;

class Policy extends Validate {
    protected $rule = [
        'title' => 'require',
        'content' => 'require',
        'publisher' => 'require',
    ];

    protected $message = [
        'title' =>  '标题不能为空',
        'content'  =>  '内容不能为空',
        'publisher' => '发布者不能为空',
    ];
}