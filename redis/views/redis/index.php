<html>
	<head>
	</head>
	<body>
		<div style="height:20px">
		</div>
		<table style="margin:0 auto" width="800px" cellpadding="0" cellspacing="0" border="1">
			<tr>
				
				<th>id</th>
				<th>姓名</th>
				<th>性别</th>
				<th>身份证号</th>
				<th>宿舍</th>
				<th>班级</th>
				<th>民族</th>
				<th>专业</th>
				<th>生日</th>
				<th>操作</th>
			</tr>
			<?php
			foreach($ulist as $v):
			?>
			<tr style="text-align:center">
				
				<td><?=$v[1];?></td>
				<td><?=$v[3];?></td>
				<td><?=$v[5];?></td>
				<td><?=$v[7];?></td>
				<td><?=$v[9];?></td>
				<td><?=$v[11];?></td>
				<td><?=$v[13];?></td>
				<td><?=$v[15];?></td>
				<td><?=$v[17];?></td>
				<td>
					<a href="/index.php?r=redis/dellist&id=<?=$v[1];?>">删除</a>
					<a href="/index.php?r=redis/uplist&id=<?=$v[1];?>">编辑</a>
				</td>
			</tr>
			<?php endforeach;?>
		</table>
		<div style="width:400px;margin:0 auto;padding-top:20px">
			<ul style="list-style:none">
				<li style="width:100px;text-align:center;float:left">
					<?php
						if($page==1){
					?>
							<a>上一页</a>
					<?php
						}else{
					?>
							<a href="/index.php?r=redis/list&page=<?=$page-1?>">上一页</a>
					<?php
						}
					?>
				</li>
				
				<li style="width:100px;text-align:center;float:left">
					当前第<a><?php echo $page; ?></a>页
				</li>
					
				<li style="width:100px;text-align:center;float:left">
					<?php
						if($page<=$pages){
					?>
							<a href="/index.php?r=redis/list&page=<?=$page+1?>">下一页</a>
					<?php
						}else{
					?>
							<a>下一页</a>
					<?php				
						}
					?>
				</li>
				<li style="width:50px;text-align:center;float:left">
					<?php echo $pages;?>
				</li>
		</div>
		<div style="width:200px;margin:0 auto;padding-top:20px">
			<a style="display:block;width:100px;text-align:center;float:left" href="/index.php?r=redis/add">添加</a>
		</div>
	</body>
</html>
