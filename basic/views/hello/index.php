hello index,这是index页面的内容:hello/index.php
<?php 
	//在视图中加载另外一个视图文件
	//加载hello/about.php页面的内容
	echo $this->render('about',array('v_hello'=>'hello_str'));
?>