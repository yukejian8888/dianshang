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
            <input type="hidden" name="role_id" value="<?php echo ($roleinfo["role_id"]); ?>">
            <table>
                <tr>
                    <td style="font-size: 20px;">为<font style="color: red; font-size: 20px;">[<?php echo ($roleinfo["role_name"]); ?>]</font>分配权限</td>
                </tr>
            </table>
            <table>
                <?php if(is_array($authinfoA)): foreach($authinfoA as $key=>$v): ?><tr>
                    <td style="width: 18%">
                    <input type="checkbox" name="authid[]" value="<?php echo ($v["auth_id"]); ?>" <?php if(in_array(($v["auth_id"]), is_array($roleinfo["role_auth_ids"])?$roleinfo["role_auth_ids"]:explode(',',$roleinfo["role_auth_ids"]))): ?>checked="checked"<?php endif; ?>/> 
                    &nbsp;<?php echo ($v["auth_name"]); ?></td>
                    <td>
                        <?php if(is_array($authinfoB)): foreach($authinfoB as $key=>$vv): if(($vv["auth_pid"]) == $v["auth_id"]): ?><div style="width: 200px; float: left;">
                        <input type="checkbox" name="authid[]" value="<?php echo ($vv["auth_id"]); ?>" <?php if(in_array(($vv["auth_id"]), is_array($roleinfo["role_auth_ids"])?$roleinfo["role_auth_ids"]:explode(',',$roleinfo["role_auth_ids"]))): ?>checked="checked"<?php endif; ?>/>
                        &nbsp;<?php echo ($vv["auth_name"]); ?></div><?php endif; endforeach; endif; ?>
                    </td>
                </tr><?php endforeach; endif; ?>
            </table>
            <input name="" id="btnSubmit" type="submit" class="btn" value="确认保存" />
        </form>
    </div>

</body>
</html>