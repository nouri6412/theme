<?php
$base_url = 'https://themes.pixelstrap.com/fastkart/';
//file_put_contents("test.css", fopen("https://themes.pixelstrap.com/fastkart/assets/css/vendors/bootstrap.css", 'r'));

$file = @file_get_contents('http://localhost:84/theme/html/fc/index.html');

$urls = [];
$pattern = "/\"https:\/\/themes.pixelstrap.com\/fastkart\/[^\"]+\"/"; //  pattern=> \"XXX[^\"]+\"
//$pattern="/assets/";
preg_match_all($pattern, $file, $urls);

//var_dump($urls);
$path = "";
foreach ($urls[0] as $url) {
    $path = "";
    $base_file = str_replace('"', '', $url);
    $temp_url = str_replace($base_url, '', $url);
    $temp_url = str_replace('"', '', $temp_url);

    $ex = explode("/", $temp_url);

    $vir = "";
    for ($x = 0; $x < count($ex) - 1; $x++) {
        $path .= $vir . $ex[$x];
        $vir = "/";
        if (!file_exists(stream_resolve_include_path($path))) {
            echo $path . '<br>';
            mkdir($path, 0777, true);
        }
    }
    $path .= '/' . $ex[count($ex) - 1];
    if (!file_exists(stream_resolve_include_path($path))) {
        file_put_contents($path, fopen($base_file, 'r'));
    }
}

// if (!file_exists(stream_resolve_include_path('new-folder'))) {
//     mkdir('new-folder', 0777, true);
// }

// echo $file;