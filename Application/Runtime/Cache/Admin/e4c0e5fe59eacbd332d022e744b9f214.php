<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/Public/Admin/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/Public/Admin/js/jquery.js"></script>
</head>
<body>
	<div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><?php echo ($navigator["first"]); ?></li>
            <li><?php echo ($navigator["second"]); ?></li>
        </ul>
    </div>
    <script type="text/javascript" charset="utf-8" src="/Public/Admin/plugin/ue/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/Public/Admin/plugin/ue/ueditor.all.min.js"> </script>
    <script type="text/javascript" charset="utf-8" src="/Public/Admin/plugin/ue/lang/zh-cn/zh-cn.js"></script>
    <div class="formbody">
    <style type="text/css">
        #tabbar-div {
            background: #80bdcb none repeat scroll 0 0;
            height: 27px;
            padding-left: 10px;
            padding-top: 1px;
        }
        #tabbar-div p {
            margin: 2px 0 0;

        }
        .tab-front {
            background: #bbdde5 none repeat scroll 0 0;
            border-right: 2px solid #278296;
            cursor: pointer;
            font-weight: bold;
            line-height: 20px;
            padding: 4px 15px 4px 18px;
            display: inline;
        }
        .tab-back {
            border-right: 1px solid #fff;
            color: #fff;
            cursor: pointer;
            line-height: 20px;
            padding: 4px 15px 4px 18px;
            display: inline;
        }
    </style>
    <script>
        $(function(){
            $('#tabbar-div span').click(function(){
                $('#tabbar-div span').attr('class','tab-back'); //全部标签变暗
                $(this).attr('class','tab-front'); //当前被点击的标签变亮
                //标签对应的内容切换
                $('ul.forminfo[id]').hide(); //全部内容区域隐藏
                var spanid = $(this).attr('id');
                var marks = spanid.split('-');
                var mark = marks[0];
                $("#"+mark+"-cont").show();
            });
        });
    </script>
        <div id="tabbar-div">
            <p>
            <span id="general-tab" class="tab-front">通用信息</span>
            <span id="detail-tab" class="tab-back">详细描述</span>
            <span id="mix-tab" class="tab-back">其他信息</span>
            <span id="properties-tab" class="tab-back">商品属性</span>
            <span id="gallery-tab" class="tab-back">商品相册</span>
            <span id="linkgoods-tab" class="tab-back">关联商品</span>
            <span id="groupgoods-tab" class="tab-back">配件</span>
            <span id="article-tab" class="tab-back">关联文章</span>
            </p>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="goods_id" value="<?php echo ($goods_info["goods_id"]); ?>">
            <ul class="forminfo" id="general-cont" style="margin:3px;">
                <li>
                    <label>商品名称</label>
                    <input name="goods_name" placeholder="请输入商品名称" type="text" class="dfinput" value="<?php echo ($goods_info["goods_name"]); ?>" /><i>名称不能超过30个字符</i></li>
                <li>
                    <label>商品价格</label>
                    <input name="goods_price" placeholder="请输入商品价格" type="text" class="dfinput" value="<?php echo ($goods_info["goods_price"]); ?>" /><i></i></li>
                <li>
                    <label>商品数量</label>
                    <input name="goods_number" placeholder="请输入商品数量" type="text" class="dfinput" value="<?php echo ($goods_info["goods_number"]); ?>" />
                </li>
                <li>
                    <label>商品重量</label>
                    <input name="goods_weight" placeholder="请输入商品重量" type="text" class="dfinput" value="<?php echo ($goods_info["goods_weight"]); ?>" />
                </li>
                 <li>
                    <label>商品logo图片</label>
                    <input name="logo"  type="file" />
                    <img src="http://www.itcast.biz/<?php echo (substr($goods_info["goods_small_logo"],2)); ?>" alt="" />
                </li>               
                <li><label>是否展示</label><cite><input name="is_del" type="radio" value="0" checked="checked" />是&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="is_del" type="radio" value="1" />否</cite></li>               
            </ul>
            <ul class="forminfo" id="detail-cont" style="display: none;">
                <li>
                    <label>商品描述<textarea id="ueditor" name="goods_introduce" placeholder="请输入商品描述" cols="" rows="" style="width:666px; height: 333px;" ><?php echo ($goods_info["goods_introduce"]); ?></textarea></label>      
                </li>
            </ul>
            <ul class="forminfo" id="mix-cont" style="display: none;">
                <li>
                    其他信息    
                </li>
            </ul>
