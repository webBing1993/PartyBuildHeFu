<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/10/27
 * Time: 15:48
 */

namespace app\admin\validate;


use think\Validate;

class Style extends Validate {
    protected $rule = [
        'front_cover' => 'require',
        'name' => 'require',
        'position' => 'require',
        'introduction' => 'require',
        'document' => 'require',
        'content' => 'require'
    ];

    protected $message = [
        'front_cover' => '头像不能为空',
        'name' => '姓名不能为空',
        'position' =>  '职位不能为空',
        'introduction'  =>  '简介不能为空',
        'document' => '个人档案不能为空',
        'content' => '先进事迹不能为空',
    ];
}