<?php

// ! load the Mimetypes package , to check file extension from mime-type text
require './vendor/autoload.php';

// * file name where saved base64 text
$file_base64 = "./base64text.txt";

function base64_to_file($fileName){
    
// * open/read the file
    $file_base64_handler = fopen($fileName, 'r');
    $file_content = fread($file_base64_handler, filesize($fileName));
    fclose($file_base64_handler);

// checking the file extension...
    $mimes = new \Mimey\MimeTypes;
    $mime_type = '.' . $mimes->getExtension(getMIMETYPE($file_content));
    // print($mime_type);

// crop the part of text where text is ex. "data:application/file;base64," or "image/jpeg" or etc
// and decoding it...
    $file_decoded = base64_decode(preg_replace("/^data:(.*);base64,/", '', $file_content));

// generate a file by decoded base64 text
    $file = fopen(time() . '_generated_' . $mime_type, 'w');

    fwrite($file, $file_decoded);

    fclose($file);
}
//* get file extension by mime type text
function getMIMETYPE($base64string){
    //* croping matching text. 
    preg_match("/^data:(.*);base64/", $base64string, $match);
    return $match[1]; //return mime-type. For example image/jpeg or application/file
}

// CALL FUNCTION 
base64_to_file($file_base64);