<?php  
namespace Admin\Controller;
use Think\Controller;
class AttributeController extends AdminController{
	//商品属性展示
	public function showlist(){
		//设置导航信息
		$navigator = array(
			'first' => '属性管理',
			'second' => '属性列表',
 		);
 		$this->assign('navigator',$navigator);
		//获得全部的类型信息
		$typeinfo = D('Type')->select(); 
		$this->assign('typeinfo',$typeinfo);
		//模板展示
		$this->display(); 
	}
	//商品属性添加
	function add(){
		if(IS_POST){
			$attribute = new \Admin\Model\AttributeModel();
			$data = $attribute->create(); //数据收集同时还有验证功能 返回实体数组，表示验证没有问题
			//返回false，验证出现问题
			if($data){
				//给可选值得连接"逗号"做兼容处理
				$data['attr_vals'] = str_replace("，",",",$data['attr_vals']);
			
				$z = $attribute->add($data);
				//判断结果
				if($z){
					$this->success('属性添加成功!',U('showlist'),3);
				}else{
					$this->error('属性添加失败',U('add'),3);
				}
				exit;
			}else{
				//输出验证时的错误信息
				dump($attribute->getError());
			}
		}
		//设置导航信息
			$navigator = array(
				'first' => '属性管理',
				'second' => '属性添加',
	 		);
	 		$this->assign('navigator',$navigator);
	 		//获得可供选取的类型，给模板使用
	 		$typeinfo = D('Type')->select();
	 		$this->assign('typeinfo',$typeinfo);
			$this->display();	
	}
	//在属性列表处，根据类型获得对应的属性列表信息
	function getAttrInfo(){
		$type_id = I('get.type_id'); //获得类型id
		//dump($type_id);
		if($type_id>0){
			//①有具体的$type_id
			//ap_attribute和sp_type做联表查询
			$attrinfo = D('Attribute')
				->alias('a')
				->join('__TYPE__ t on a.type_id=t.type_id')
				->where(array('a.type_id'=>$type_id))
				->field('a.*,t.type_name')
				->select();
		}else{
			//②没有传递$type_id。获得全部的属性列表
			$attrinfo = D('Attribute')
				->alias('a')
				->join('__TYPE__ t on a.type_id=t.type_id')
				->field('a.*,t.type_name')
				->select();
		}
		echo json_encode($attrinfo);
	}	

	//在添加商品处，根据类型获得对应的属性列表信息
	 function getAttrInfo2(){
        $type_id = I('get.type_id');//获得类型id
        //根据$type_id获得对应的属性列表信息
            //sp_attribute和sp_type做联表查询
        $where['type_id'] = $type_id;
        $attrinfo = D('Attribute')
				->where(array('type_id'=>$type_id))
				// ->where($where)
				->select();
        echo json_encode($attrinfo);
    }

    //在修改商品处，根据类型获得对应的属性列表信息
	function getAttrInfo3(){
		$type_id = I('get.type_id'); //获得类型id
		$goods_id = I('get.goods_id'); //被修改商品id
		//根据$type_id做条件查询，判断获得属性是实体的还是空壳的
		//返回值为array，就获得实体属性，否则获得空壳属性
		$goodsinfo = D('Goods')
			->where(array('goods_id'=>$goods_id,'type_id'=>$type_id))
			->find();
			//根据类型获得属性
		if($goodsinfo){
			$attrinfo = D('Goods_attr')
				->alias('ga')
				->join('__ATTRIBUTE__ a on ga.attr_id=a.attr_id')
				->field('ga.attr_id,group_concat(ga.attr_value) as atvalues,a.attr_name,a.attr_sel,a.attr_vals')
				->where(array('a.type_id'=>$type_id,'ga.goods_id'=>$goods_id))
				->group('a.attr_id')
				->select();
				$attrinfo['flag'] = 0; //代表返回实体属性
				echo json_encode($attrinfo);
		}else{
			//获得空壳属性
			$attrinfo = D('Attribute')
				->where(array('type_id'=>$type_id))
				->select();
			$attrinfo['flag'] = 1; //代表返回空壳属性

			echo json_encode($attrinfo);
		}
	}	
}
?>