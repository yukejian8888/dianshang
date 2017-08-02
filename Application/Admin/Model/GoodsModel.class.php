<?php  
//声明命名空间
namespace Admin\Model;
//引入类
use Think\Model;
//声明类并且继承父类
class GoodsModel extends Model{
	//添加保存数据
	public function addData($data){
		//dump($data);die;
		//补全数据add_time,upd_time
		$data['add_time'] = $data['upd_time'] = time();
		//将数据保存到数据表中去
		return $this->add($data);
	}
}
?>