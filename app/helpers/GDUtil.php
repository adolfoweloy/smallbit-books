<?php
class GDUtil {
	
	public static function getHeight($image) {
		$sizes = getimagesize($image);
		$height = $sizes[1];
		return $height;
	}

	public static function getWidth($image) {
		$sizes = getimagesize($image);
		$width = $sizes[0];
		return $width;
	}
		
	public static function local_imagecreate($filename) {
		$info = getimagesize($filename);
		switch ($info[2]) {
			case IMAGETYPE_PNG:
				return imagecreatefrompng($filename);
				break;
			case IMAGETYPE_JPEG:
				return imagecreatefromjpeg($filename);
				break;
			default:
				throw new Exception("Tipo de imagem não suportado");
		}
	}
	
	public static function create_image($src_filename, $dst_resource, $dst_filename) {
		$info = getimagesize($src_filename);
		
		switch ($info[2]) {
			case IMAGETYPE_PNG:
				imagepng($dst_resource, $dst_filename);
				break;	
			case IMAGETYPE_JPEG:
				imagejpeg($dst_resource, $dst_filename);
				break;
			default:
				throw new Exception("Tipo de imagem não suportado");
		}
		
			
	}
	
	public static function resizeThumbnailImage($thumb_image_name, $src_filename, $width, $height, $start_width, $start_height) {
		$newImageWidth = 60;
		$newImageHeight= 60;
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		$source = GDUtil::local_imagecreate($src_filename);
		imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
		GDUtil::create_image($src_filename, $newImage, $thumb_image_name);
		return $thumb_image_name;
	}
		
}