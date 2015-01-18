<script language="javascript" src="js/responsiveslides.js"></script>
<div  class="mainwrapper" style="position:relative; float:left; padding:20px;">
      <div style="float:left; text-align:left; width:350px;margin-top:5px;">
           <div style="height:50px; float:left;  margin-top:-20px; margin-right:5px;"><img src="images/help01.png"/></div>
           <h1 style="float:left; color:#189de1; border-bottom:1px dotted #ccc; width:240px; text-align:left; padding-bottom:10px;">Dmap Help</h1>
           <div style="clear:both;margin-bottom:20px;"></div>
           <div style="padding:10px;font-size:12px; line-height:200%;">
		    　　DMap是一种突破一般形式的个性化新式地图，在DMap地图中，我们将为您提供个性化的互动体验。<br/>
			例如：<br/>
			　　我们可以体验3D版的复旦校园地图，还可以了解到地图上的新闻、活动以及其他极富价值的信息；
			<br/>
			　　只要轻点鼠标，我们可以了解复旦各建筑的详细情况，比如建筑的楼层内部地点信息，这是一般地图做不到的。
			此外，我们的各地点还加入了社交功能。我们为您提供了每个地点的地址、照片、活动、评论、上课情况等信息。
			<br/>

			<div style="font-size:14px;font-weight:bold;margin-top:15px;color:#189de1;">　DMap Makes Campus Life More Beautiful !</div>
			<div style="float:right;padding:5px;">Luminator小组</div>
			
		   </div>
      </div>
      <div id="slides" style="width:500px; margin-left:50px; float:left; ">
        <img width="500" src="./images/1.png" alt="" />
        <img width="500" src="./images/2.png" alt="" />
		<img width="500" src="./images/4.png" alt="" />
		<img width="500" src="./images/3.png" alt="" />
      </div>
      <div style="clear:both;"></div>
      <div id="helpText" style="font-size:14px;">
      </div>
</div>
<script>
  $(function () {
    $("#slides").responsiveSlides();
  });
  $("#slides").responsiveSlides({
  speed: 3000,    //Integer: How long one image shows before fading to next, in milliseconds
  fade: 1000,     //Integer: Crossfade, in milliseconds
  auto: false,     //Boolean: Animate automatically? if 'false', pagination is created automatically
  maxwidth: 500,  //Integer: Max-width of the Slideshow + images, in pixels
  namespace: 'rs' //String: Using this you can change the default Classes and ID's the Slideshow uses (if you for example want to have multiple slideshows on the same page)
});
  
</script>

