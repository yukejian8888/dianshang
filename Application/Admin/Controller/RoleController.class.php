<?php  
namespace Admin\Controller;
use Think\Controller;
class RoleController extends AdminController{
	//角色列表展示
	public function showlist(){
		//设置导航信息
		$navigator = array(
			'first' => '权限管理',
			'second' => '角色列表',
 		);
 		$this->assign('navigator',$navigator);
		//获得角色表的全部信息
		$info = D('Role')->select();
		$this->assign('info',$info);
		//模板展示
		$this->display();
	}
	//分配权限
	public function distribute(){
		if(IS_POST){
			//dump($_POST);
			//制作role_auth_ids数据
			$authids = implode(',',$_POST['authid']);
			//根据$authids制作auth_ac
			$authinfo = D('Auth')->where(array('auth_level'=>array('gt',0),'auth_id'=>array('in',$authids)))->select();
			//dump($authinfo);
			$s = '';
			foreach($authinfo as $v){
				$s .= $v['auth_c'].'-'.$v['auth_a'].',';
			}
			//dump($s);
			$s = rtrim($s,','); //取出最右边','
			//dump($s);
			$arr[role_id] = $_POST['role_id'];
			$arr['role_auth_ids'] = $authids;
			$arr['role_auth_ac'] = $s;
			$z = D('Role')->save($arr);
			if($z){
				$this->success('分配权限成功!',U('showlist'),3);
			}else{
				$this->error('分配权限失败!',U('distribute',array('role_id'=>$arr['role_id'])),3);
			}

		}else{
			//设置导航信息
			$navigator = array(
				'first' => '权限管理',
				'second' => '分配权限',
	 		);
	 		$this->assign('navigator',$navigator);
			//获得被分配权限的角色信息
			$role_id = I('get.role_id');
			$roleinfo = D('Role')->find($role_id);
			$this->assign('roleinfo',$roleinfo);
			//获得全部可以用于分配的权限信息
			$authinfoA = D('Auth')->where(array('auth_level'=>0))->select();
			$authinfoB = D('Auth')->where(array('auth_level'=>1))->select();
			$this->assign('authinfoA',$authinfoA);
			$this->assign('authinfoB',$authinfoB);
			//展示分配权限的表单页面
			$this->display();
		}
	}
}
?>