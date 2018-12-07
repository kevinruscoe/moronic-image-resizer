<?php

require "vendor/autoload.php";

use Intervention\Image\ImageManagerStatic as Image;
use ZipStream\Option\Archive as ArchiveOption;

$opt = new ArchiveOption();
$opt->setSendHttpHeaders(true);
$zip = new ZipStream\ZipStream('images.zip', $opt);

if (isset($_FILES['files'])) {
    $files = $_FILES['files'];
    $width = $_POST['width'] ?? 100;
    $height = $_POST['height'] ?? 100;

    try {
        for ($i = 0; $i < count($files) - 1; $i++) { 
            $image = Image::make($files['tmp_name'][$i])
                ->fit($width, $height);

            if (count($files['name']) == 1) {
                header('Content-Type: image/jpg');
                header('Content-Disposition: attachment; filename="image.jpg"');

                print $image->response('jpg', 100);

                exit;
            }

            $zip->addFile(sprintf('image-%s.jpg', $i), $image->encode('jpg'));
        }

        return $zip->finish();
    }catch(\Intervention\Image\Exception\NotReadableException $e) {
        $str = str_repeat("All work and no play makes Jack a dull boy. ", 10000);

        exit($str);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>This might resize your images.</title>
    <link rel="stylesheet" href="dist/app.css">
</head>
<body>

    <div id="app">
        <resizer></resizer>
    </div>

    <script src="dist/app.js"></script>
</body>
</html>