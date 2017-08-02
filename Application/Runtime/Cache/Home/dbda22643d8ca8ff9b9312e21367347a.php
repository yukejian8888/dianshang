<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>登录商城</title>
	<link rel="stylesheet" href="/Public/Home/style/base.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/global.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/header.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/login.css" type="text/css">
	<link rel="stylesheet" href="/Public/Home/style/footer.css" type="text/css">

	<script type="text/javascript" src="/Public/Home/js/jquery-1.8.3.min.js"></script>
</head>
<body>
	<!-- 顶部导航 start -->
	<div class="topnav">
		<div class="topnav_bd w990 bc">
			<div class="topnav_left">
				
			</div>
			<div class="topnav_right fr">
				<ul>
					<?php if(!empty($_SESSION['user_name'])): ?><li>您好,<span style="font-size:20px; color:red;"><?php echo (session('user_name')); ?>&nbsp;</span>欢迎来到京西！[<a href="<?php echo U('User/logout');?>">退出</a>]</li>
					<?php else: ?>
						<li>您好，欢迎来到京西！[<a href="<?php echo U('User/login');?>">登录</a>] [<a href="<?php echo U('User/register');?>">免费注册</a>] </li><?php endif; ?>

					<li>我的订单</li>
					<li class="line">|</li>
					<li>客户服务</li>

				</ul>
			</div>
		</div>
	</div>
	<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>

	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="index.html"><img src="/Public/Home/images/logo.png" alt="京西商城"></a></h2>
			<?php if((CONTROLLER_NAME) == "Shop"): ?><div class="flow fr <?php echo (ACTION_NAME); ?>"> 
				<ul>
					<li <?php if((ACCTION_NAME) == "flow1"): ?>class="cur"<?php endif; ?>>1.我的购物车</li>
					<li <?php if((ACCTION_NAME) == "flow2"): ?>class="cur"<?php endif; ?>>2.填写核对订单信息</li>
					<li <?php if((ACCTION_NAME) == "flow3"): ?>class="cur"<?php endif; ?>>3.成功提交订单</li>
				</ul>
			</div><?php endif; ?>
		</div>
	</div>
	<!-- 页面头部 end -->
	

	<link rel="stylesheet" href="/Public/Home/style/cart.css" type="text/css">
	<!--script type="text/javascript" src="/Public/Home/js/cart1.js"></script-->
	
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
	<div class="mycart w990 mt10 bc">
		<h2><span>我的购物车</span></h2>
		<table>
			<thead>
				<tr>
					<th class="col1">商品名称</th>
					<th class="col3">单价</th>
					<th class="col4">数量</th>	
					<th class="col5">小计</th>
					<th class="col6">操作</th>
				</tr>
			</thead>
			<tbody>
<?php if(is_array($goodsinfo)): foreach($goodsinfo as $key=>$v): ?><tr id="cart_goods_tr_<?php echo ($v["goods_id"]); ?>">
		<td class="col1"><a href="<?php echo U('Goods/detail',array('goods_id'=>$v['goods_id']));?>"><img src="http://www.itcast.biz/<?php echo (substr($v["logo"],2)); ?>" style="width: 120px;height:90px;" alt="" /></a>  <strong><a href=""><?php echo ($v["goods_name"]); ?></a></strong></td>
		<td class="col3">￥<span><?php echo ($v["goods_price"]); ?></span></td>
		<td class="col4"> 
			<span onclick="change_number('red',<?php echo ($v["goods_id"]); ?>);" class="reduce_num" style="cursor: pointer;"></span>
			<input type="text" onchange="change_number('mod',<?php echo ($v["goods_id"]); ?>)" name="amount" value="<?php echo ($v["goods_buy_number"]); ?>" class="amount" id="cart_goods_num_<?php echo ($v["goods_id"]); ?>" />
			<span onclick="change_number('add',<?php echo ($v["goods_id"]); ?>);" class="add_num" style="cursor: pointer;"></span>
		</td>
		<td class="col5">￥<span id="xiaoji_<?php echo ($v["goods_id"]); ?>"><?php echo ($v["goods_total_price"]); ?></span></td>
		<td class="col6"><a href="javascript:;" onclick="if(confirm('您确定要删除该商品吗?')){del_cart(<?php echo ($v["goods_id"]); ?>)}">删除</a></td>
	</tr><?php endforeach; endif; ?>
<script type="text/javascript">
//删除购物车商品
function del_cart(goods_id){
	//ajax调用服务器删除
	$.ajax({
		url:"<?php echo U('delCart');?>",
		data:{'goods_id':goods_id},
		dataType:'json',
		type:'get',
		success:function(msg){
			$('#total').html(msg.price);  //接收删除后的商品总价并显示给页面
			$('#cart_goods_tr_'+goods_id).remove(); //删除页面上商品的tr元素
		}
	});
}
</script>
<script type="text/javascript">
function change_number(flag,goods_id){
	//购物车商品数量变化（增/减/手动修改）操作
	var num = parseInt($('#cart_goods_num_'+goods_id).val());
	if(flag==='add'){
		//①增加数量
		num++;
	}else if(flag==='red'){
		//②减少数量
		if(num<=1){
			alert('数量至少为1!');
			return false;
		}
		num--;
	}else if(flag==='mod'){
		//③手动修改数量
		var s_num = num + "";
		//通过正则对输入的数字进行限制
		var pat = /^[1-9]\d?$/;
		if(s_num.match(pat)===null){
			alert('修改的数量不合法!');
			window.location.href = window.location.href; //页面刷新
			return false;
		}
	}else{
		alert('参数不正确!');
		return false;
	}
	//ajax触发服务器端，使得购物车数量发生了变化
	$.ajax({
		url:"<?php echo U('changeNum');?>",
		data:{'goods_id':goods_id,'num':num},
		dataType:'json',
		type:'get',
		success:function(msg){
			//更新购买数量到页面上
			$('#cart_goods_num_'+goods_id).val(num);
			//把msg的小计价格、总价显示到页面
			$('#xiaoji_'+goods_id).html(msg.xiaoji);
			$('#total').html(msg.zongji);
		}
	});
}

</script>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6">购物金额总计： <strong>￥ <span id="total"><?php echo ($numberprice["price"]); ?></span></strong></td>
				</tr>
			</tfoot>
		</table>
		<div class="cart_btn w990 bc mt10">
			<a href="" class="continue">继续购物</a>
			<a href="<?php echo U('Shop/flow2');?>" class="checkout">结 算</a>
		</div>
	</div>
	<!-- 主体部分 end -->

	<div style="clear:both;"></div>
	
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt15">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="/Public/Home/images/xin.png" alt="" /></a>
			<a href=""><img src="/Public/Home/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="/Public/Home/images/police.jpg" alt="" /></a>
			<a href=""><img src="/Public/Home/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->

</body>
</html>