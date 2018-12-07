<?php

require "vendor/autoload.php";

use Intervention\Image\ImageManagerStatic as Image;

$zip = new ZipStream\ZipStream('images.zip');

$files = $_FILES['files'];
$width = $_POST['width'] ?? 100;
$height = $_POST['height'] ?? 100;

for ($i = 0; $i < count($files) - 1; $i++) { 
    $image = Image::make($files['tmp_name'][$i])
        ->fit($width, $height);

    if (count($files['name']) == 1) {
        header('Content-Type: image/jpg');
        header('Content-Disposition: attachment; filename="image.jpg"');

        print $image->response('jpg', 100);

        exit;
    }

    $zip->addFile(sprintf('image-%s.jpg', $i), $image->stream('jpg', 100));
}

$zip->finish();
