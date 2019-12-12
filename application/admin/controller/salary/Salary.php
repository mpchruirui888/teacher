<?php

namespace app\admin\controller\salary;

use app\common\controller\Backend;
use think\Db;
use think\Exception;
use think\exception\PDOException;
use think\exception\ValidateException;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Salary extends Backend
{
    
    /**
     * Salary模型对象
     * @var \app\admin\model\salary\Salary
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\salary\Salary;

    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax()) {

            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $total = $this->model
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

//            foreach($list as $key =>$value){
//                $value['add_time'] =  date('Y-m-d H:i:s', $value['add_time']);
//            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }

        return $this->view->fetch();
    }
    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params = $this->preExcludeFields($params);
                if(isset($params['id_card'])){
                    $row = model('teacher') -> where('id_card','=',$params['id_card'])-> find();
                    if(count($row)<=0){
                            return json(['code'=>2,'url'=>'http://teacher.com/FYR2NjtXSf.php/salary/salary/index?addtabs=1','wait'=>3,'msg'=>$params['id_card'].'<hr>此身份证信息匹配不到教师！']);
                    }else{
                        $res = $row ->toArray();
                        if($res['username'] != $params['username']){
                            return json(['code'=>2,'url'=>'http://teacher.com/FYR2NjtXSf.php/salary/salary/index?addtabs=1','wait'=>3,'msg'=>$params['id_card'].'<hr>此身份证信息匹配不到教师！']);
                        }
                    }
                }
                $params['add_time'] = time();
                $params['salary_time'] = strtotime(date($params['salary_time']));

                if ($this->dataLimit && $this->dataLimitFieldAutoFill) {
                    $params[$this->dataLimitField] = $this->auth->id;
                }
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : $name) : $this->modelValidate;
                        $this->model->validateFailException(true)->validate($validate);
                    }
                    $result = $this->model->allowField(true)->save($params);
                    Db::commit();
                } catch (ValidateException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (PDOException $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                } catch (Exception $e) {
                    Db::rollback();
                    $this->error($e->getMessage());
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error(__('No rows were inserted'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }


    public function import()
    {
        dump(21);
    }
}
