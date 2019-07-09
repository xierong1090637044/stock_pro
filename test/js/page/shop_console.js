//JavaScript代码区域
var userid = getUrlParam("id");
var opreat_type;
var select_data;

layui.use('upload', function() {
	var upload = layui.upload;

	//执行实例
	var uploadInst = upload.render({
		elem: '#upload' //绑定元素
			,
		url: '../res/do_getfile.php?userid='+userid //上传接口
			,
		accept: "file",
		exts: 'xls|excel|xlsx',
		done: function(res) {
			//上传完毕回调
			console.log(res.data);
		},
		error: function() {
			//请求异常回调
			layer.msg("上传成功");
			initTab();
			
		}
	});
});

layui.use('element', function() {
	var element = layui.element;
	var myDate = new Date();
	var month = myDate.getMonth() + 1;
	var newMonth = month > 9 ? month : "0" + month; //月
	var now_data = myDate.getFullYear() + "-" + newMonth;
	select_data = now_data;
	console.log(now_data);

	element.on('nav(select_pro)', function(elem) {
		console.log(elem.text()); //得到当前点击的DOM对象
		console.log(select_data);
		switch (elem.text()) {
			case "出库记录":
				opreat_type = "出库记录";
				initdelivery(select_data);
				changeData();
				break;

			case "入库记录":
				opreat_type = "入库记录";
				initenter(select_data);
				changeData();
				break;

			case "所有商品":
				initTab();
				break;

			case "操作记录":
				opreat_type = "操作记录";
				initoperation(select_data);
				changeData();
				break;
		}

	});

	initTab();
	getList(); //得到类别
});

//改变日期
function changeData() {
	layui.use('laydate', function() {
		var laydate = layui.laydate;

		//执行一个laydate实例
		laydate.render({
			elem: '#test1' //指定元素
				,
			type: 'month',
			theme: '#393D49',
			value: select_data,
			done: function(value, date, endDate) {
				console.log(value); //得到日期生成的值，如：2017-08-18
				select_data = value;
				switch (opreat_type) {
					case "出库记录":
						initdelivery(value);
						break;
					case "入库记录":
						initenter(value);
						break;
					case "操作记录":
						initoperation(value);
						break;
				}
			}
		});
	});

	$("#select_data").removeClass("layui-hide");
}


function initTab() {
	layui.use('table', function() {
		var table = layui.table;

		//第一个实例
		var ins1 = table.render({
			elem: '#demo',
			toolbar: '#toolbarDemo',
			height: 'full-20',
			id: 'idTest',
			url: '../res/do_getdata.php?userid=' + userid //数据接口
				,
			request: {
				pageName: 'curr' //页码的参数名称，默认：page
					,
				limitName: 'nums' //每页数据量的参数名，默认：limit
			}
			//,page: true //开启分页
			,
			cols: [
				[ //表头
					{
						checkbox: true,
						fixed: 'left'
					}, {
						field: 'id',
						title: 'ID',
						width: 120,
						sort: true,
					}, {
						field: 'name',
						title: '名字',
						width: 120,
						edit: 'text'
					}, {
						field: 'costPrice',
						title: '成本价',
						width: 100,
						edit: 'text'
					}, {
						field: 'retailPrice',
						title: '零售价格',
						width: 100,
						edit: 'text'
					}, {
						field: 'reserve',
						title: '当前库存',
						width: 100,
					}, {
						field: 'packageContent',
						title: '规格',
						width: 80,
					}, {
						field: 'packingUnit',
						title: '单位',
						width: 80,
					}
					//,{field: 'packModel', title: '型号', width:100,}
					, {
						field: 'regNumber',
						title: '登记编号',
						width: 100,
					}, {
						field: 'producer',
						title: '生产厂家',
						width: 100,
					}, {
						field: 'createdTime',
						title: '创建时间',
						width: 100,
					}
					//,{width:250, align:'center', toolbar: '#barDemo'}
				]
			],
			parseData: function(res) {
				return {
					"code": res.code, //解析接口状态
					"msg": res.msg, //解析提示文本
					"count": res.count, //解析数据长度
					"data": res.alldata //解析数据列表
				};
			}

		});

		//头工具栏事件
		table.on('toolbar(test)', function(obj) {
			var checkStatus = table.checkStatus(obj.config.id);
			console.log(obj.event);
			switch (obj.event) {
				case 'getCheckData':
					var data = checkStatus.data;
					layer.alert(JSON.stringify(data));
					break;
				case 'getCheckLength':
					var data = checkStatus.data;
					layer.msg('选中了：' + data.length + ' 个');
					break;
				case 'add_products':

					layer.open({
						type: 1,
						title: "新增商品",
						area: ['500px'],
						content: $('#form_addpro') //这里content是一个DOM，注意：最好该元素要存放在body最外层，否则可能被其它的相对元素所影响
					});

					$("#select_class").click(function() {
						console.log($(this));
						$(this).find(".goodsClass").append("<option lay-value=5 class>杭州dasdas</option>");
					});
					layui.use('form', function() {
						var form = layui.form;
						//监听提交
						form.on('submit(formDemo)', function(data) {
							layer.msg(JSON.stringify(data.field));
							return false;
						});

						form.on('select(test)', function(data) {
							console.log(data);
						});
					});
					break;
			};
		});
	});
};


