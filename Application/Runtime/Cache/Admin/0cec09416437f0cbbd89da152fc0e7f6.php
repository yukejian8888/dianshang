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
    <script type="text/javascript">
    $(document).ready(function() {
        $(".click").click(function() {
            $(".tip").fadeIn(200);
        });

        $(".tiptop a").click(function() {
            $(".tip").fadeOut(200);
        });

        $(".sure").click(function() {
            $(".tip").fadeOut(100);
        });

        $(".cancel").click(function() {
            $(".tip").fadeOut(100);
        });

    });
    </script>
    <div class="rightinfo">
        <div class="tools">
            <ul class="toolbar">
                <li><a href="<?php echo U('add');?>"><span><img src="/Public/Admin/images/t01.png" /></span>添加</a></li>
                <li><span><img src="/Public/Admin/images/t02.png" /></span>修改</li>
                <li><span><img src="/Public/Admin/images/t03.png" /></span>删除</li>
                <li><span><img src="/Public/Admin/images/t04.png" /></span>统计</li>
            </ul>
        </div>
<script type="text/javascript">
//通过类型获得对应的属性列表信息
//具体要通过ajax实现此功能
function get_attr_info(){
    //获得当前被选中的类型信息
    var type_id = $('#type_id').val();
    //ajax根据类型获得对应的属性列表信息
    $.ajax({
        url:"<?php echo U('getAttrInfo');?>",
        data:{'type_id':type_id},
        dataType:'json',
        //type:'get', //默认get
        success:function(msg){
            console.log(msg);
            var html = "";
            //遍历msg使之与html的tr等标签结合并显示给页面
           $.each(msg,function(i,n){
                html += '<tr> <td><input name="" type="checkbox" value="" /></td> <td>'+n.attr_id+'</td> <td>'+n.attr_name+'</td><td>'+n.type_name+'</td> <td>';
                html += n.attr_sel==0 ? '单选':'多选';
                html += '</td> <td>';
                html += n.attr_write==0 ? '手工录入' : '选取的';
                html += '</td> <td>'+n.attr_vals+'</td> <td> <a href="" class="tablelink">修改</a> <a href="#" class="tablelink">查看</a> <a href="#" class="tablelink"> 删除</a> </td> </tr>';
            });
            //清除之前的属性tr
            $('.tablelist tr:gt(0)').remove();
            //追加html到页面
            $('.tablelist').append(html);
        }
    });
}
//页面加载完毕就自动调用一次get_attr_info
$(function(){
    get_attr_info();
});
</script>
           <div style="background-color: rgb(240,245,247);width: 100%;height:35px;margin-bottom: 3px;">按商品类型显示:
            <select id="type_id" style="border: 1px solid gray;" onchange="get_attr_info()">
                <option value="0">请选择</option>
                    <?php if(is_array($typeinfo)): foreach($typeinfo as $key=>$v): if(($_GET['type_id']) == $v['type_id']): ?><option value="<?php echo ($v["type_id"]); ?>" selected="selected">
                        <?php else: ?>
                        <option value="<?php echo ($v["type_id"]); ?>"><?php endif; ?>
                        <?php echo ($v["type_name"]); ?></option><?php endforeach; endif; ?>
            </select>
        </div>
        <table class="tablelist">
                <tr>
                    <th>
                        <input name="" type="checkbox" value="" id="checkAll" />
                    </th>
                    <th>编号</th>
                    <th>属性名称</th>
                    <th>类型名称</th>
                    <th>单选/多选</th>
                    <th>录入/选取</th>
                    <th>可供选取值</th>
                    <th>操作</th>
                </tr>
        </table>
        <div class="pagin">
            <div class="message">共<i class="blue">1256</i>条记录，当前显示第&nbsp;<i class="blue">2&nbsp;</i>页</div>
            <ul class="paginList">
                <li class="paginItem"><a href="javascript:;"><span class="pagepre"></span></a></li>
                <li class="paginItem"><a href="javascript:;">1</a></li>
                <li class="paginItem current"><a href="javascript:;">2</a></li>
                <li class="paginItem"><a href="javascript:;">3</a></li>
                <li class="paginItem"><a href="javascript:;">4</a></li>
                <li class="paginItem"><a href="javascript:;">5</a></li>
                <li class="paginItem more"><a href="javascript:;">...</a></li>
                <li class="paginItem"><a href="javascript:;">10</a></li>
                <li class="paginItem"><a href="javascript:;"><span class="pagenxt"></span></a></li>
            </ul>
        </div>
        <div class="tip">
            <div class="tiptop"><span>提示信息</span>
                <a></a>
            </div>
            <div class="tipinfo">
                <span><img src="/Public/Admin/images/ticon.png" /></span>
                <div class="tipright">
                    <p>是否确认对信息的修改 ？</p>
                    <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
                </div>
            </div>
            <div class="tipbtn">
                <input name="" type="button" class="sure" value="确定" />&nbsp;
                <input name="" type="button" class="cancel" value="取消" />
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
    </script>


</body>
</html>