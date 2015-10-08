<!DOCTYPE html>
<html>
<head lang="en">
<meta charset="UTF-8">
<title>公共</title>

</head>
<body>
<?php if(isset($this->blocks['block1'])): ?>
	<?=$this->blocks['block1'];?>
<?php else: ?>
	<h1>没有替换</h1>
<?php endif; ?>

<br>

这是common的内容,下面加载了hello/index.php的内容
<?=$content;?>

</body>
</html>