<?php if($this->beginCache('cache_div')){
	
	/**
	 * 第一次运行:
	 * 这里会被缓存
	 * 这里不会被缓存
	 * 
	 * 在后面加上ss,和,tt
	 * 第二次运行:
	 * 这里会被缓存
	 * 这里不会被缓存tt
	 * 
	 * 因为id='cache_div'部分,会从缓存里面读取内容,不会读取页面内容,所以ss的修改没有被显示出来
	 */
	
?>
 
<div id='cache_div'>
	<div>这里会被缓存ss</div>
</div>

<?php 
	$this->endCache();
}
?>

<div id='no_cache_div'>
	<div>这里不会被缓存tt</div>
</div>