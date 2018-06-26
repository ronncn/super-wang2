<div class="panel panel-default">
	<div class="panel-heading">
		发布文章
	</div>
	<div class="panel-body">
		<div class="group" style="border:1px solid #ccc; padding: 5px;">
			<div class="btn-group">
				<button type="button" class="btn btn-success">
					<span class="glyphicon glyphicon-send"></span> 发布
				</button>
				<button type="button" class="btn btn-info">
				 <span class="glyphicon glyphicon-film"></span> 暂存
				</button>
				<button type="button" class="btn btn-danger">
				 <span class="glyphicon glyphicon-retweet"></span> 清空
				</button>

			</div>
		</div>
		<form class="form-horizontal" style="margin-top: 20px;" role="form">
		  <div class="form-group">
		    <label class="col-sm-2 control-label">文章标题：</label>
		    <div class="col-sm-10">
		      <input class="form-control" id="focusedInput" type="text" value=""
		      placeholder="请输入文章标题">
		    </div>
		  </div>  
		  <div class="form-group">
		    <label class="col-sm-2 control-label">文章分类：</label>
		    <div class="col-sm-10">
		      <input class="form-control" id="focusedInput" type="text" value=""
		      placeholder="请输入文章分类">
		    </div>
		  </div>  
		  <div class="form-group">
		    <label class="col-sm-2 control-label">文章标签：</label>
		    <div class="col-sm-10">
		      <input class="form-control" id="focusedInput" type="text" value=""
		      placeholder="输入标签请用逗号“,”分隔">
		    </div>
		  </div> 
		  <div class="form-group">
		    <label class="col-sm-2 control-label" for="name">文章首图：</label>
			  <div class="col-sm-3">
			    <label class="sr-only" for="inputfile">上传图片</label>
			    <input type="file" id="inputfile">
			  </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-2 control-label" for="name"></label>
			  <div class="col-sm-10">
			  	<img src="../public/images/timg.jpg" width="600" height="300" />
			  </div>
		  </div>
		  <div class="form-group">
		    <label class="col-sm-2 control-label">编辑：</label>
		    <div class="col-sm-10">
			    <!-- 加载编辑器的容器 -->
			    <script id="container" name="content" type="text/plain">
			        这里写你的初始化内容
			    </script>
			    <!-- 配置文件 -->
			    <script type="text/javascript" src="../public/ueditor/ueditor.config.js"></script>
			    <!-- 编辑器源码文件 -->
			    <script type="text/javascript" src="../public/ueditor/ueditor.all.js"></script>
			    <!-- 实例化编辑器 -->
			    <script type="text/javascript">
			        var ue = UE.getEditor('container');
			    </script>
		    </div>
		  </div> 
		</form>
	</div>
</div>
			