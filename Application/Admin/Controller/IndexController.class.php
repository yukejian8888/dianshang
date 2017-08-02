<?php  
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller{
	public function __construct(){
		parent::__construct(); //先执行类的构造方法，避免覆盖重写掉
		layout(false); //不使用布局
	}
	public function index(){
		$this->display();
	}
	public function top(){
		//关闭跟踪信息
		C('SHOW_PAGE_TRACE',false);
		$this->display();
	}
	public function left(){
		//获得管理员会话信息
		$mg_id = session('mg_id');
		$mg_name = session('mg_name');
		//超级管理员获得所有权限
		if($mg_name === 'admin'){
			$authinfoA = D('Auth')->where(array('auth_level'=>0))->select();
			$authinfoB = D('Auth')->where(array('auth_level'=>1))->select();
		}else{
			//普通管理员根据角色获得权限
			//$mg_id作为条件，使sp_manager和sp_role联表查询出角色表中的role_auth_ids
			$roleinfo = D('Manager')->alias('m')->join('__ROLE__ r on m.role_id=r.role_id')->where(array('m.mg_id'=>$mg_id))->field('r.role_auth_ids')->find();
			$auth_ids = $roleinfo['role_auth_ids'];
			//echo $auth_ids; //101,105,102,109﻿
			//根据$auth_ids获得权限信息，一级、二级分开获取
			$authinfoA = D('Auth')->where(array('auth_id'=>array('in',$auth_ids),'auth_level'=>0))->select();
			$authinfoB = D('Auth')->where(array('auth_id'=>array('in',$auth_ids),'auth_level'=>1))->select();
		}
		$this->assign('authinfoA',$authinfoA);
		$this->assign('authinfoB',$authinfoB);
		$this->display();
	}
	public function main(){
		//关闭跟踪信息
		C('SHOW_PAGE_TRACE',false);
		$this->display();
	}
}
?>