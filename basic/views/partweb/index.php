<?php 
	//设置缓存时间
	$duration = 15;		//缓存15秒,15秒后会缓存失效,读取页面内容
	
	//缓存开关
	$enabled = false;		//不使用缓存
?>

<?php if($this->beginCache('cache_div',['duration'=>$duration,'enabled'=>$enabled])){
	
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