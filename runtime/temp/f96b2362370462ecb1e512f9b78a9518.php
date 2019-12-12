<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:105:"F:\PHP\preject\phpStudy\PHPTutorial\WWW\teacher\public/../application/admin\view\salary\salary\index.html";i:1576145241;s:90:"F:\PHP\preject\phpStudy\PHPTutorial\WWW\teacher\application\admin\view\layout\default.html";i:1572536367;s:87:"F:\PHP\preject\phpStudy\PHPTutorial\WWW\teacher\application\admin\view\common\meta.html";i:1572536366;s:89:"F:\PHP\preject\phpStudy\PHPTutorial\WWW\teacher\application\admin\view\common\script.html";i:1572536366;}*/ ?>
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
                                <div class="panel panel-default panel-intro">
    <?php echo build_heading(); ?>

    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">
                <div class="widget-body no-padding">
                    <div id="toolbar" class="toolbar inline">
                        <a href="javascript:;" class="btn btn-primary btn-refresh" title="<?php echo __('Refresh'); ?>" ><i class="fa fa-refresh"></i> </a>
                        <a href="javascript:;" class="btn btn-success btn-add <?php echo $auth->check('salary/salary/add')?'':'hide'; ?>" title="<?php echo __('Add'); ?>" ><i class="fa fa-plus"></i> <?php echo __('Add'); ?></a>
                        <a href="javascript:;" class="btn btn-success btn-edit btn-disabled disabled <?php echo $auth->check('salary/salary/edit')?'':'hide'; ?>" title="<?php echo __('Edit'); ?>" ><i class="fa fa-pencil"></i> <?php echo __('Edit'); ?></a>
                        <a href="javascript:;" class="btn btn-danger btn-del btn-disabled disabled <?php echo $auth->check('salary/salary/del')?'':'hide'; ?>" title="<?php echo __('Delete'); ?>" ><i class="fa fa-trash"></i> <?php echo __('Delete'); ?></a>
<!--                        <a href="javascript:;" class="btn btn-danger btn-import <?php echo $auth->check('salary/salary/import')?'':'hide'; ?>" title="<?php echo __('Import'); ?>" id="btn-import-file" data-url="ajax/upload" data-mimetype="csv,xls,xlsx" data-multiple="false"><i class="fa fa-upload"></i> <?php echo __('Import'); ?></a>-->
                        <div>
                            <input id="datetimepicker" data-rule="required"  class="form-control datetimepicker form-datetime" data-date-format="YYYY-MM"  data-use-current="true"  name="row['salary_time']"  type="text" value="<?php echo date('Y-m'); ?>"   />
                            <a href="javascript:;"  onclick="check_import()" class="btn btn-danger btn-import <?php echo $auth->check('salary/salary/import?id=123'); ?>" title="<?php echo __('Import'); ?>" id="btn-import-file" data-url="ajax/upload" data-mimetype="csv,xls,xlsx" data-multiple="false">
                                <i class="fa fa-upload"></i> <?php echo __('Import'); ?>
                            </a>
                        </div>
                    </div>
                    <table id="table" class="table table-striped table-bordered table-hover table-nowrap"
                           data-operate-edit="<?php echo $auth->check('salary/salary/edit'); ?>" 
                           data-operate-del="<?php echo $auth->check('salary/salary/del'); ?>" 
                           width="100%">
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    var month;
    function check_import(){
        var result  = $("#datetimepicker").val();
        if(result){
            alert('您导入的是'+result+'的数据');
            month  =  '123564';
        }else{
            return false;
        }
    }
</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>