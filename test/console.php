<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>后台</title>
  <link rel="stylesheet" href="layui/css/layui.css" media="all">
</head>
<body>

<div class="layui-tab">
  <ul class="layui-tab-title">
    <li class="layui-this">交纳保证金</li>
    <li>正品保障</li>
    <li>资金返还</li>
  </ul>
  <div class="layui-tab-content">
    <div class="layui-tab-item layui-show">
      <button data-method="offset" data-type="auto" class="layui-btn layui-btn-normal" id="addlink">新增链接</button>
      <table id="demo" lay-filter="test"></table>
    </div>
    <div class="layui-tab-item">
        <button data-method="offset" data-type="auto" class="layui-btn layui-btn-normal" id="addlink1">新增链接</button>
        <table id="demo1" lay-filter="test"></table>
    </div>
    <div class="layui-tab-item">
        <button data-method="offset" data-type="auto" class="layui-btn layui-btn-normal" id="addlink2">新增链接</button>
        <table id="demo2" lay-filter="test"></table>
    </div>
  </div>
</div>

<script src="layui/layui.js"></script>
<script src="js/jquery.min.js"></script>
<script>


layui.use('table', function(){
  var table = layui.table;

  //第一个实例
  table.render({
    elem: '#demo1'
    ,height: 500
    ,id: 'idTest'
    ,url: '../res/do_getdata1.php' //数据接口
    ,request: {
    pageName: 'curr' //页码的参数名称，默认：page
    ,limitName: 'nums' //每页数据量的参数名，默认：limit
}
    ,page: true //开启分页
    ,cols: [[ //表头
      {field: 'id', title: 'ID', width:150, sort: true, fixed: 'left'}
      ,{field: 'url', title: '链接', width:1000}
      ,{field: 'state', title: '是否可用', width:80, sort: true}
    ]]
  });

});

layui.use('table', function(){
  var table = layui.table;

  //第一个实例
  table.render({
    elem: '#demo2'
    ,height: 500
    ,id: 'idTest'
    ,url: '../res/do_getdata2.php' //数据接口
    ,request: {
    pageName: 'curr' //页码的参数名称，默认：page
    ,limitName: 'nums' //每页数据量的参数名，默认：limit
}
    ,page: true //开启分页
    ,cols: [[ //表头
      {field: 'id', title: 'ID', width:150, sort: true, fixed: 'left'}
      ,{field: 'url', title: '链接', width:1000}
      ,{field: 'state', title: '是否可用', width:80, sort: true}
    ]]
  });

});


$("#addlink").click(function(){
    layui.use('layer', function(){
      var layer = layui.layer;

    layer.prompt({
      formType: 2,
      title: '请输入链接',
      maxlength: 1000,
      area: ['400px', '175px'] //自定义文本域宽高
    }, function(value, index, elem){
        $.ajax({
        type: 'POST',
        data: {'type':1,'url':value},
        url: "../res/do_addurl.php",
        success: function (data) {
          console.log(data);

          if(data)
          {
              window.location.reload() ;
              table.resize('idTest');
              layer.close(index);
          }

        },
        fail: function (err) {
          console.log(err);
        }
      });
    });
})

});

$("#addlink1").click(function(){
    layui.use('layer', function(){
      var layer = layui.layer;

    layer.prompt({
      formType: 2,
      title: '请输入链接',
      maxlength: 1000,
      area: ['400px', '175px'] //自定义文本域宽高
    }, function(value, index, elem){
        $.ajax({
        type: 'POST',
        data: {'type':2,'url':value},
        url: "../res/do_addurl.php",
        success: function (data) {
          console.log(data);

          if(data)
          {
              window.location.reload() ;
              table.resize('idTest');
              layer.close(index);
          }

        },
        fail: function (err) {
          console.log(err);
        }
      });
    });
})
});

$("#addlink2").click(function(){
    layui.use('layer', function(){
      var layer = layui.layer;

    layer.prompt({
      formType: 2,
      title: '请输入链接',
      maxlength: 1000,
      area: ['400px', '175px'] //自定义文本域宽高
    }, function(value, index, elem){
        $.ajax({
        type: 'POST',
        data: {'type':3,'url':value},
        url: "../res/do_addurl.php",
        success: function (data) {
          console.log(data);

          if(data)
          {
              window.location.reload() ;
              table.resize('idTest');
              layer.close(index);
          }

        },
        fail: function (err) {
          console.log(err);
        }
      });
    });
})

});

layui.use('element', function(){
  var element = layui.element;

  //…
});


</script>
</body>
</html>
