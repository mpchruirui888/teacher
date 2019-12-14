<?php

namespace app\api\controller\teacher;

use app\admin\command\Api;

class User  extends Api
{
//    不需要登录的方法
    protected $noNeedLogin = ['login'];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
    }
    /**
     *
     */
    public function index(){
        return $this->error($this->auth->getError());
    }
}