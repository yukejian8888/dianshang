<?php  
namespace Admin\Model;
use Think\Model;
class AttributeModel extends Model{
	// 是否批处理验证
    protected $patchValidate    =   true;
    //给添加数据的form表单实现表单域校验功能
    // 自动验证定义
    protected $_validate        =   array(
    	array('attr_name','require','属性名称必须设置'),
    	array('type_id',0,'类型必须选取',0,'notequal'),
    );  
}
?>