
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- Viewport metatags -->
    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="320" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <link rel="stylesheet" type="text/css" href="<?=__ROOT__  ?>/public/css/dandelion.css"  media="screen" />

    <title>404错误</title>

</head>
<script>
    window.setTimeout("window.location.href='/index.php/home/index'", 3000);
</script>
<body>
<input type="text" id="errorInfo" value="<?=$e['file'].$e['line'].$e['message']?>"/>
<!-- Main Wrapper. Set this to 'fixed' for fixed layout and 'fluid' for fluid layout' -->
<div id="da-wrapper" class="fluid">

    <!-- Content -->
    <div id="da-content">

        <!-- Container -->
        <div class="da-container clearfix">

            <div id="da-error-wrapper">

                <div id="da-error-pin"></div>
                <div id="da-error-code">
                    error <span>404</span>                    </div>

                <h1 class="da-error-heading">哎哟喂！页面让狗狗叼走了！</h1>
                <p>大家可以到狗狗没有叼过的地方看看！ <a href="/index.php/home/index/">点击进入首页</a></p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div id="da-footer">
        <div class="da-container clearfix">
            <p> Copyright © 2017 All Reserved Powered By <a href="http://www.sunbirddata.com.cn/" target="_blank">SunBirdata</a></div>
    </div>
</div>

</body>
</html>
