<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/Public/Admin/js/jquery.js"></script>
    <script type="text/javascript">
    $(function() {
        //导航切换
        $(".menuson li").click(function() {
            $(".menuson li.active").removeClass("active")
            $(this).addClass("active");
        });

        $('.title').click(function() {
            var $ul = $(this).next('ul');
            $('dd').find('ul').slideUp();
            if ($ul.is(':visible')) {
                $(this).next('ul').slideUp();
            } else {
                $(this).next('ul').slideDown();
            }
        });
    })
    </script>
</head>

<body style="background:#f0f9fd;">
    <div class="lefttop"><span></span>※ MENU ※</div>
    <dl class="leftmenu">
        <?php if(is_array($authinfoA)): foreach($authinfoA as $key=>$v): ?><dd>
            <div class="title">
                <span><img src="/Public/Admin/images/leftico01.png" /></span><?php echo ($v["auth_name"]); ?>
            </div>
            <ul class="menuson">
                <?php if(is_array($authinfoB)): foreach($authinfoB as $key=>$vv): if(($vv["auth_pid"]) == $v["auth_id"]): ?><li>
                    <cite></cite><a href="/index.php/Admin/<?php echo ($vv["auth_c"]); ?>/<?php echo ($vv["auth_a"]); ?>" target="rightFrame"><?php echo ($vv["auth_name"]); ?></a><i></i>
                </li><?php endif; endforeach; endif; ?>
            </ul>
        </dd><?php endforeach; endif; ?>
    </dl>
</body>

</html>