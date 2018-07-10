<?php
require_once "header.php";
?>
	<div id="main">
		<div class="main_center">
		<?php foreach($class_list as $class){?>
			<div class="project_item">
				<h3><a href="#"><?php echo $class['project_class'];?></a></h3>
				<?php 
				$where_project = "where project_class = '{$class['project_class']}'";
				$project_list = $db->select_all("wl_project",$where_project);
				?>
				<ul>
				<?php foreach($project_list as $project){?>
					<li><a href="<?php echo $project['project_addr'];?>" target="_blank"><?php echo $project['project_title'];?></a></li>
				<?php }?>
				</ul>
			</div>
		<?php }?>
		</div>
	</div>
</body>
</html>