<?php  
namespace Admin\Controller;
use Think\Controller;
class TypeController extends AdminController{
	//商品类型展示
	public function showlist(){
		//设置导航信息
		$navigator = array(
			'first' => '类型管理',
			'second' => '类型列表',
 		);
 		$this->assign('navigator',$navigator);
		//获得角色表的全部信息
		$info = D('Type')->select(); 
		$this->assign('info',$info);
		//模板展示
		$this->display(); 
	}
	//商品类型添加
	function add(){
		if(IS_POST){
			//根据已有字段执行insert语句
			$data = I('post.');
			$z = D('Type')->add($data);
			//判断添加后的结果
			if($z){
				$this->success('类型添加成功!',U('showlist'),3);
			}else{
				$this->error('类型添加失败',U('add'),3);
			}
		}else{
		//设置导航信息
			$navigator = array(
				'first' => '类型管理',
				'second' => '类型添加',
	 		);
	 		$this->assign('navigator',$navigator);
			$this->display();
		}
		
	}
	
}
?>