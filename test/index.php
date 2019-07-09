<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>后台</title>
  <meta name="description" content="particles.js is a lightweight JavaScript library for creating particles.">
  <meta name="author" content="Vincent Garreau" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link rel="stylesheet" media="screen" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/reset.css"/>
</head>
<body>

<div id="particles-js">
		<div class="login">
            <div class="message" id="message"></div>
			<div class="login-top">
				库存表-用户登录
			</div>
			<div class="login-center clearfix">
				<div class="login-center-img"><img src="image/name.png"/></div>
				<div class="login-center-input">
					<input type="text" id="username" placeholder="请输入您的用户名" onfocus="this.placeholder=''" onblur="this.placeholder='请输入您的用户名'"/>
					<div class="login-center-input-text">用户名</div>
				</div>
			</div>
			<div class="login-center clearfix">
				<div class="login-center-img"><img src="image/password.png"/></div>
				<div class="login-center-input">
					<input type="password" id="password" placeholder="请输入您的密码" onfocus="this.placeholder=''" onblur="this.placeholder='请输入您的密码'"/>
					<div class="login-center-input-text">密码</div>
				</div>
			</div>
			<div class="login-button">
				登陆
			</div>
		</div>
		<div class="sk-rotating-plane"></div>
</div>

<!-- scripts -->
<script src="js/particles.min.js"></script>
<script src="js/app.js"></script>
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
	function hasClass(elem, cls) {
	  cls = cls || '';
	  if (cls.replace(/\s/g, '').length == 0) return false; //当cls没有参数时，返回false
	  return new RegExp(' ' + cls + ' ').test(' ' + elem.className + ' ');
	}

	function addClass(ele, cls) {
	  if (!hasClass(ele, cls)) {
	    ele.className = ele.className == '' ? cls : ele.className + ' ' + cls;
	  }
	}

	function removeClass(ele, cls) {
	  if (hasClass(ele, cls)) {
	    var newClass = ' ' + ele.className.replace(/[\t\r\n]/g, '') + ' ';
	    while (newClass.indexOf(' ' + cls + ' ') >= 0) {
	      newClass = newClass.replace(' ' + cls + ' ', ' ');
	    }
	    ele.className = newClass.replace(/^\s+|\s+$/g, '');
	  }
	}
		document.querySelector(".login-button").onclick = function(){
				var username = $("#username").val().trim();
                var password = $("#password").val().trim();
                if(username == "" || password == "")
                {
                    alert("请填写完整")
                }else {
                    $.ajax({
                    type: 'POST',
                    data: {'username':username,'password':password},
                    dataType:'json',
                    url: "../res/do_login.php",
                    success: function (data) {
                        console.log(data);
                        if(data[1]){
                            window.location.href="stock_user.php?id="+data[0];
                        }else {
                            $("#message").html(data[0]);
                            setTimeout(function(){
                                $("#message").html("");
                            },1000);
                        }
                    },
                    fail: function (err) {
                      console.log(err);
                    }
                  });
                }
		}
</script>
</body>
</html>
