<?php
session_start();
require "../common/connect.php";

$re = $db->select_all("wl_project");
if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case "delete":
			if(isset($_GET['Id']))
			{
				$where = "where Id = {$_GET['Id']}";
				$rs = $db->deleted("wl_project",$where);
				if($rs)
				{
					header("location:admin.php?page=project_list");
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
				<button type="button" class="btn btn-success menu-item" data-page="add_project">
					<span class="glyphicon glyphicon-plus"></span> 添加
				</button>
				<button type="button" class="btn btn-info">
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
		      <th>项目名称</th>
		      <th>项目分类</th>
		      <th>项目链接</th>
		      <th style="width: 20%">操作</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php foreach($re as $data){?>
		    <tr>
		    	<td> 
				    <label class="checkbox-inline">
				        <input type="checkbox" id="inlineCheckbox1" value="option1"> <?php echo $data['Id'];?>
				    </label>
				</td>
		      <td><?php echo $data['project_title'];?></td>
		      <td><?php echo $data['project_class'];?></td>
		      <td><?php echo $data['project_addr'];?></td>
		      <td>
		      	<div class="btn-group">
				    <button type="button" class="btn btn-xs btn-success">显示</button>
				    <a class="btn btn-xs btn-primary" href="<?php echo $data['project_addr'];?>">预览</a>
				    <a class="btn btn-xs btn-info" href="admin.php?page=add_project&para=action=edit&Id=<?php echo $data['Id'];?>">编辑</a>
				    <a class="btn btn-xs btn-danger" href="project_list.php?action=delete&Id=<?php echo $data['Id'];?>">删除</a>
				</div>
		      </td>
		    </tr>
		  <?php }?>
		  </tbody>
		</table>
	</div>
</div>