<style type="text/css">
.bdr{border:1px solid black;}
</style>
<script>
//根据类型获得属性
function get_attr_info3(){
    var type_id = $('#type_id').val(); //被选中类型
    var goods_id = $('[name=goods_id]').val(); //被修改商品id
    //console.log(goods_id);
    //ajax去服务器端获得属性信息
    $.ajax({
        url:"<?php echo U('Attribute/getAttrInfo3');?>",
        data:{'type_id':type_id,'goods_id':goods_id},
        dataType:'json',
        type:'get',
        success:function(msg){
            console.log(msg);
            //遍历msg，并与"html标签"结合显示到页面上
            var html = "";
            if(msg.flag==0){
                //展示实体属性
                $.each(msg,function(i,n){
                    //两种表单域类型:输入框 下拉列表
                if(i!='flag'){
                    if(n.attr_sel==0){
                        //① 输入框
                        html += '<li> '+n.attr_name+'： <input name="attr_nm['+n.attr_id+'][]" type="text"  class="bdr" value="'+n.atvalues+'"/> </li>';
                    }else{
                        //② 下拉列表
                        //对“属性值”做拆分遍历，以便显示多个下拉列表
                        var vals = n.atvalues.split(','); //Spring-->Array;
                        $.each(vals,function(a,b){
                            //设置下拉列表前边的[+]/[-]符号
                            if(a==0){
                                 html += '<li><b onclick="add_attr_item(this)">[+]</b>';

                            }else{
                                html += '<li><b onclick="$(this).parent().remove()">[-]</b>';
                                
                            }
                         html += n.attr_name+'： <select name="attr_nm['+n.attr_id+'][]" class="bdr" > <option value="0">-请选择-</option>';
                        
                        
                        //设置可供选取的"多选属性值"
                        var values = n.attr_vals.split(',');//String-->Array
                        $.each(values,function(ii,nn){
                            //商品拥有的属性值默认选中
                            if(b==nn){

                            html += '<option value="'+nn+'" selected="selected">'+nn+'</option>';
                            }else{

                            html += '<option value="'+nn+'">'+nn+'</option>';
                            }
                        });

                        html += ' </select> </li>';  
                    }); 
                    }
                  }
                });
            }else{
                //展示“空壳”属性
                //两种表单域：输入框、下拉列表
                $.each(msg,function(i,n){
                    if(i!='flag'){
                        //两种表单域类型
                        if(n.attr_sel==0){
                            //① 输入框
                            html += '<li> '+n.attr_name+'： <input name="attr_nm['+n.attr_id+'][]" type="text"  class="bdr"/> </li>';
                        }else{
                            //② 下拉列表
                            html += '<li><b onclick="add_attr_item(this)">[+]</b> '+n.attr_name+'： <select name="attr_nm['+n.attr_id+'][]" class="bdr" > <option value="0">-请选择-</option>';
                            
                            //设置可供选取的"多选属性值"
                            var values = n.attr_vals.split(',');//String-->Array
                            $.each(values,function(ii,nn){
                                html += '<option value="'+nn+'">'+nn+'</option>';
                            });

                            html += ' </select> </li>';   
                        }
                    }
                });

            }
                //清除旧的属性表单域
                $('#properties-cont li:gt(0)').remove();
                //追加新的属性表单域
                $('#properties-cont').append(html);
            }
    });
}
//页面加载完毕就调用get_attr_info3()一次
//以便显示当前商品拥有的属性
$(function(){
    get_attr_info3();
});
//可以给多选属性增加项目
function add_attr_item(obj){
    //获得obj对应的全部标签
    var yuanli = $(obj).parent();
    //复制一个li
    var fuli = yuanli.clone();
    //[+]内容替换为[-]号
    fuli.find('b').replaceWith("<b onclick='$(this).parent().remove()'>[-]</b>");

    //追加复制li到页面
    yuanli.after(fuli);
}
</script>
<ul class="forminfo" id="properties-cont" style="display: none;">
    <li style="background-color:lightblue;">
        商品类型：
        <select id="type_id" name="type_id" class='bdr' onchange="get_attr_info3()">
            <option value="0">-请选择-</option>
            <?php if(is_array($typeinfo)): foreach($typeinfo as $key=>$v): ?><!--默认拥有类型做判断显示-->
                <?php if(($goods_info["type_id"]) == $v["type_id"]): ?><option value="<?php echo ($v["type_id"]); ?>" selected="selected">
                <?php else: ?>
                    <option value="<?php echo ($v["type_id"]); ?>"><?php endif; ?>
                    <?php echo ($v["type_name"]); ?></option><?php endforeach; endif; ?>
        </select>
    </li>
