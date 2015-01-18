<?php
if(@$_GET['act']=='saveThumb'){
	$targ_w = $targ_h = 150;
	$jpeg_quality = 100;

	@$src = $_POST['bigImage'];
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],$targ_w,$targ_h,$_POST['w'],$_POST['h']);

	header('Content-type: image/jpeg');
	imagejpeg($dst_r,null,$jpeg_quality);
	
	exit;
}
?>
<html>
	<head>

		<script src="jquery.pack.js"></script>
		<script src="jquery.Jcrop.pack.js"></script>
		
		<link rel="stylesheet" href="jquery.Jcrop.css" type="text/css" />
        
		<script language="Javascript">

			$(function(){

				
			});
			
			function goss(){

				jQuery('#cropbox').Jcrop({
					onChange: showPreview,
					onSelect: showPreview,
					onSelect: updateCoords,
					aspectRatio: 1
				});

			}

			function updateCoords(c)
			{
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};

			function checkCoords()
			{
				if ($('#x').val()==''){
					alert('请先上传头像然后选择裁切头像最后进行保存！');
					return false;
				}
			};
			
			function showPreview(coords)
			{
				var rx = 150 / coords.w;
				var ry = 150 / coords.h;
				var w2=$("#bigwidth").val();
				var h2=$("#bigheight").val();
				jQuery('#preview').css({
					width: Math.round(rx * w2) + 'px',
					height: Math.round(ry * h2) + 'px',
					marginLeft: '-' + Math.round(rx * coords.x) + 'px',
					marginTop: '-' + Math.round(ry * coords.y) + 'px'
				});
			}

		</script>

	</head>

	<body>
<?php
if(@$_GET['act']=='upload'){
	if(@$_POST['upload']=='upload'){
		
		$uploaddir ='upload/';
		$uploadfile = $uploaddir . basename($_FILES['file']['name']);
		//print_r($_FILES['file']);
		//echo $uploadfile;
	
		if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
			list($w, $h, $type, $attr)=getimagesize($uploadfile);
			$str='';
			if($w>550){
				$str="width:550px;";
			}
			if($h>550){
				$str.="  height:550px;";
			}
			$str=empty($str)?'':"style=' ".$str." '";
			$f1="<img src='$uploadfile' border=0 $str id='cropbox' >";
			$f2="<img src='$uploadfile' border=0  $str id='preview' >";

			
			
			echo '<script language="javascript">parent.$("#showBig").html("'.$f1.'");parent.$("#showThumb").html("'.$f2.'");parent.goss();parent.$("#bigwidth").val("'.$w.'");parent.$("#bigheight").val("'.$h.'");parent.$("#bigImage").val("'.$uploadfile.'");</script>';
				
		}else {
			echo "<script>alert('文件上传失败!');</script>";
		}
		
	}
?>

<div style="margin:0px;font-size:12px;">
<FORM ACTION="?act=upload" METHOD=POST enctype="multipart/form-data">

	<input type="file" name="file" id="file" />

  <input type="submit" name="button" id="button" value="提交" />

  <input name="upload" type="hidden" id="upload" value="upload" /><input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
</FORM>
</div>

  <?php
  exit;
}
?>


<div id="showBig" style="width:500px;height:500px;border:2px solid #E6E0CE;padding:3px;"></div>
<iframe style="width:500px;height:60px;padding:0px;" src="?act=upload"></iframe>


<div id="showThumb" style="width:152px;height:152px;border:1px solid #cccccc;padding:1px; overflow: hidden;"></div>
<div style="margin-top:20px;">
    <form action="?act=saveThumb" method="post" onSubmit="return checkCoords();">
        <input type="hidden" id="bigImage" name="bigImage" />
        <input type="hidden" id="bigwidth" name="bigwidth" />
        <input type="hidden" id="bigheight" name="bigheight" />
        <input type="hidden" id="x" name="x" />
        <input type="hidden" id="y" name="y" />
        <input type="hidden" id="w" name="w" />
        <input type="hidden" id="h" name="h" />
        <input type="submit" value="保存用户头像" />
    </form>
</div>
	</body>

</html>