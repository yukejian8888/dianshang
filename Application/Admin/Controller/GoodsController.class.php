<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends AdminController{
	public function showList(){
		//设置导航信息
		$navigator = array(
			'first' => '商品管理',
			'second' => '商品列表',
 		);
 		$this->assign('navigator',$navigator);
		//获取数据
		$data = M('Goods')->select();
		//将数据分配给模板
		$this->assign('data',$data);
		//展示模板
		$this->display();
	}
	public function add(){
		//判断请求方式，如果是post，则处理数据保存，否则展示模板
		if(IS_POST){
			//dump($_POST);exit;
			//实现logo图片上传
			$this->deal_logo();
			//处理数据
			$model = D('Goods');
			//调用模型中的方法处理数据
			$post = I('post.');
			//使用插件htmlpurifier特殊处理
			$post['goods_introduce'] = filterXSS($_POST['goods_introduce']);
			//$post = $_POST;
			//dump($post);die;
			//实现logo图片上传
			//dump($_FILES);exit;
			$result = $model->addData($post); //$result新记录主键id值
			//dump($result);die;
			//相册图片上传
			$this->deal_pics($result);

			//实现属性收集入库
			$this->deal_attr($result);
			//判断结果
			if($result){
				//添加成功
				$this->success('添加商品成功!',U('showList'),3);
			}else{
				//添加失败
				$this->error('添加商品失败!',U('add'),3);
			}
		}else{
			//设置导航信息
			$navigator = array(
				'first' => '商品管理',
				'second' => '商品添加',
	 		);
	 		$this->assign('navigator',$navigator);
	 		//获得全部类型信息，给模板使用
	 		$typeinfo = D('Type')->select();
	 		$this->assign('typeinfo',$typeinfo);
			//展示模板
			$this->display();
		}
		
	}
	//商品logo图片上传处理的方法
	private function deal_logo($gid=0){
			//判断logo图片上传没有问题
			if($_FILES['logo']['error'] == 0){
				//修改商品时，要删除该商品原有的物理图片地址
				if($gid!=0){
					//查看商品的原有图片路径名
					$ginfo = D('Goods')->find($gid);
					if(!empty($ginfo['goods_big_logo'])){
						unlink($ginfo['goods_big_logo']);
					}
					if(!empty($ginfo['goods_small_logo'])){
						unlink($ginfo['goods_small_logo']);
					}
				}
				//实例化Upload工具类
				$cfg = array(
					'rootPath' => './Public/Upload/logo/'  //保存根路径
				);
				$up = new \Think\Upload($cfg);
				$z = $up->uploadOne($_FILES['logo']); //上传单个图片
				$_POST['goods_big_logo'] = $up->rootPath.$z['savepath'].$z['savename'];
				//制作缩略图过程
				//1.实例化image类;
				$img = new \Think\Image();
				//2.打开原图
				$img->open($_POST['goods_big_logo']);
				//3.制作缩略图
				$img->thumb(200,200); //图片自适应宽和高
				//拼接缩略图路径
				$smallpathname = $up->rootPath.$z['savepath'].'small_'.$z['savename'];
				//存储small缩略图路径到服务器
				$img->save($smallpathname);
				$_POST['goods_small_logo'] = $smallpathname;		
			}
	}
	//商品相册图片上传处理的公共方法
	private function deal_pics($goods_id){
		//批量上传相册图片
			//判断是否上传相册
			$havepics = false; //默认没有上传相册
			foreach($_FILES['picture']['error'] as $y){
				//判断至少有上传一个相册图片
				if($y == 0){
					$havepics = true;
					break;
				}
			}
			if($havepics ===true){
				$cfgs = array(
				'rootPath' => './Public/Upload/pictures/'
				);
				$ups = new \Think\Upload($cfgs);
				$z2 = $ups->upload(array($_FILES['picture']));
				//给上传的相册图片制作缩略图
				$img2 = new \Think\Image(); //实例化image对象
				//遍历实现制作缩略图
				foreach($z2 as $v2){
					$yuanpic = $ups->rootPath.$v2['savepath'].$v2['savename'];
					$img2->open($yuanpic); //打开被处理图片
					//制作大中小缩略图
					$img2->thumb(800.800);
					$bigname = $ups->rootPath.$v2['savepath'].'big_'.$v2['savename'];
					$img2->save($bigname);
					$img2->thumb(350,340);
					$midname = $ups->rootPath.$v2['savepath'].'mid_'.$v2['savename'];
					$img2->save($midname);
					$img2->thumb(50,50);
					$smallname = $ups->rootPath.$v2['savepath'].'small_'.$v2['savename'];
					$img2->save($smallname);
					//把生成的缩略图名字信息存储给数据表
					$arr['goods_id'] = $goods_id;
					$arr['pics_big'] = $bigname;
					$arr['pics_mid'] = $midname;
					$arr['pics_sma'] = $smallname;
					D('Goods_pics')->add($arr);

				}
			}
	}
	//修改商品信息的方法
	public function update(){
		//被修改商品的id
		$goods_id = I('get.goods_id');
		if(IS_POST){
			//实现logo图片上传
			$this->deal_logo($goods_id);
			//相册图片上传
			$this->deal_pics($goods_id);
			//dump($goods_id);die;
			
			//实现属性信息收集入库
			$this->deal_attr($goods_id);
			//收集商品信息
			$data = I('post.');
			//商品详情要经过XSS防止攻击过滤
			$data['goods_introduce'] = filterXSS($_POST['goods_introduce']);
			//修改商品时间
			$data['upd_time'] = time();
			$z = D('Goods')->save($data); //返回值为受影响记录条数，通常为1
			if($z){
				$this->success('修改商品信息成功!',U('showList'),3);
			}else{
				$this->error('修改商品信息失败!',U('update',array('goods_id',$goods_id)),3);
			}
		}else{
			//设置导航信息
			$navigator = array(
				'first' => '商品管理',
				'second' => '商品修改',
	 		);
	 		$this->assign('navigator',$navigator);
			//根据$goods_id查询被修改商品的基本信息和logo图片
			$goods_info = D('Goods')->find($goods_id);
			$this->assign('goods_info',$goods_info);
			//查询被修改商品的pics相册图片
			$goods_pics = M('Goods_pics')->where(array('goods_id'=>$goods_id))->select();
			//dump($goods_pics);exit;
			$this->assign('goods_pics',$goods_pics);

			//获得全部类型信息，给模板使用
	 		$typeinfo = D('Type')->select();
	 		$this->assign('typeinfo',$typeinfo);
			$this->display();
		} 
	}
	//删除单个相册图片
	function delPics(){
		$pics_id = I('get.pics_id'); //接收被删除相册图片的id
		$pics_info = D('Goods_pics')->find($pics_id);
		//dump($pics_info);die;
		//删除服务器物理图片
		unlink($pics_info['pics_big']);
		unlink($pics_info['pics_mid']);
		unlink($pics_info['pics_sma']);
		//删除数据表记录，返回受影响记录条数
		$z = D('Goods_pics')->delete($pics_id);
		if($z){
			echo json_encode(array('flag'=>0));
		}else{
			echo json_encode(array('flag'=>1));
		}
	}
	//添加/修改商品，定义属性维护公共调用方法
	private function deal_attr($goods_id){
		//修改商品，要先删除原先的属性
		D('Goods_attr')->where(array('goods_id'=>$goods_id))->delete();
		if(!empty($_POST['attr_nm'])){
			foreach($_POST['attr_nm'] as $k => $v){
				//$k是属性的id值
				foreach($v as $kk => $vv){
					$attr_arr['goods_id'] = $goods_id;
					$attr_arr['attr_id'] = $k;
					$attr_arr['attr_value'] = $vv;
					D('Goods_attr')->add($attr_arr);
				}
			}
		}
	}
}  
?>