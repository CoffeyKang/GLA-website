<?php

if ($handle = opendir('.'))
{
	$x = 0;
    //This is the correct way to loop over the directory. 
    while (false !== ($filename = readdir($handle)))
	{
		if ($filename != "." && $filename != ".." && $filename != "resize_thumb.php" && $filename != "resize_image.php" && $filename != "thumb" && $filename != "format_change.php")
		{
			$x++;
        	echo $x."-".$filename."<br />";
		
			$dest = $filename;
			
			$nameOnly = substr($filename, 0, -4);
			echo $nameOnly."<br />";
			$execStr = "magick convert convert $nameOnly.tif -resize 600x600 -background white -flatten $nameOnly.jpg";
			exec($execStr, $errMsg);
			
			$oldFile = $nameOnly.".tif";
			$newFile = $nameOnly.".jpg";
			// chmod($newFile, 0755);
			//chgrp($newFile, 'goldenleafautomotive');
			//chown($newFile, 'andy_gla'); //not permitted unless logged in as root user
			unlink($oldFile);
			
			print_r($errMsg);
		}
    }
	
	echo "Picture Format Transfer Finished!";
    closedir($handle);
}
?>