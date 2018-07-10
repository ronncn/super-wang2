<?php
session_start();
require "../common/connect.php";
$re = $db->select_all("wl_article");
if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case "delete":
			if(isset($_GET['Id']))
			{
				$where = "where Id = {$_GET['Id']}";
				$rs = $db->deleted("wl_article",$where);
				if($rs)
				{
					header("location:admin.php?page=article_list");
				}
			}
			else
			{
				echo "未设置删除ID";
			}
		break;
	}
}
?>
<div class="panel panel-default">
	<div class="panel-heading">
		项目列表
	</div>
	<div class="panel-body">
		<div class="group" style="border:1px solid #ccc; padding: 5px;">
			<div class="btn-group">
				<button type="button" class="btn btn-success menu-item" data-page="add_article">
					<span class="glyphicon glyphicon-plus"></span> 添加
				</button>
				<button id="checkall" type="button" class="btn btn-info">
				 <span class="glyphicon glyphicon-th"></span> 全选
				</button>
				<button type="button" class="btn btn-danger">
				 <span class="glyphicon glyphicon-minus"></span> 删除
				</button>
			</div>
		</div>
		<table class="table table-bordered table-hover">
			<br>
		  <thead>
		    <tr style="background: #ccc;">
		    	<th style="width: 30px;">ID</th>
		      <th>文章名称</th>
		      <th>文章分类</th>
		      <th>文章日期</th>
		      <th style="width: 20%">操作</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php foreach($re as $data){?>
		    <tr>
		    	<td> 
				    <label class="checkbox-inline">
				        <input type="checkbox" name="id" value="<?php echo $data['Id'];?>"> <?php echo $data['Id'];?>
				    </label>
				</td>
		      <td><?php echo $data['article_title'];?></td>
		      <td><?php echo $data['article_class'];?></td>
		      <td><?php echo $data['article_date'];?></td>
		      <td>
		      	<div class="btn-group">
				    <button type="button" class="btn btn-xs btn-success">显示</button>
				    <a href="../article.php?id=<?php echo $data['Id'];?>" target="_blank" class="btn btn-xs btn-primary">预览</a>
				    <a href="admin.php?page=add_article&para=action=edit&Id=<?php echo $data['Id'];?>" class="btn btn-xs btn-info">编辑</a>
				    <a href="article_list.php?action=delete&Id=<?php echo $data['Id'];?>" class="btn btn-xs btn-danger">删除</a>
				</div>
		      </td>
		    </tr>
		  <?php }?>
		  </tbody>
		</table>
	</div>
</div>
<script>
var flag = false;
$("#checkall").click(function(){
	if(flag)
	{
		$("input[name='id']").each(function() { 
			this.checked = false; 
		}); 
		$("#checkall").text("全选");
		flag = !flag;
	}
	else
	{
		$("input[name='id']").each(function() { 
			this.checked = true; 
		}); 
		$("#checkall").text("取消全选");
		flag = !flag;
	}
})
</script>