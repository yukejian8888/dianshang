<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
</head>
<body>
	<div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><?php echo ($navigator["first"]); ?></li>
            <li><?php echo ($navigator["second"]); ?></li>
        </ul>
    </div>
    <div class="formbody">
        <form action="" method="post" enctype="multipart/form-data">
            <ul class="forminfo" id="general-cont" style="margin:3px;">
                <li>
                    <label>权限名称</label>
                    <input name="auth_name" placeholder="请输入权限名称" type="text" class="dfinput" /><i>名称不能超过30个字符</i></li>
                <li>
                    <label>权限上级</label>
                    <select name="auth_pid">
                        <option value="0">请选择</option>
                        <?php if(is_array($topauth)): foreach($topauth as $key=>$v): ?><option value="<?php echo ($v["auth_id"]); ?>"><?php echo ($v["auth_name"]); ?></option><?php endforeach; endif; ?>
                    </select>
                </li>
                <li>
                    <label>控制器</label>
                    <input name="auth_c" placeholder="请输入控制器" type="text" class="dfinput" />
                </li>
                <li>
                    <label>操作方法</label>
                    <input name="auth_a" placeholder="请输入操作方法" type="text" class="dfinput" />
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="submit" class="btn" value="确认保存" />
                </li              
             
            </ul>
        </form>
    </div>




</body>
</html>