//出库记录点击
function initdelivery(value) {
	layui.use('table', function() {
		var table = layui.table;

		//第一个实例
		var ins1 = table.render({
			elem: '#demo',
			toolbar: '#empty_options',
			height: 'full-20',
			id: 'idTest',
			url: '../res/do_getdelivery.php?userid=' + userid + '&data=' + value //数据接口
				,
			request: {
				pageName: 'curr' //页码的参数名称，默认：page
					,
				limitName: 'nums' //每页数据量的参数名，默认：limit
			}
			//,page: true //开启分页
			,
			cols: [
				[ //表头
					{
						checkbox: true,
						fixed: 'left'
					}, {
						field: 'id',
						title: 'ID',
						width: 120,
						sort: true,
					}, {
						field: 'name',
						title: '商品名称',
						width: 120,
					}, {
						field: 'retailPrice',
						title: '出库单价',
						width: 100,
					}, {
						field: 'num',
						title: '出库数量',
						width: 100,
					}, {
						field: 'total_money',
						title: '出库总金额',
						width: 100,
					}, {
						field: 'createdAt',
						title: '出库时间',
						width: 200,
					}
				]
			],
			parseData: function(res) {
				return {
					"code": res.code, //解析接口状态
					"msg": res.msg, //解析提示文本
					"count": res.count, //解析数据长度
					"data": res.alldata //解析数据列表
				};
			}
		});
	});

	changeData();
}

//入库记录点击
function initenter(value) {
	layui.use('table', function() {
		var table = layui.table;

		//第一个实例
		var ins1 = table.render({
			elem: '#demo',
			toolbar: '#empty_options',
			height: 'full-20',
			id: 'idTest',
			url: '../res/do_getenter.php?userid=' + userid + '&data=' + value //数据接口
				,
			request: {
				pageName: 'curr' //页码的参数名称，默认：page
					,
				limitName: 'nums' //每页数据量的参数名，默认：limit
			}
			//,page: true //开启分页
			,
			cols: [
				[ //表头
					{
						checkbox: true,
						fixed: 'left'
					}, {
						field: 'id',
						title: 'ID',
						width: 120,
						sort: true,
					}, {
						field: 'name',
						title: '商品名称',
						width: 120,
					}, {
						field: 'retailPrice',
						title: '入库单价',
						width: 100,
					}, {
						field: 'num',
						title: '入库数量',
						width: 100,
					}, {
						field: 'total_money',
						title: '入库总金额',
						width: 100,
					}, {
						field: 'createdAt',
						title: '入库时间',
						width: 200,
					}
				]
			],
			parseData: function(res) {
				return {
					"code": res.code, //解析接口状态
					"msg": res.msg, //解析提示文本
					"count": res.count, //解析数据长度
					"data": res.alldata //解析数据列表
				};
			}

		});
	});
	changeData();
}

//操作记录点击
function initoperation(value) {
	layui.use('table', function() {
		var table = layui.table;

		//第一个实例
		var ins1 = table.render({
			elem: '#demo',
			toolbar: '#empty_options',
			height: 'full-20',
			id: 'idTest',
			url: '../res/do_getoperation.php?userid=' + userid + '&data=' + value //数据接口
				,
			request: {
				pageName: 'curr' //页码的参数名称，默认：page
					,
				limitName: 'nums' //每页数据量的参数名，默认：limit
			}
			//,page: true //开启分页
			,
			cols: [
				[ //表头
					{
						checkbox: true,
						fixed: 'left'
					}, {
						field: 'id',
						title: 'ID',
						width: 120,
						sort: true,
					}, {
						field: 'type',
						title: '操作类型',
						width: 120,
					}, {
						field: 'opreater',
						title: '操作者',
						width: 100,
					}, {
						field: 'bills_relation',
						title: '操作记录（根据ID关联出入库记录表格）',
						width: 180,
					}, {
						field: 'custom',
						title: '客户',
						width: 100,
					}, {
						field: 'all_money',
						title: '实际总金额',
						width: 100,
					}, {
						field: 'real_money',
						title: '实际收到金额',
						width: 100,
					}, {
						field: 'debt',
						title: '欠款',
						width: 100,
					}, {
						field: 'beizhu',
						title: '备注',
						width: 100,
					}, {
						field: 'createdAt',
						title: '操作时间',
						width: 200,
					}
				]
			],
			parseData: function(res) {
				return {
					"code": res.code, //解析接口状态
					"msg": res.msg, //解析提示文本
					"count": res.count, //解析数据长度
					"data": res.alldata //解析数据列表
				};
			}
		});
	});
	changeData();

	function getList() {

	};

	function upload_execle() {
		console.log("上传文件")
	};
}
