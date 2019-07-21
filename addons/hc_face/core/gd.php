<?php
Class Gd{

	function cutImg($imgfile, $x=0, $y=0,$nx=300,$ny=300, $width = 100, $height= 100){
		//获取原图片的信息
		$imginfo = getimagesize($imgfile);
		//判断图片
		if (!$imginfo) {
			echo "非法图片";
			return false;
		}
		//得到原图宽高
		list($src_w, $src_h) = $imginfo;
		$mime = $imginfo['mime'];
		$arr = explode('/', $mime);
		list($type, $subtype) = $arr;
		//拼接函数名
		$open_img = 'imagecreatefrom'.$subtype;
		$save_img = 'image'.$subtype;
		//打开原图资源 
		$img = $open_img($imgfile);
		//创建切图资源
		
		$cut_img = imagecreatetruecolor($nx,$ny);
		//切图
		imagecopyresampled($cut_img, $img, 0, 0, $x, $y, $nx,$ny, $width, $height);
		//获取原图后缀
		$ext = pathinfo($imgfile, PATHINFO_EXTENSION);
		//生成文件名字
		$name = date('YmdHis').uniqid().'.'.$ext;
		//生成保存路径
		$dir = IA_ROOT.'/addons/hc_face/avatar/';
	    if(!file_exists($dir)){
	        mkdir($dir);
	        chmod($dir,0777);
	    }
		$save_img_name = IA_ROOT.'/addons/hc_face/avatar/'.$name;
		//保存图片
		$save_img($cut_img, $save_img_name);
		//销毁资源
		imagedestroy($img);
		imagedestroy($cut_img);
		 
		return $name;//$save_img_name;
	}
	  /**
  * desription 压缩图片
  * @param sting $imgsrc 图片路径
  * @param string $imgdst 压缩后保存路径
  */
	function compressed_image($imgsrc,$imgdst){
	    list($width,$height,$type)=getimagesize($imgsrc);
	    $new_width = $width>600?600:$width;
	    $rate = $new_width/$width;
	    $new_height =$height*$rate;
	    switch($type){
	      case 1:
	        $giftype=check_gifcartoon($imgsrc);
	        if($giftype){
	          header('Content-Type:image/gif');
	          $image_wp=imagecreatetruecolor($new_width, $new_height);
	          $image = imagecreatefromgif($imgsrc);
	          imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	          //75代表的是质量、压缩图片容量大小
	          imagejpeg($image_wp, $imgdst,75);
	          imagedestroy($image_wp);
	        }
	        break;
	      case 2:
	        header('Content-Type:image/jpeg');
	        $image_wp=imagecreatetruecolor($new_width, $new_height);
	        $image = imagecreatefromjpeg($imgsrc);
	        imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	        //75代表的是质量、压缩图片容量大小
	        imagejpeg($image_wp, $imgdst,75);
	        imagedestroy($image_wp);
	        break;
	      case 3:
	        header('Content-Type:image/png');
	        $image_wp=imagecreatetruecolor($new_width, $new_height);
	        $image = imagecreatefrompng($imgsrc);
	        imagecopyresampled($image_wp, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	        //75代表的是质量、压缩图片容量大小
	        imagejpeg($image_wp, $imgdst,75);
	        imagedestroy($image_wp);
	        break;
	    }
	}
}