</ul>
<script>
//增加相册表单域
function add_pics(obj){
    //找到[+]对应的li
    var jiali = $(obj).parent().parent();
    //复制一个li
    var fuzhili = jiali.clone();
    //删除span里的[+]
    fuzhili.find('span').remove();
    var jian = '<span onclick="$(this).parent().parent().remove()">[-]商品相册</span>';
    //增加一个[-]
    fuzhili.find('label').append(jian);
    $('#gallery-cont').append(fuzhili);
}  
//删除单个相册图片
function del_pics(pics_id){
    $.ajax({
        url:"<?php echo U('Goods/delPics');?>",
        data:{'pics_id':pics_id},
        dataType:'json',
        type:'get',
        success:function(msg){
            if(msg.flag==0){
                //删除页面对应的图片节点
                $('#pics_show_'+pics_id).remove();
            }
        }
    });
}
</script>
            <ul class="forminfo" id="gallery-cont" style="display: none;">
                <li style="margin-top: 5px;">
                    <?php if(is_array($goods_pics)): $i = 0; $__LIST__ = $goods_pics;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pics): $mod = ($i % 2 );++$i;?><span style="display: inline;margin: 3px 4px 3px 0" id="pics_show_<?php echo ($pics["pics_id"]); ?>"><img src="http://www.itcast.biz/<?php echo (substr($pics["pics_big"],2)); ?>" alt="" width="150" />
                    <b style="color: red;" onclick="if(confirm('您真的要删除该相册图片吗?')){del_pics(<?php echo ($pics["pics_id"]); ?>)}">[-]</b>
                    </span><?php endforeach; endif; else: echo "" ;endif; ?>
                </li>
                <li>
                    <label><span onclick="add_pics(this)">[+]商品相册</span></label>
                    <input name="picture[]" type="file" />
                </li>
            </ul>  
            <ul class="forminfo" id="linkgoods-cont" style="display: none;">
                <li>
                    关联商品  
                </li>
            </ul>
            <ul class="forminfo" id="groupgoods-cont" style="display: none;">
                <li>
                    配件 
                </li>
            </ul>
            <ul class="forminfo" id="article-cont" style="display: none;">
                <li>
                    关联文章
                </li>
            </ul>
            <ul class="forminfo">
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="button" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>

<script>
//实例化编辑器
var ue = UE.getEditor('ueditor',{toolbars: [[
            'fullscreen', 'source', '|', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
            'simpleupload', 'insertimage', 'emotion']]});
$(function(){
    //给确认保存按钮添加一个点击事件
    $('#btnSubmit').click(function(){
        //表单提交
        $('form').submit();
    });
});
</script>



</body>
</html>