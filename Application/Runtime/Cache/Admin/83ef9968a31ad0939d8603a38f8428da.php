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
        <ul class="forminfo" id="general-cont" >
            <li>
                <label style="width: 120px;">属性名称:</label>
                <input name="attr_name" placeholder="请输入属性名称" type="text" style="border: 1px solid #ccc;" />&nbsp;&nbsp;<span style="display:inline; color:red;">*</span><i>名称不能超过30个字符</i> 
            </li>
            <li>
                <label style="width: 120px;">所属商品类型:</label>
                <select name="type_id" style="border: 1px solid #ccc;">
                    <option value="0">请选择</option>
                    <?php if(is_array($typeinfo)): foreach($typeinfo as $key=>$v): ?><option value="<?php echo ($v["type_id"]); ?>"><?php echo ($v["type_name"]); ?></option><?php endforeach; endif; ?>
                </select>&nbsp;&nbsp;<span style="display:inline; color:red;">*</span>
            </li>
            <li>
                <label style="width: 120px;">属性是否可选:</label>
                <input name="attr_sel" type="radio" value="0" checked="checked" />唯一属性
                <input name="attr_sel" type="radio" value="1" />单选属性
            </li>
            <li>
                <label style="width: 120px;">该属性值得录入方式:</label>
                <input name="attr_write" type="radio" value="0" checked="checked" />手工录入
                <input name="attr_write" type="radio" value="0" />从下面的列表中选择
            </li>
             <li>
                <label style="width: 120px;">可选值列表:</label>
                <textarea name="attr_vals" style="width: 400px;height: 100px;border: 1px solid #ccc;"></textarea><i>多个属性值通过"英文输入法逗号"分隔,例如"白色,黑色,粉色,金色"</i>
            <li>
                <label style="width: 120px;">&nbsp;</label>
                <input name="" id="btnSubmit" type="submit" class="btn" value="确认保存" />
            </li>              
        </ul>
    </form>
</div>




</body>
</html>