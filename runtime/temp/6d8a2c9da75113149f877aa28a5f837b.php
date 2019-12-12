<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:103:"F:\PHP\preject\phpStudy\PHPTutorial\WWW\teacher\public/../application/admin\view\salary\salary\add.html";i:1576139559;s:90:"F:\PHP\preject\phpStudy\PHPTutorial\WWW\teacher\application\admin\view\layout\default.html";i:1572536367;s:87:"F:\PHP\preject\phpStudy\PHPTutorial\WWW\teacher\application\admin\view\common\meta.html";i:1572536366;s:89:"F:\PHP\preject\phpStudy\PHPTutorial\WWW\teacher\application\admin\view\common\script.html";i:1572536366;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !$config['fastadmin']['multiplenav']): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Username'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-username" data-rule="required" class="form-control" name="row[username]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Id_card'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-id_card" data-rule="required" class="form-control" name="row[id_card]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Sex'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
<!--            <input id="c-sex" data-rule="required" class="form-control" name="row[sex]" type="text">-->
            <?php echo build_radios('row[sex]', ['men'=>__('Men'), 'women'=>__('Women')]); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Post_wage'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-post_wage" data-rule="required" class="form-control" name="row[post_wage]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Pay_wages'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-Pay_wages" data-rule="required" class="form-control" name="row[Pay_wages]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Edu_improve'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-edu_improve" data-rule="required" class="form-control" name="row[edu_improve]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Keep_subsidy'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-keep_subsidy" data-rule="required" class="form-control" name="row[keep_subsidy]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Region_subsidy'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-region_subsidy" data-rule="required" class="form-control" name="row[region_subsidy]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Edu_age_subsidy'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-edu_age_subsidy" data-rule="required" class="form-control" name="row[edu_age_subsidy]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Merit_pay_total'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-merit_pay_total" data-rule="required" class="form-control" name="row[merit_pay_total]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Reform_subsidy'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-reform_subsidy" data-rule="required" class="form-control" name="row[reform_subsidy]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Housing_subsidy'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-housing_subsidy" data-rule="required" class="form-control" name="row[housing_subsidy]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Super_subsidy'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-super_subsidy" data-rule="required" class="form-control" name="row[super_subsidy]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Deserve_total'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-deserve_total" data-rule="required" class="form-control" name="row[deserve_total]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Remove_pension'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-remove_pension" data-rule="required" class="form-control" name="row[remove_pension]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Remove_housing'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-remove_housing"  class="form-control" name="row[remove_housing]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Remove_unemployment'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-remove_unemployment" class="form-control" name="row[remove_unemployment]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Replace_remove_one'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-replace_remove_one" data-rule="required" class="form-control" name="row[replace_remove_one]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Replace_remove_two'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-replace_remove_two" data-rule="required" class="form-control" name="row[replace_remove_two]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Replace_remove_itax'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-replace_remove_itax" data-rule="required" class="form-control" name="row[replace_remove_itax]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Salary_total'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-salary_total" data-rule="required" class="form-control" name="row[salary_total]" type="text">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Remark'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-remark" data-rule="required" class="form-control" name="row[remark]" type="text">
        </div>
    </div>
    <div class="form-group hidden">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Add_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-add_time" data-rule="required" class="form-control datetimepicker" data-date-format="YYYY-MM-DD HH:mm:ss" data-use-current="true" name="row[add_time]" type="text" value="<?php echo date('Y-m-d H:i:s'); ?>">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Salary_time'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-salary_time" class="form-control datetimepicker" data-date-format="YYYY-MM" data-use-current="true" name="row[salary_time]" type="text" value="<?php echo date('Y-m-d H:i:s'); ?>">
        </div>
    </div>
    <div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
        <div class="col-xs-12 col-sm-8">
            <button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>
            <button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>