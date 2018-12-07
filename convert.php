<?php

// ! load the Mimetypes package , to check file extension from mime-type text
require './vendor/autoload.php';
$mimes = new \Mimey\MimeTypes; 

// * file name where saved base64 text
$pdf_base64 = "./base64text.txt";

// * open/read the file
$pdf_base64_handler = fopen($pdf_base64,'r');
$pdf_content = fread ($pdf_base64_handler,filesize($pdf_base64));
fclose ($pdf_base64_handler);

//* get file extension by mime type text
function getMIMETYPE($base64string){
    //* croping matching text. 
    preg_match("/^data:(.*);base64/",$base64string, $match);
    return $match[1]; //return mime-type. For example image/jpeg or application/pdf
}
// checking the file extension...
$mime_type = '.'.$mimes->getExtension(getMIMETYPE($pdf_content));
print($mime_type);
/* ____________ */

// crop the part of text where text is ex. "data:application/pdf;base64," or "image/jpeg" or etc
// and decoding it...
$pdf_decoded = base64_decode (preg_replace("/^data:(.*);base64,/",'',$pdf_content));
/* _______________ */

// generate a file by decoded base64 text
$pdf = fopen (time().'_generated_'.$mime_type ,'w');

fwrite ($pdf,$pdf_decoded);

fclose ($pdf);
// finish.........