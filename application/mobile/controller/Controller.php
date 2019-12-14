<?php


namespace app\mobile\controller;


use app\common\controller\Backend;
use think\Session;

class Controller  extends Backend
{

    public function __construct()
    {
        $safe = ["login"];
        $action = request()->action();
        //不是安全路由
        if(!in_array($action,$safe)){

            if(!Session::get('userName')){
                $data['code'] = 400;
                $data['msg'] =  '请先登录';
                $data['data'] =  [];
                echo json_encode($data);
                exit;
            }
        }
    }

    public function returnDate($code,$msg,$data)
    {
        $result['code'] = $code;
        $result['msg'] = $msg;
        $result['data'] = $data;
        echo json_encode($result);
        exit;
    }

}