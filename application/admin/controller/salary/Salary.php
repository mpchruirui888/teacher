<?php

namespace app\admin\controller\salary;

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
            if ($params ) {
                if($this->model->checkForm($params) != 'true'){
                    return  $this->model->checkForm($params);
                }
                $params = $this->preExcludeFields($params);
                if(isset($params['id_card'])){
                    $row = model('teacher') -> where('id_card','=',$params['id_card'])-> find();
                    if(count($row)<=0){
                            return json(['code'=>2,'url'=>'http://teacher.com/FYR2NjtXSf.php/salary/salary/index?addtabs=1','wait'=>3,'msg'=>$params['id_card'].'<hr>此身份证信息匹配不到教师！']);
                    }else{
                        $res = $row ->toArray();
                        if(($res['username'] != $params['username']) || ($res['sex'] != $params['sex'])){
                            return json(['code'=>2,'url'=>'http://teacher.com/FYR2NjtXSf.php/salary/salary/index?addtabs=1','wait'=>3,'msg'=>$params['id_card'].'<hr>该教师姓名或性别和身份证不匹配！']);
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
                    /**
                     * 判断当前月份是否有薪资条 如果有覆盖掉
                     */
//                    $res = $this->model-> where('salary_time','=',$params['salary_time'])->('id_card','=',$params['salary_time'])-> find()->toArray();
                    $res = $this->model-> where("`salary_time` = $params[salary_time] AND `id_card` = '$params[id_card]'")->find();

                    $row = $res->toArray();
                    if(count($row)>0){
                        $result = $this->model -> where("`id_card` = '$params[id_card]' ") -> update($params);
                    }else{
                        $result = $this->model->allowField(true)->save($params);
                    }
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

    /**导入工资数据
     * @param $month
     * @return \think\response\Json
     */
    public function check_import($month)
    {

//      获取月份
        if(!$month){
                 return json(['code'=>2,'url'=>'http://teacher.com/FYR2NjtXSf.php/salary/salary/index?addtabs=1','wait'=>3,'msg'=>'请选择导入的月份！']);
        }
        $filePath = $_POST['filePath'];
//      操作导入的文件
        $filePath = ROOT_PATH . DS . 'public' . DS . $filePath;
        date_default_timezone_set('PRC');
        // 读取excel文件
        try {
            $inputFileType = PHPExcel_IOFactory::identify($filePath);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($filePath);
        } catch(Exception $e) {
            die('加载文件发生错误："'.pathinfo($filePath,PATHINFO_BASENAME).'": '.$e->getMessage());
        }
        $sheet = $objPHPExcel->getSheet(1);
        $data=$sheet->toArray();
        //操作入库
        for ($i =2;$i<count($data);$i++){
            $arr[$i-1]['username'] =  $data[$i][1];  //用户名
            $arr[$i-1]['id_card'] = $data[$i][2];    //身份证号码
            $arr[$i-1]['sex'] =  $data[$i][3];       // 性别
            $arr[$i-1]['sex'] =   'men';
            if($data[$i][3] == '女'){
                $arr[$i-1]['sex'] =   'women';
            }
            $arr[$i-1]['post_wage'] = $data[$i][4];   //岗位工资
            $arr[$i-1]['Pay_wages'] = $data[$i][5];   //薪级工资
            $arr[$i-1]['edu_improve'] = $data[$i][6];   //教护提高
            $arr[$i-1]['keep_subsidy'] = $data[$i][7];   //保留补贴
            $arr[$i-1]['region_subsidy'] = $data[$i][8];   //地区补贴
            $arr[$i-1]['edu_age_subsidy'] = $data[$i][9];   //教护龄补贴
            $arr[$i-1]['merit_pay_total'] = $data[$i][10];   //绩效工资总量
            $arr[$i-1]['reform_subsidy'] = $data[$i][11];   //改革性补贴
            $arr[$i-1]['housing_subsidy'] = $data[$i][12];   //住房补贴
            $arr[$i-1]['super_subsidy'] = $data[$i][13];   //特教津贴
            $arr[$i-1]['deserve_total'] = $data[$i][14];   //应发工资
            $arr[$i-1]['remove_pension'] = $data[$i][15];   //扣养老保险和职业年金
            $arr[$i-1]['remove_housing'] = $data[$i][16];   //扣住房公积金
            $arr[$i-1]['remove_unemployment'] = $data[$i][17];   //扣失业保险
            $arr[$i-1]['replace_remove_one'] = $data[$i][18];   //代扣1
            $arr[$i-1]['replace_remove_two'] = $data[$i][19];   //代扣2
            $arr[$i-1]['replace_remove_itax'] = $data[$i][20];   //代扣个人所得税
            $arr[$i-1]['salary_total'] = $data[$i][21];   //工资总额
            if($data[$i][22] == ""){
                $arr[$i-1]['remark'] = null;
            }
            $arr[$i-1]['remark'] = $data[$i][22];   //备注
            $arr[$i-1]['add_time'] = time();   //增加时间
            $arr[$i-1]['salary_time'] = strtotime(date($month));   //工资月份
            //写入数据库
            $this->model -> insert($arr[$i-1]);
        }
        return json(['code'=>1,'url'=>'http://teacher.com/FYR2NjtXSf.php/salary/salary/index?addtabs=1','wait'=>3]);
    }

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
//                if(!$this->model->checkForm($params)){

                    return $this->model->checkForm($params);
//                }
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
//                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
}
