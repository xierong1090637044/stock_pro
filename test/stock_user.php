<?php
   include_once '../lib/Bmob/BmobObject.class.php';
   include_once '../lib/Bmob/BmobUser.class.php';
   $cur_q=parse_url($_SERVER["REQUEST_URI"],PHP_URL_QUERY);
   parse_str($cur_q,$myArray);

   $bmobUser = new BmobUser();
   $res = $bmobUser->get($myArray["id"]);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>库存表-后台管理</title>
  <link rel="stylesheet" href="layui/css/layui.css" media="all">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="js/bootstrap.min.js">
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.6/dist/vue.js"></script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
  <div class="layui-header">
    <div class="layui-logo">后台管理</div>
    <!-- 头部区域（可配合layui已有的水平导航） -->
    <ul class="layui-nav layui-layout-left">
      <li class="layui-nav-item"><a href="">商品管理</a></li>
      <li class="layui-nav-item"><a href="">用户</a></li>
    </ul>
    <ul class="layui-nav layui-layout-right">
      <li class="layui-nav-item">
        <a href="javascript:;">
          <img src="<?php echo $res->avatarUrl; ?>" class="layui-nav-img">
          <?php echo $res->nickName; ?>
        </a>
        <dl class="layui-nav-child">
          <dd><a href="">基本资料</a></dd>
          <dd><a href="">安全设置</a></dd>
        </dl>
      </li>
      <li class="layui-nav-item"><a href="">退了</a></li>
    </ul>
  </div>

  <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
      <!-- 商品导航栏 -->
      <ul class="layui-nav layui-nav-tree"  lay-filter="select_pro">
        <li class="layui-nav-item layui-nav-itemed">
          <a class="" href="javascript:;">所有商品</a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:;" class="layui-this">所有商品</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a class="" href="javascript:;">出入库记录</a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:;" class="layui">入库记录</a></dd>
            <dd><a href="javascript:;" class="layui">出库记录</a></dd>
          </dl>
        </li>
        <li class="layui-nav-item">
          <a class="" href="javascript:;">查看操作记录</a>
          <dl class="layui-nav-child">
            <dd><a href="javascript:;" class="layui">操作记录</a></dd>
          </dl>
        </li>
      </ul>

    </div>
  </div>

  <div class="layui-body">
    <!-- 内容主体区域 -->
    <div style="padding: 15px;position:relative">
		<button type="button" class="layui-btn layui-btn-sm" lay-event="upload" id="upload"><i class="layui-icon"></i>批量导入</button>
        <table class="layui-hide" id="demo" lay-filter="test"></table>
    </div>
  </div>

  <form class="layui-form" action="" id="form_addpro" style="display:none;margin:10px 50px">
      <div class="layui-form-item" style="margin-bottom: 0px;">
          <label class="layui-form-label">产品名称</label>
          <div class="layui-input-block">
              <input type="text" name="goodsName" required  lay-verify="required" placeholder="请输入产品名称" autocomplete="off" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item" style="margin-bottom: 0px;">
          <label class="layui-form-label">登记编号</label>
          <div class="layui-input-block">
              <input type="text" name="regNumber" placeholder="请输入登记编号" autocomplete="off" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item" style="margin-bottom: 0px;">
          <label class="layui-form-label">生产厂家</label>
          <div class="layui-input-block">
              <input type="text" name="producer" placeholder="请输入生产厂家" autocomplete="off" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item">
          <label class="layui-form-label">产品类别</label>
          <div class="layui-input-block" id="select_class">
            <select name="goodsClass" lay-verify="required" lay-filter="test" id="selected">
              <option value=""></option>
              <option value="0">北京</option>
              <option value="1">上海</option>
              <option value="2">广州</option>
              <option value="3">深圳</option>
              <option value="4">杭州</option>
            </select>
          </div>
      </div>
      <div class="layui-form-item" style="margin-bottom: 0px;">
          <label class="layui-form-label">包装含量</label>
          <div class="layui-input-block">
              <input type="text" name="packageContent" placeholder="请输入包装含量" autocomplete="off" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item" style="margin-bottom: 0px;">
          <label class="layui-form-label">包装单位</label>
          <div class="layui-input-block">
              <input type="text" name="packingUnit" placeholder="请输入包装单位" autocomplete="off" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item" style="margin-bottom: 0px;">
          <label class="layui-form-label">进货价格</label>
          <div class="layui-input-block">
              <input type="text" name="costPrice" required  lay-verify="required" placeholder="请输入进货价格" autocomplete="off" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item" style="margin-bottom: 0px;">
          <label class="layui-form-label">零售价</label>
          <div class="layui-input-block">
              <input type="text" name="retailPrice" required  lay-verify="required" placeholder="请输入零售价" autocomplete="off" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item" style="margin-bottom: 0px;">
          <label class="layui-form-label">现有库存</label>
          <div class="layui-input-block">
              <input type="number" name="reserve" value="0" placeholder="请输入现有库存" autocomplete="off" class="layui-input">
          </div>
      </div>
      <div class="layui-form-item" style="text-align:center">
          <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
      </div>
  </form>
</div>

<script src="js/page.js"></script>
<script src="js/jquery.min.js"></script>
<script src="layui/layui.js"></script>
<script src="js/page/shop_console.js"></script>

<script type="text/html" id="toolbarDemo">
  <div class="layui-btn-container">
    <button class="layui-btn layui-btn-sm" lay-event="getCheckData">出库</button>
    <button class="layui-btn layui-btn-sm" lay-event="getCheckData">入库</button>
    <button class="layui-btn layui-btn-sm" lay-event="add_products">添加商品</button>
	
  </div>
</script>

<script type="text/html" id="empty_options">
    <div style="display:flex;">
        <div class="layui-btn-container">
            <div class="layui-btn layui-btn-danger">出入库数据以及操作记录数据导出按照月来计算</div>
        </div>
        <div style="display:flex;line-height:38px;margin-left:20px" class="layui-hide" id="select_data">
            <div><input type="text" class="layui-input" id="test1"></div>
            <div style="margin-left:10px"><i class="layui-icon layui-icon-down"></i> </div>
        </div>
    </div>
</script>
</body>
</html>
