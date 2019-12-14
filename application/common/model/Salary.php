<?php

namespace app\model\salary;

use app\common\helpFun\HelpFun;
use think\Model;


class Salary extends Model
{

    

    

    // 表名
    protected $name = 'salary';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'add_time_text',
        'salary_time_text'
    ];
    

    



    public function getAddTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['add_time']) ? $data['add_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getSalaryTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['salary_time']) ? $data['salary_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setAddTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    protected function setSalaryTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }

    /**检查输入的参数 合法性
     * @param $form
     * @return \think\response\Json
     */
    public function checkForm($form){
        if(! HelpFun::is_idcard(trim($form['id_card']))){
            return  $this->msgInfo('身份证信息格式错误');
        }
        $model = array_slice($form,3,18);
        foreach ($model as $key =>$value){
            if(! HelpFun::is_number(trim($value))){
                return  $this->msgInfo(__($key).'格式不正确！');
            }
        }
        return  true;
    }
    public function msgInfo($msg){
        return json(['code'=>2,'url'=>'http://teacher.com/FYR2NjtXSf.php/salary/salary/index?addtabs=1','wait'=>3,'msg'=>$msg]);
    }
}
