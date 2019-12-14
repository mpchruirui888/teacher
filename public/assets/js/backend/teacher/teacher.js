

define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {


    var Controller = {

        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'teacher/teacher/index' + location.search,
                    add_url: 'teacher/teacher/add',
                    edit_url: 'teacher/teacher/edit',
                    del_url: 'teacher/teacher/del',
                    multi_url: 'teacher/teacher/multi',
                    import_url: 'teacher/teacher/import',
                    table: 'teacher',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                commonSearch: false,  //关闭普通搜索
                pageList:[18,30,50,'ALL'],
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'username', title: __('Username')},
                        {field: 'password', title: __('Password')},
                        {field: 'sex', title: __('Sex'),
                            formatter: function(value,row,index){
                                        if(value == 'women'){
                                            return '女';
                                        }else{
                                            return '男';
                                        }
                            }
                        },
                        {field: 'id_card', title: __('Id_card')},
                        {field: 'add_time', title: __('Add_time'), operate:'RANGE', addclass:'datetimerange'},
                        {field: 'operate', title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'detail',
                                    text: __('薪资明细'),
                                    title: __('薪资明细'),
                                    classname: 'btn btn-xs btn-primary btn-addtabs',
                                    icon: 'fa fa-list',
                                    url: 'salary/salary/index/id_card={id_card}',
                                }
                                ],
                            formatter: Table.api.formatter.operate
                        },
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
        info: function () {
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