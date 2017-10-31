<?php
/**
 * Created by PhpStorm.
 * User: Lxx<779219930@qq.com>
 * Date: 2017/10/31
 * Time: 10:06
 */

namespace app\admin\validate;


use think\Validate;

class Volunteer extends Validate {
    protected $rule = [
        'front_cover' => 'require',
        'title' => 'require',
        'name' => 'require',
        'content' => 'require',
        'publisher' => 'require',
    ];

    protected $message = [
        'name.require' => '团队名称不能为空',
        'title.require' => '标题不能为空',
        'front_cover.require' => '封面图片不能为空',
        'content.require' => '内容不能为空',
        'publisher.require' => '发布人不能为空',
    ];

    protected $scene = [
        'index' => ['front_cover','name','content'],
        'detail' => ['front_cover','title','content','publisher'],
    ];

}