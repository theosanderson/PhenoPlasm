<?

if(!file_exists("mmp/".$_GET['file'])){
	copy("https://malariaparasite.blob.core.windows.net/picturedb/".$_GET['file'], "mmp/".$_GET['file']);
	$im=imagecreatefromjpeg("mmp/".$_GET['file']);
	$im= imagecropauto($im , IMG_CROP_THRESHOLD, 0.5, 16777215);
	imagejpeg($im, "mmp/".$_GET['file']);


	}


header( 'Location: /mmp/'.$_GET['file'] ) ;
?>