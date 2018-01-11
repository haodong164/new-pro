<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
td {
      text-align:center; /*设置水平居中*/
      vertical-align:middle;/*设置垂直居中*/
      padding: 20px
}
th {
      text-align:center; /*设置水平居中*/
      vertical-align:middle;/*设置垂直居中*/
      padding: 20px
}
</style>
</head>

<body>

				
	<table border="1"  style="width:1300px;height: 100%;">
		<tr >
			<th >ID</th>
			<th>姓名</th>
			<th>性别</th>
			<th>地址</th>
			<th>种族</th>
			<th>头像</th>
			<th>班级</th>
			<th>出生日期</th>
			<th>家长姓名</th>
			<th>微信唯一验证</th>
			<th>操作</th>
		</tr>
		<?php foreach($ulist as $v):?>
		<tr>
			<td><?= $v['id'] ?></td>
			<td><?= $v['username'] ?></td>
			<td><?= $v['sex'] ?></td>
			<td><?= $v['adress'] ?></td>
			<td><?= $v['nation'] ?></td>
			<td>
				<img style="width: 60px;height: 60px" src="<?= $v['photo'] ?>">
			</td>
			<td><?= $v['major'] ?></td>
			<td><?= $v['birthday'] ?></td>
			<td><?= $v['famname'] ?></td>
			<td><?= $v['openid'] ?></td>
			<td>
				<a href="/index.php?r=index/dellist&uid=<?=$v['id'];?>">删除</a>
				<a href="uuser?id=<?= $v['id']?>">修改</a>
			</td>
		</tr>
	<?php endforeach ;?> 
	</table>
	<a href="ulist?page=<?= $page-1?>">上一页</a>
	<a href="ulist?page=<?= $page+1?>">下一页</a>
	<a href="uuser">添加</a>
</body>
</html>