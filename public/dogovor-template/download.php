<?php
//редактируем адрес и название файла
$file = ("http://lawdocument.ru/sites/all/libraries/docs/soglashenie/advokat/soglashenie.docx");
header ("Content-Type: application/octet-stream");
header ("Accept-Ranges: bytes");
header ("Content-Length: ".filesize($file));
header ("Content-Disposition: attachment; filename=соглашение с адвокатом.docx");  
readfile($file);
?>