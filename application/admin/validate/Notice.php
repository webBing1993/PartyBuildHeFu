<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2016/10/9
 * Time: 16:09
 */

namespace app\admin\validate;


use think\Validate;

class Notice extends Validate {
    protected $rule = [
        'front_cover' => 'require',
        'title' => 'require',
        'description' => 'require',
        'telephone' => 'require',
        'address' => 'require',
        'publisher' => 'require',
        'content' => 'require',
    ];

    protected $message = [
        'title.require' => '标题不能为空',
        'front_cover.require' => '封面图片不能为空',
        'description.require' => '简介不能为空',
        'content.require' => '内容不能为空',
        'telephone.require' => '联系电话不能为空',
        'address.require' => '地址不能为空',
        'publisher.require' => '发布人不能为空',
    ];

    protected $scene = [
        'act' => ['front_cover','title','description','content','address','telephone','publisher'],
        'other' => ['front_cover','title','content','publisher'],
    ];

}