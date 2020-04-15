<?php DECLARE(STRICT_TYPES=1);

$INFO = <<< ____EOT
  sudo yum install php70-php-pecl-zip
  sudo apt-get install php7.2-zip
____EOT;

  $zip  = new ZipArchive();
# $zip      = new \ZipArchive();
$filename = "./test112.zip";

if($zip->open($filename, ZipArchive::CREATE)!==TRUE) : 
    exit("cannot open <$filename>\n");
endif;

$zip->addFromString("testfilephp.txt" . time(), "#1 This is a test string added as testfilephp.txt.\n");
$zip->addFromString("testfilephp2.txt" . time(), "#2 This is a test string added as testfilephp2.txt.\n");
$zip->addFile($thisdir . "/too.php","/testfromfile.php");
echo "numfiles: " . $zip->numFiles . "\n";
echo "status:" . $zip->status . "\n";
$zip->close();