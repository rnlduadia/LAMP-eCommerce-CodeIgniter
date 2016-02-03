<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
// Define a destination
$targetFolder = $_POST['folder']; // Relative to the root
$verifyToken = md5('unique_salt' . $_POST['timestamp']);
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $targetFolder;
	if(!is_dir($targetPath)) {
   		mkdir($targetPath);
	    chmod($targetPath, 0777);
    } 
	//$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
	$targetfilename = $_FILES['Filedata']['name'];
	$file_ext = get_extension($targetfilename);
	$targetfilename = set_filename($targetPath, $targetfilename, $file_ext,true);
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	$targetPath = $targetPath.'/'.$targetfilename;
	
	if (in_array(strtolower($fileParts['extension']),$fileTypes)) {
		if(move_uploaded_file($tempFile,$targetPath)) {
			echo $targetfilename;
		} else {
			echo "FAILED";
		}		
	} else {
		echo 'Invalid file type.';
	}
} else {
	echo "OUT";
}

function set_filename($path, $filename, $file_ext, $encrypt_name = FALSE)
{
		if ($encrypt_name == TRUE)
		{		
			mt_srand();
			$filename = md5(uniqid(mt_rand())).$file_ext;	
		}
	
		if ( ! file_exists($path.$filename))
		{
			return $filename;
		}
	
		$filename = str_replace($file_ext, '', $filename);
		
		$new_filename = '';
		for ($i = 1; $i < 100; $i++)
		{			
			if ( ! file_exists($path.$filename.$i.$file_ext))
			{
				$new_filename = $filename.$i.$file_ext;
				break;
			}
		}

		if ($new_filename == '')
		{
			return FALSE;
		}
		else
		{
			return $new_filename;
		}
}
	
function prep_filename($filename) {
	   if (strpos($filename, '.') === FALSE) {
		  return $filename;
	   }
	   $parts = explode('.', $filename);
	   $ext = array_pop($parts);
	   $filename    = array_shift($parts);
	   foreach ($parts as $part) {
		  $filename .= '.'.$part;
	   }
	   $filename .= '.'.$ext;
	   return $filename;
}
	
function get_extension($filename) {
	   $x = explode('.', $filename);
	   return '.'.end($x);
} 


?>