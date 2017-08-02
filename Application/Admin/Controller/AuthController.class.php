<?php  
namespace Admin\Controller;
use Think\Controller;
class AuthController extends AdminController{
	//角色列表展示
	public function showlist(){
		//设置导航信息
		$navigator = array(
			'first' => '权限管理',
			'second' => '权限列表',
 		);
 		$this->assign('navigator',$navigator);
		//获得角色表的全部信息
		$info = D('Auth')->order('auth_path')->select(); //根据auth_path全路径排序
		$this->assign('info',$info);
		//模板展示
		$this->display(); 
	}
	//添加权限
	function add(){
		if(IS_POST){
			//根据已有字段执行insert语句
			$data = I('post.');
			$newid = D('Auth')->add($data);
			//通过算法计算path和level
			if($data['auth_pid']==0){
				//顶级权限
				$path = $newid;
			}else{
				//非顶级权限 path=父path-$newid
				//先获取父级path
				$pinfo = D('Auth')->find($data['auth_pid']);
				$ppath = $pinfo['auth_path']; //父级全路径
				//组装自己的path
				$path = $ppath."-".$newid;
			}
			//维护level，等于全路径里-的个数
			$level = substr_count($path,'-');
			//执行update更新语句
			$arr['auth_id'] = $newid;
			$arr['auth_path'] = $path;
			$arr['auth_level'] = $level;
			$z = D('Auth')->save($arr);
			//判断添加后的结果
			if($z){
				$this->success('添加权限成功!',U('showlist'),3);
			}else{
				$this->error('添加权限失败',U('add'),3);
			}
		}else{
		//设置导航信息
			$navigator = array(
				'first' => '权限管理',
				'second' => '添加权限',
	 		);
	 		$this->assign('navigator',$navigator);
			$topauth = D('Auth')->where(array('auth_level'=>0))->select();
			$this->assign('topauth',$topauth);
			$this->display();
		}
		
	}
	
}
?>