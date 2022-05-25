<?php
class CreateRasp {
    function __construct($Api, $raspFile, $userBack, $typeRasp) {   
        
    }

    function renderRasp($raspFile, $userBack){
        $fp_pdf = fopen(TmpDir.$raspFile, 'rb');

		$_img = new imagick(); // [0] can be used to set page number
		$_img->setResolution(300,300);
		$_img->readImageFile($fp_pdf);
		$page = [];
		$i = 0;
		foreach($_img as $img)
		{
			$i++;
			$img->setImageFormat( "jpg" );
			$img->setImageCompression(imagick::COMPRESSION_JPEG);
			$img->setImageCompressionQuality(90);
			$img->setImageUnits(imagick::RESOLUTION_PIXELSPERINCH);
			$img->adaptiveResizeImage(2560, 1810);

			$bg = new imagick(BgDir.$userBack);
			$bg->compositeImage($img, imagick::COMPOSITE_MULTIPLY, 0, 0);
            $filename = TmpDir.$raspFile.$i.'.jpg';
			$bg->writeImage($filename);
            $page[] = $filename;
		}

        return $page;
    }

    function cellSelection() {

    }



    function uploadRasp() {

    }
}
?>