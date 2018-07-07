<?php 
session_start();
require "../common/connect.php";

$resurt = $db->select_all("wl_comment");
if(isset($_GET['action']))
{
	switch($_GET['action'])
	{
		case "delete":
			if(isset($_GET['Id']))
			{
				$where = "where Id = {$_GET['Id']}";
				$rs = $db->deleted("wl_comment",$where);
				
				header("location:admin.php?page=message_list");
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
		留言列表
	</div>
	<div class="panel-body">
		<div class="group" style="border:1px solid #ccc; padding: 5px;">
			<div class="btn-group">
				<button type="button" class="btn btn-success menu-item" data-page="add_message">
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
		      <th style="width: 120px;">留言日期</th>
		      <th>留言内容</th>
		      <th style="width: 80px;">是否回复</th>
		      <th style="width: 120px;">操作</th>
		    </tr>
		  </thead>
		  <tbody>
		  <?php foreach($resurt as $data){?>
		    <tr>
		    	<td> 
				    <label class="checkbox-inline">
				        <input type="checkbox" id="inlineCheckbox1" value="<?php echo $data['Id'];?>"> <?php echo $data['Id'];?>
				    </label>
				</td>
		      <td><?php echo $data['comment_date'];?></td>
		      <td><?php echo $data['comment_content'];?></td>
		      <td><?php 
			  if($data['comment_reply'] == "")
			  {
				  echo "否";
			  }
			  else
			  {
				  echo "是";
			  }
			  ?></td>
		      <td>
		      	<div class="btn-group">
				    <a href="admin.php?page=message_reply&para=a&Id=<?php echo $data['Id'];?>" class="btn btn-xs btn-success">回复</a>
				    <a href = "message_list.php?action=delete&Id=<?php echo $data['Id']?>" class="btn btn-xs btn-danger">删除</a>
				</div>
		      </td>
		    </tr>
		  <?php }?>
		  </tbody>
		</table>
	</div>
</div>