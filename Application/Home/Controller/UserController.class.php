<?php
//声明命名空间
namespace Home\Controller;
//引入类
use Think\Controller;
//声明类并继承父类
class UserController extends Controller{
	//创建登录方法
	public function login(){
			if(IS_POST){
			//1.接收表单提交的验证码
			$code = I('post.code');
			//2.检测该验证码的正确性
			$v = new \Think\Verify();
			if (!$v->check($code)) {
				$this->error('验证码不正确', U('login'), 3);
			}
			//接收用户名和密码
			$user_name = I('post.user_name');
			$user_pwd = I('post.user_pwd');
			//校验正确
			$userinfo = D('User')
				->where(array('user_name'=>$user_name,'user_pwd'=>$user_pwd))
				->find();
			//dump($userinfo);
			if($userinfo){
				//session持久化用户信息
				session('user_id',$userinfo['user_id']);
				session('user_name',$userinfo['user_name']);

				//判断用户是否存在回跳地址
				$back_url = session('back_url');
				if(!empty($back_url)){
					session('back_url',null); //销毁回跳地址
					$this->redirect($back_url);
				}
				$this->redirect('Index/index');
			}else{
				$this->error('用户名或密码错误!',U('login'));
			}
			
		}
		//模板展示
		$this->display();
	}
	//创建注册方法
	public function register(){
		//模板展示
		$this->display();
	}
	function verifyImg()
	{
		$arr = array(
			/*'imageH' => 38,
            'imageW' => 75,*/
				'fontSize' => 15,
				'useCurve' => false,
				'useNoise' => false,
				'length' => 4,
				'fontttf' => '4.ttf'
		);
		$v = new \Think\Verify($arr);
		$v->entry();
	}
	public function logout(){
		session(null);
		$this->redirect('Index/index');
	}
}
?>