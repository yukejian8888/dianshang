<?php  
namespace Home\Controller;
use Think\Controller;
//超市控制器，实现购物车的添加、修改、查看、删除等操作
class ShopController extends Controller{
	//给购物车添加商品
	function addCart(){
		$goods_id = I('get.goods_id'); //被添加商品的id
		$info = D('Goods')->find($goods_id);
		$goods['goods_id'] = $info['goods_id'];
		$goods['goods_name'] = $info['goods_name'];
		$goods['goods_price'] = $info['goods_price']-100; //优惠价
		$goods['goods_buy_number'] = 1;
		$goods['goods_total_price'] = $info['goods_price']-100;
		//实例化购物车类对象
		$cart = new \Tools\Cart();
		//对象调用方法，实现商品添加到购物车
		$cart->add($goods);
		//获得此时购物车商品的“总数量”和“总价格”
		$numberprice = $cart->getNumberPrice();
		echo json_encode($numberprice);
	}
	//修改商品的购买数量
	function changeNum(){
		$goods_id = I('get.goods_id');
		$num = I('get.num');
		//获得购物车类实现数量变化
		$cart = new \Tools\Cart();
		$xiaoji = $cart->changeNumber($num,$goods_id);
		//获得购物车商品总价
		$numberprice = $cart->getNumberPrice();
		//把该商品“小计价格”、“总价格”返回
		echo json_encode(array('xiaoji'=>$xiaoji,'zongji'=>$numberprice['price']));
	}
	//删除购物车商品
	function delCart(){
		$goods_id = I('get.goods_id'); //被删除商品的id
		//通过Cart购物车类实现商品删除
		$cart = new \Tools\Cart();
		$cart->del($goods_id);

		//返回当前最新购物车商品总价
		$numberprice = $cart->getNumberPrice();
		echo json_encode($numberprice);
	}
	//展示购物车商品列表信息
	function flow1(){
		//获得购物车信息
		$cart = new \Tools\Cart();
		//获取信息，返回二维数组
		$goodsinfo = $cart->getCartInfo();
		//dump($goodsinfo);
		//获得购物车商品id的串“25,26”
		$goodsids = implode(',',array_keys($goodsinfo));
		//dump($goodsids); //string(5) "25,26"
		//查询商品图片
		$logos = D('Goods')
			->field('goods_id,goods_small_logo')
			->select($goodsids);
		//dump($logos);
		//把图片logo信息嵌入到$goodsinfo里面
		foreach($goodsinfo as $k=>$v){
			//$k就是商品的goods_id
			foreach($logos as $vv){
				if($k==$vv['goods_id']){
					$goodsinfo[$k]['logo'] = $vv['goods_small_logo'];
				}
			}
		}
		//dump($goodsinfo);
		$this->assign('goodsinfo',$goodsinfo);
		//获得购物车商品的“价格总计”
		$numberprice = $cart->getNumberPrice();
		$this->assign('numberprice',$numberprice);

		//展示模板
		$this->display();
	}
	//生成订单页面
	function flow2(){
		if(IS_POST){
			//收集信息，形成订单
			//1.给sp_order表填充数据
			$shuju1 = I('post.');
			$shuju1['add_time'] = $shuju1['upd_time'] = time();
			$shuju1['user_id'] = session('user_id');
			$shuju1['order_number'] = "itcastshop50-".date("YmdHis")."-".mt_rand(1000,9999);

			//通过Cart购物车类获得商品相关信息
			$cart = new \Tools\Cart();
			$numberprice = $cart->getNumberPrice();
			$shuju1['order_price'] = $numberprice['price']; //总金额
			$order_id = D('order')->add($shuju1); //返回新纪录订单编号
			//2.给sp_order_goods表填充数据
			//获得购物车商品信息
			$carinfo = $cart->getCartInfo();
			foreach($carinfo as $v){
				$shuju2['order_id'] = $order_id;
				$shuju2['goods_id'] = $v['goods_id'];
				$shuju2['goods_price'] = $v['goods_price'];
				$shuju2['goods_number'] = $v['goods_buy_number'];
				$shuju2['goods_total_price'] = $v['goods_total_price'];
				//形成记录
				D('OrderGoods')->add($shuju2);
			}
			//3.清空购物车
			$cart->delall();
			//4.对订单进行支付
			//绘制一个form表单，里边有3个项目，给alipayapi.php提交
			$order_number = $shuju1['order_number']; //订单编号
			$order_name = '苹果手机'.time();  //订单名称
			$total_price = $numberprice['price']; //订单总金额
			$fm = <<<eof
<form id = "order_fm" action="/Public/Plugin/alipay/alipayapi.php" method="post">			
	<input type="hidden" name="WIDout_trade_no" value="$order_number" />
	<input type="hidden" name="WIDsubject" value="$order_name" />
	<input type="hidden" name="WIDtotal_fee" value="$total_price" />
	<input type="hidden" name="WIDbody" value="" />
	<input type="submit" value="提交订单" stylr="display:none" />
</form>
<script type="text/javascript">
	document.getElementById('order_fm').submit();
</script>
eof;
			echo $fm;
		}
		else{
			//判断用户是否有登录系统，并跳转到登录页
			$user_name = session('user_name');
			if(empty($user_name)){			
				//定义回跳地址session，用户登录成功后再跳回来
				session('back_url','Shop/flow2');
				$this->redirect('User/login');
			}
			//获得购物车信息
			$cart = new \Tools\Cart();
			//获取信息，返回二维数组
			$goodsinfo = $cart->getCartInfo();
			//dump($goodsinfo);
			//获得购物车商品id的串“25,26”
			$goodsids = implode(',',array_keys($goodsinfo));
			//dump($goodsids); //string(5) "25,26"
			//查询商品图片
			$logos = D('Goods')
				->field('goods_id,goods_small_logo')
				->select($goodsids);
			//dump($logos);
			//把图片logo信息嵌入到$goodsinfo里面
			foreach($goodsinfo as $k=>$v){
				//$k就是商品的goods_id
				foreach($logos as $vv){
					if($k==$vv['goods_id']){
						$goodsinfo[$k]['logo'] = $vv['goods_small_logo'];
					}
				}
			}
			//dump($goodsinfo);
			$this->assign('goodsinfo',$goodsinfo);
			//获得购物车商品的“价格总计”
			$numberprice = $cart->getNumberPrice();
			$this->assign('numberprice',$numberprice);
			$this->display();
		}
	}
}
?>