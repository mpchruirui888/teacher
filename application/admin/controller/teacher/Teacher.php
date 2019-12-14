<?php

namespace app\admin\controller\teacher;

use app\common\controller\Backend;
use app\common\helpFun\HelpFun;
use PHPExcel_IOFactory;
use think\Db;
use think\Exception;
use think\exception\PDOException;
use think\exception\ValidateException;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Teacher extends Backend
{
    
    /**
     * Teacher模型对象
     * @var \app\admin\model\teacher\Teacher
     */
    protected $model = null;
    //快速搜索时的字段
    protected $searchFields = 'id,username,id_card';

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\teacher\Teacher;

    }

    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if($this->request->isAjax()){
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField')) {
                return $this->selectpage();
            }

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->where(['id_card'=>$where])
                ->order($sort, $order)
                ->count();
            $list = $this->model
                ->where(['id_card'=>$where])
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            /**
             * 隐藏掉所有的密码并不给前端展示
             */
            foreach($list as $key =>$value){
                $value['add_time'] =  date('Y-m-d H:i:s', $value['add_time']);
            }

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
       return $this->view->fetch();
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    /**
     * 编辑
     */
    public function edit($ids = null)
    {
        $row = $this->model->get($ids);
        if (!$row) {
            $this->error(__('No Results were found'));
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                if(! HelpFun::is_idcard(trim($params['id_card']))){
                    return json(['code'=>2,'url'=>'http://teacher.com/FYR2NjtXSf.php/teacher/teacher/index?addtabs=1','wait'=>3,'msg'=>'请核对身份证信息！']);
                }
                $params['add_time'] = time();
                $params['password'] = $params['id_card'];
                $params = $this->preExcludeFields($params);
                $result = false;
                Db::startTrans();
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = str_replace("\\model\\", "\\validate\\", get_class($this->model));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : $name) : $this->modelValidate;
                        $row->validateFailException(true)->validate($validate);
                    }
                    $result = $row->allowField(true)->save($params);
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
                    $this->error(__('No rows were updated'));
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    /**增加
     * @return string
     * @throws Exception
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
//              检查身份证信息
                if(! HelpFun::is_idcard(trim($params['id_card']))){
                    return json(['code'=>2,'url'=>'http://teacher.com/FYR2NjtXSf.php/teacher/teacher/index?addtabs=1','wait'=>3,'msg'=>'请核对身份证信息！']);
                }
//              数据库查重
                $result = $this->model->getTeacher($params['id_card']);
                if(count($result)>0){
                   return json(['code'=>2,'url'=>'http://teacher.com/FYR2NjtXSf.php/teacher/teacher/index?addtabs=1','wait'=>3,'msg'=>'该身份证已被使用！']);
                }
                $params['add_time'] = time();
                $params['password'] = $params['id_card'];  //密码等于身份证
                $params = $this->preExcludeFields($params);

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
    /**
     * 导入教师
     */
    public function import()
    {
        $file = $this->request->request('file');
        if (!$file) {
            $this->error(__('Parameter %s can not be empty', 'file'));
        }
        $filePath = ROOT_PATH . DS . 'public' . DS . $file;
        date_default_timezone_set('PRC');
        // 读取excel文件
        try {
            $inputFileType = PHPExcel_IOFactory::identify($filePath);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($filePath);
        } catch(Exception $e) {
            die('加载文件发生错误："'.pathinfo($filePath,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
        $sheet = $objPHPExcel->getSheet(0);
        $data=$sheet->toArray();
        for ($i = 1;$i<count($data);$i++){
                $arr[$i-1]['company'] =  $data[$i][1];
                $arr[$i-1]['username'] = $data[$i][2];
                $arr[$i-1]['id_card'] =  $data[$i][3];
                $arr[$i-1]['sex'] =   'men';
                if($data[$i][4] == '女'){
                    $arr[$i-1]['sex'] =   'women';
                }
                $arr[$i-1]['password'] = $data[$i][3];   //密码是身份证号码
                $arr[$i-1]['add_time'] = time();   //密码是身份证号码
                //数据库查重
                $row = $this ->model-> where('id_card','=',$data[$i][3]) -> select();
                if(count($row)>=1){
                    return json(['code'=>2,'url'=>'http://teacher.com/FYR2NjtXSf.php/teacher/teacher/index?addtabs=1','wait'=>3,'msg'=>$arr[$i-1]['username'].'&nbsp;&nbsp;'.$arr[$i-1]['id_card'].'<hr>此身份证已存在！']);
                }
                $this->model -> insert($arr[$i-1]);
        }
        return json(['code'=>1,'url'=>'http://teacher.com/FYR2NjtXSf.php/teacher/teacher/index?addtabs=1','wait'=>3]);
    }
}
