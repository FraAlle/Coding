<?php
    function unlinkr($dir,$dirFile, $pattern = "*") {

        $files = glob($dir . "/$pattern"); 
    
        foreach($files as $file){
            if (is_dir($file) and !in_array($file, array('..', '.')))  {
                unlinkr($file, $pattern);
                @rmdir($file);
            } else if(is_file($file) and ($file != $dirFile)) {
                unlink($file);
            }
        }
    }
    $dir = getcwd();
    $dirFile = 'C:\Your Dir where this script is placed';
    unlinkr($dir,$dirFile);
?>
