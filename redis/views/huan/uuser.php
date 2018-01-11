<!DOCTYPE html>
<html>
<head>
	<title></title>
<style type="text/css">

	</style>
</head>
<body>
<form action="douuser" method="post" class="STYLE-NAME">
<h1>
<span>学生修改</span>
</h1>
<p>
	<input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
</p>
<p>

<input id="name" type="hidden" name="id" value="<?= $info['id'] ?>" placeholder="Your Full Name" />
</p>
<p>
<span>姓名</span>
<input id="name" type="text" name="username" value="<?= $info['username'] ?>" placeholder="Your Full Name" />
</p>
<p>
<span>性别</span>
<input id="email" type="text" name="sex" value="<?= $info['sex'] ?>" placeholder="Valid Email Address" />
</p>

<p>
<span>地址</span>
<input id="email" type="text" name="adress" value="<?= $info['adress'] ?>" placeholder="Valid Email Address" />
</p>
<p>
<span>种族</span>
<input id="email" type="text" name="nation" value="<?= $info['nation'] ?>" placeholder="Valid Email Address" />
</p>

<p>
<span>头像</span>
<img src="<?= $info['photo'] ?>" style="width: 50px;height: 50px">
<input id="email" type="text" name="photo" value="<?= $info['photo'] ?>" placeholder="Valid Email Address" />
</p>
<p>
<span>班级</span>
<input id="email" type="text" name="major" value="<?= $info['major'] ?>" placeholder="Valid Email Address" />
</p>
<p>
<span>出生日期</span>
<input id="email" type="text" name="birthday" value="<?= $info['birthday'] ?>" placeholder="Valid Email Address" />
</p>
<p>
<span>家长姓名</span>
<input id="email" type="text" name="famname" value="<?= $info['famname'] ?>" placeholder="Valid Email Address" />
</p>
<p>
<span>微信唯一验证码</span>
<input id="email" type="text" name="openid" value="<?= $info['openid'] ?>" placeholder="Valid Email Address" />
</p>


<p>
<span>&nbsp;</span>
<input type="submit" class="button" value="Send" />
</p>

</form>
</body>
</html>