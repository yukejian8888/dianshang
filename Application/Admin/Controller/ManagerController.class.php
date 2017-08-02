<?php  
namespace Admin\Controller;
use Think\Controller;
class ManagerController extends AdminController{
	//登录方法
	public function login(){
		if(IS_POST){
			//接收并检验用户名,密码
			$pinfo = I('post.');
			$mg_name = $pinfo['mg_name'];
			$mg_pwd = $pinfo['mg_pwd'];
			//用户名和密码正确就返回整条记录的所有信息，失败返回null
			$userinfo = D('Manager')->where(array('mg_name'=>$mg_name,'mg_pwd'=>$mg_pwd))->find();
			if($userinfo){
				//session持久化用户名
				session('mg_name',$userinfo['mg_name']);
				session('mg_id',$userinfo['mg_id']); //session记录mg_id
				$this->redirect('Index/index');
			}else{
				$this->error('用户名或密码错误',U('Manager/login'),3);
			}
		}
		//展示模板
		$this->display();
	}
	//退出方法
	function logout(){
		//销毁session
		session(null);
		$this->redirect('login');
	}
}
?>