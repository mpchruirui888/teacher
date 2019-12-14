<?php

namespace app\common\model;

use think\Model;


class Teacher extends Model
{

    

    

    // 表名
    protected $name = 'teacher';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [

    ];

    public function getTeacher($id_card){
        $res = $this->where("`id_card` = '$id_card'")->find()->toArray();
        return $res;
    }

}
