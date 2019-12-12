define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'salary/index' + location.search,
                    add_url: 'salary/add',
                    edit_url: 'salary/edit',
                    del_url: 'salary/del',
                    multi_url: 'salary/multi',
                    table: 'salary',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'username', title: __('Username')},
                        {field: 'id_card', title: __('Id_card')},
                        {field: 'sex', title: __('Sex')},
                        {field: 'post_wage', title: __('Post_wage')},
                        {field: 'Pay_wages', title: __('Pay_wages')},
                        {field: 'edu_improve', title: __('Edu_improve')},
                        {field: 'keep_subsidy', title: __('Keep_subsidy')},
                        {field: 'region_subsidy', title: __('Region_subsidy')},
                        {field: 'edu_age_subsidy', title: __('Edu_age_subsidy')},
                        {field: 'merit_pay_total', title: __('Merit_pay_total')},
                        {field: 'reform_subsidy', title: __('Reform_subsidy')},
                        {field: 'housing _subsidy', title: __('Housing _subsidy')},
                        {field: 'super_subsidy', title: __('Super_subsidy')},
                        {field: 'deserve_total', title: __('Deserve_total')},
                        {field: 'remove_pension', title: __('Remove_pension')},
                        {field: 'remove_housing', title: __('Remove_housing')},
                        {field: 'remove_unemployment', title: __('Remove_unemployment')},
                        {field: 'replace_remove_one', title: __('Replace_remove_one')},
                        {field: 'replace_remove_two', title: __('Replace_remove_two')},
                        {field: 'replace_remove_itax', title: __('Replace_remove_itax')},
                        {field: 'salary_total', title: __('Salary_total')},
                        {field: 'remark', title: __('Remark')},
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
        }
    };
    return Controller;
});