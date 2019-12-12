
define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {


    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'salary/salary/index' + location.search,
                    add_url: 'salary/salary/add',
                    edit_url: 'salary/salary/edit',
                    del_url: 'salary/salary/del',
                    multi_url: 'salary/salary/multi',
                    import_url: 'salary/salary/import',
                    table: 'salary',
                }
            });
//绑定select元素事件
            require(['bootstrap-datetimepicker'], function () {
                var options = {
                    format: 'YYYY-MM-DD HH:mm:ss',
                    icons: {
                        time: 'fa fa-clock-o',
                        date: 'fa fa-calendar',
                        up: 'fa fa-chevron-up',
                        down: 'fa fa-chevron-down',
                        previous: 'fa fa-chevron-left',
                        next: 'fa fa-chevron-right',
                        today: 'fa fa-history',
                        clear: 'fa fa-trash',
                        close: 'fa fa-remove'
                    },
                    showTodayButton: true,
                    showClose: true
                };
                $('.datetimepicker').parent().css('position', 'relative');
                $('.datetimepicker').datetimepicker(options);
            });
            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                pageList:[10,20,50,'ALL'],
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'),operate:false},
                        {field: 'username', title: __('Username')},
                        {field: 'id_card', title: __('Id_card')},
                        {field: 'sex', title: __('Sex'),operate:false,
                            formatter: function(value,row,index){
                                if(value == 'women'){
                                    return '女';
                                }else{
                                    return '男';
                                }
                            }
                        },
                        {field: 'post_wage', title: __('Post_wage'),operate:false},
                        {field: 'Pay_wages', title: __('Pay_wages'),operate:false},
                        {field: 'edu_improve', title: __('Edu_improve'),operate:false},
                        {field: 'keep_subsidy', title: __('Keep_subsidy'),operate:false},
                        {field: 'region_subsidy', title: __('Region_subsidy'),operate:false},
                        {field: 'edu_age_subsidy', title: __('Edu_age_subsidy'),operate:false},
                        {field: 'merit_pay_total', title: __('Merit_pay_total'),operate:false},
                        {field: 'reform_subsidy', title: __('Reform_subsidy'),operate:false},
                        {field: 'housing_subsidy', title: __('Housing_subsidy'),operate:false},
                        {field: 'super_subsidy', title: __('Super_subsidy'),operate:false},
                        {field: 'deserve_total', title: __('Deserve_total'),operate:false},
                        {field: 'remove_pension', title: __('Remove_pension'),operate:false},
                        {field: 'remove_housing', title: __('Remove_housing'),operate:false},
                        {field: 'remove_unemployment', title: __('Remove_unemployment'),operate:false},
                        {field: 'replace_remove_one', title: __('Replace_remove_one'),operate:false},
                        {field: 'replace_remove_two', title: __('Replace_remove_two'),operate:false},
                        {field: 'replace_remove_itax', title: __('Replace_remove_itax'),operate:false},
                        {field: 'salary_total', title: __('Salary_total'),operate:false},
                        {field: 'remark', title: __('Remark'),operate:false},
                        {field: 'add_time', title: __('Add_time'),operate:false,formatter: Table.api.formatter.datetime},
                        {field: 'salary_time', title: __('Salary_time'), operate: 'RANGE', addclass: 'datetimerange', formatter: Table.api.formatter.datetimeMonth},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        },


    };
    return Controller;
});