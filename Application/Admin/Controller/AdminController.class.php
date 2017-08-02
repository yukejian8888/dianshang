<?php  
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller{
	public function __construct(){
		parent::__construct(); //先执行父类的构造方法，避免给其覆盖
		$mg_id = session('mg_id');
		$mg_name = session('mg_name');
		//禁止越权访问控制实现
		//把当前访问的控制器操作方法获得出来，去用户的权限列表中做对比
		$nowac = CONTROLLER_NAME.'-'.ACTION_NAME;
		//没有登陆系统的用户也可以访问的权限
		$keyiAC = "Manager-login,Manager-verifyImg";
		//①用户没有登陆系统
		//②其访问的也不是允许的权限
		if(empty($mg_name) && strpos($keyiAC,$nowac)===false){
			//$this->redirect('Manager/login');
			$js = <<<eof
				<script type="text/javascript">
					window.top.location="/index.php/Admin/Manager/login";
				</script>
eof;
		}else{


		//根据$mg_id获得用户角色的权限列表
		$roleinfo = D('Manager')
			->alias('m')
			->join('__ROLE__ r on m.role_id=r.role_id')
			->field('r.role_auth_ac')
			->where(array('m.mg_id'=>$mg_id))
			->find();
		$acs = $roleinfo['role_auth_ac'];
		//dump($acs); //string(87) "Category-showlist,Goods-showlist,Goods-tianjia,Order-showlist,Order-dayin,Order-tianjia"
		//$nowac去$acs的字符串中做对比
		//系统默认允许的访问权限
		$allowAc = "Manager-login,Manager-logout,Manager-verifyImg,Index-index,Index-left,Index-top,Index-main";
		if(strpos($acs,$nowac)===false && strpos($allowAc,$nowac)===false && $mg_name!=='admin'){
			exit('禁止越权访问');
		}
		}
	}
}
?>