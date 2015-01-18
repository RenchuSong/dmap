<?php 
    //header('Content-type:image/png');//告诉浏览器下边输出的是图像 
	//$i=0;{
	for ($i=45;$i<90;++$i) {
		$img=imagecreate(150,150);//图像的宽和高。 
		$col_white=imagecolorallocate($img,0,0,0);
		imagecolortransparent ( $img ,0 );
		imagesetthickness ( $img, 3 );

		$col_red=imagecolorallocate($img,255,255,0);//线的颜色 
		
		$y=round(150*tan((90-$i)*3.14159265359/180));
		echo $y." ";
		imageline($img,0,150,$y,0,$col_red);//画一条线 
		
		imagepng($img,"./_$i.png");//输出图像 
		imagedestroy($img);//释放内存 
		echo "$i<br/>";
	}
	
	/*
		$img=imagecreate(150,150);//图像的宽和高。 
		$col_white=imagecolorallocate($img,0,0,0);
		imagecolortransparent ( $img ,0 );
		imagesetthickness ( $img, 3 );

		$col_red=imagecolorallocate($img,255,255,0);//线的颜色 

		imageline($img,0,0,0,150,$col_red);//画一条线 
		
		imagepng($img,"./90.png");//输出图像 
		imagedestroy($img);//释放内存 
	*/
?>