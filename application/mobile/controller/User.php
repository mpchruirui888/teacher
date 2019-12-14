<?php

namespace  app\mobile\controller;
use app\admin\model\Teacher;
use app\common\controller\Backend;
use app\common\helpFun\HelpFun;
use app\mobile\behavior\Login;
use app\admin\model\salary\Salary;
use think\Session;

class User   extends Controller
{
    public $conn;
    public $salary;

    public function __construct()
    {
        parent::__construct();
        $this->conn = new Teacher();
        $this->salary = new Salary();
    }
    /**
     * 处理登录
     */
    public function login(){

        $id_card =  trim($_POST['id_card']);
        $password = trim($_POST['password']);

        if(! HelpFun::is_idcard($id_card)){
            $this->returnDate(500,'请核对身份证信息！',[]);
        }

       $res = $this->conn->where('id_card','=',$id_card)->find()->toArray();
       if($res){
            if($res['password'] == $password){
                $this->returnDate(200,'登录成功！',['userInfo' => $res]);
                Session::set('userName',$res['username']);
                Session::set('idCard',$res['id_card']);
            }else{
                $this->returnDate(400,'密码错误！',[]);
            }
       }else{
           $this->returnDate(400,'该用户不存在！',[]);
       }
    }

    /**修改时验证信息
     * @return \think\response\Json|void
     */
    public function changePwd()
    {
        $username = trim($_POST['username']);
        $id_card  =  trim($_POST['id_card']);
       if($id_card && $username){
           if(! HelpFun::is_idcard($id_card)){
               $this->returnDate(400,'请核对身份证信息！',[]);
           }
           $res = $this->conn->where('id_card','=',$id_card)->find()->toArray();
           if($res['username'] == $username){
               $this->returnDate(200,'跳转中....',['id_card'=>$res['id_card']]);
           }else{
               $this->returnDate(400,'请核对身份证信息和用户名是否匹配！',[]);
           }
       }else{
           $this->returnDate(400,'请输入信息后提交！',[]);
       }
    }
    /**
     *修改密码操作
     */
    public function changeDo()
    {
        if(Session::get('idCard')){
            //登录状态下修改密码
            $id_card = trim(Session::get('idCard'));
        }else{
//            未登录状态下修改密码
            $id_card = trim($_GET['id_card']);
        }
        $password = trim($_POST['password']);
        $newPassword = trim($_POST['newPassword']);
        if($password && $newPassword){
            if(strlen($password)<6 || ($password != $newPassword )){
                $this->returnDate(500,'请保持密码一致并在6位以上',[]);
            }else{
                $res = $this->conn->where('id_card','=',$id_card)->find()->toArray();
                $result = $this->conn->where("`id_card`='$res[id_card]'")->update(['password'=>$password]);
                if($result){
                    $this->returnDate(200,'修改成功！',[]);
                }
            }
        }else{
            $this->returnDate(500,'请输入所需信息后提交！',[]);
        }
    }

    /**
     * 个人中心
     */
    public function userInfo()
    {
        if(Session::get('idCard')){
            $res = $this->conn->where('id_card','=',Session::get('idCard'))->find()->toArray();
            if($res['sex'] == 'women'){
                $res['sex'] = '女';
            }else{ $res['sex'] = '男'; }
            $this->returnDate(200,'获取成功',$res);
        }
    }

    /**根据年月获取薪资列表
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getSalary()
    {
        $year   =  trim($_POST['year']);
        $month  =  trim($_POST['month']) ;

        if(!$year && !$month){
            $this->returnDate(400,'请选择日期',[]);
        }else{
            if(!$month){
                $start =  strtotime(date("$year/1/1"));
                $end =  strtotime(date("$year/12/1"));
            }else{
                $start =  strtotime(date("$year/$month/1"));
                $end =  $start;
            }
            $res = $this->salary->where([
                'id_card'=> Session::get('idCard'),
                'salary_time'=>['in',[$start,$end]]
            ])->field('id,post_wage,Pay_wages,salary_total,salary_time')
              ->select();
            $data['salary'] = array();
            if($res->count()>0){
                $row = $res->toArray();
                foreach($row as $key =>$value){
                    $row[$key]['time'] = date("Y-m",$row[$key]['salary_time']);
                }
                $data['salary'] = $row;
                $this->returnDate(200,'获取成功！',$data);
            }else{
                $this->returnDate(200,'暂无数据！', $data);
            }
        }
    }

    /**
     * 获取指定的月份的薪资明细
     */
    public function getSalaryDetails()
    {
        $id = trim($_GET['id']);
        if($id){
           $where['id'] = $id;
           $row  =  $this->salary->where($where)->find()->toArray();
           $row['time'] = date("Y-m",$row['salary_time']);
           if($row['sex'] === "women"){
               $row['sex'] = '女';
           }else{
               $row['sex'] = '男';
           }
            $this->returnDate(200,'获取成功',$row);
        }
    }

    /**
     * 退出登录
     */
    public function loginOut()
    {
        session("idCard", NULL);
        session("userName", NULL);
        $this->returnDate(200,'退出成功',[]);
    }
}