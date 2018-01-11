<html>
	<head>
	</head>
	<body>
		<div style="height:20px">
		</div>
		<table style="margin:0 auto" width="800px" cellpadding="0" cellspacing="0" border="1">
			<tr>
				<th>uid</th>
				<th>id</th>
				<th>姓名</th>
				<th>性别</th>
				<th>民族</th>
				<th>专业</th>
				<th>操作</th>
			</tr>
			<?php
			foreach($ulist as $v):
			?>
			<tr style="text-align:center">
				<td><?=$v['uid'];?></td>
				<td><?=$v[1];?></td>
				<td><?=$v[3];?></td>
				<td><?=$v[5];?></td>
				<td><?=$v[7];?></td>
				<td><?=$v[9];?></td>
				<td>
					<a href="/index.php?r=index/dellist&id=<?=$v[1];?>">id</a>
					<a href="/index.php?r=index/dellist&uid=<?=$v['uid'];?>">删除</a>
					<a href="/index.php?r=index/uplist&uid=<?=$v['uid'];?>">编辑</a>
				</td>
			</tr>
			<?php endforeach;?>
		</table>
		<div style="width:200px;margin:0 auto;padding-top:20px">
			<a style="display:block;width:100px;text-align:center;float:left" href="/index.php?r=index/list&page=<?=$page-1?>">上一页</a>
			<a style="display:block;width:100px;text-align:center;float:left" href="/index.php?r=index/list&page=<?=$page+1?>">下一页</a>
		</div>
	</body>
</html>
