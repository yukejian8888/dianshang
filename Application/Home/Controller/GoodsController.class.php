<?php  
namespace Home\Controller;
use Think\Controller;
class GoodsController extends Controller{
	//商品列表页面
	public function showList(){
		//获得商品列表信息
		$info = D('Goods')
			->where(array('is_del'=>'0'))
			->order('goods_id desc')
			->select();
		$this->assign('info',$info);
		$this->display();
	} 
	//商品详情页面
	public function detail(){
		$goods_id = I('get.goods_id'); //被查看的商品的id
		//获得商品基本信息
		$goodsinfo = D('Goods')->find($goods_id);
		//dump($goodsinfo);
		$this->assign('goodsinfo',$goodsinfo);
		//获得商品拥有的“多选”属性
		$attrinfos = D('Goods_attr')
			->alias('ga')
			->join('__ATTRIBUTE__ a on ga.attr_id=a.attr_id')
			->where(array('a.attr_sel'=>'1','ga.goods_id'=>$goods_id))
			->group('a.attr_id')
			->field('a.attr_id,a.attr_name,GROUP_CONCAT(ga.attr_value) atvalues')
			->select();
			//dump($attrinfos);
			//整合$attrinfos数组，把属性值拆分为array数组的效果
		foreach($attrinfos as $k=>$v){
			$attrinfos[$k]['attrvals'] = explode(',',$v['atvalues']);
		}
		//dump($attrinfos);
		$this->assign('attrinfos',$attrinfos);
		//获得商品拥有的“单选”属性
		$attrinfo = D('Goods_attr')
			->alias('ga')
			->join('__ATTRIBUTE__ a on ga.attr_id=a.attr_id')
			->where(array('a.attr_sel'=>'0','ga.goods_id'=>$goods_id))
			->group('a.attr_id')
			->field('a.attr_id,a.attr_name,ga.attr_value')
			->select();
		$this->assign('attrinfo',$attrinfo);

		//获得商品的相册图片信息
		$picsinfo = D('GoodsPics')
			->where(array('goods_id'=>$goods_id))
			->select();
		$this->assign('picsinfo',$picsinfo);
		$this->display();
	}
}
?>