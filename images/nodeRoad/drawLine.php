<?php 
    //header('Content-type:image/png');//����������±��������ͼ�� 
	//$i=0;{
	for ($i=45;$i<90;++$i) {
		$img=imagecreate(150,150);//ͼ��Ŀ�͸ߡ� 
		$col_white=imagecolorallocate($img,0,0,0);
		imagecolortransparent ( $img ,0 );
		imagesetthickness ( $img, 3 );

		$col_red=imagecolorallocate($img,255,255,0);//�ߵ���ɫ 
		
		$y=round(150*tan((90-$i)*3.14159265359/180));
		echo $y." ";
		imageline($img,0,150,$y,0,$col_red);//��һ���� 
		
		imagepng($img,"./_$i.png");//���ͼ�� 
		imagedestroy($img);//�ͷ��ڴ� 
		echo "$i<br/>";
	}
	
	/*
		$img=imagecreate(150,150);//ͼ��Ŀ�͸ߡ� 
		$col_white=imagecolorallocate($img,0,0,0);
		imagecolortransparent ( $img ,0 );
		imagesetthickness ( $img, 3 );

		$col_red=imagecolorallocate($img,255,255,0);//�ߵ���ɫ 

		imageline($img,0,0,0,150,$col_red);//��һ���� 
		
		imagepng($img,"./90.png");//���ͼ�� 
		imagedestroy($img);//�ͷ��ڴ� 
	*/
?>