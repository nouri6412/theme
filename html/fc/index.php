<?php
set_time_limit(6000);
$links=[];

$base_url = 'https://themes.pixelstrap.com/fastkart/';

$site_url = 'https://themes.pixelstrap.com/fastkart/front-end/index.html';

$file_name = 'index.html';
$pattern = "/\"https:\/\/themes.pixelstrap.com\/fastkart\/[^\"]+\"/"; //  pattern=> \"XXX[^\"]+\"

function fetch($_base_url, $_site_url, $_file_name, $_pattern, $out_path = '../', $extra_path = '')
{
    global $links;
    $base_url = $_base_url;
    $site_url = $_site_url;
    $file_name = $extra_path . $_file_name;
    $pattern = $_pattern;
    //echo $_site_url . '<br>';
    // echo dirname(__FILE__)  . '<br>';
    file_put_contents($file_name, fopen($site_url, 'r'));


    $file = @file_get_contents($file_name);


    if (strlen($extra_path) > 0) {
        //  echo $out_path.'----'. $base_url .'----'. $extra_path;
    }

    $tt = explode($out_path, $file);


    $file = str_replace($out_path, $base_url . $extra_path, $file);
    file_put_contents($file_name, $file);

    $urls = [];


    preg_match_all($pattern, $file, $urls);
    if (strlen($extra_path) > 0) {
     //   var_dump($urls);
        //  return;
    }

    $path = "";
    foreach ($urls[0] as $url) {
        $path = "";
        $base_file = str_replace('"', '', $url);
        $temp_url = str_replace($base_url, '', $url);
        $temp_url = str_replace('"', '', $temp_url);

        $ex = explode("/", $extra_path . $temp_url);

        $vir = "";
        for ($x = 0; $x < count($ex) - 1; $x++) {
            $path .= $vir . $ex[$x];
            $vir = "/";
            if (!file_exists(stream_resolve_include_path($path))) {
                mkdir($path, 0777, true);
            }
        }

        $fff = preg_split('/ (?|#) /', $ex[count($ex) - 1]);

        $ex_pt = str_replace($base_url, '', $path);
        $path .= '/' . $fff[0];

        if (strlen($fff[0]) > 5 && substr($fff[0], -5) == '.html') {
            // echo $ex_pt . '<br>';
           // fetch($base_url, $base_url . $path, $fff[0], $pattern, '../', $ex_pt . '/');

        }
      else  if (strlen($fff[0]) > 4 && substr($fff[0], -4) == '.css') {
            // echo $ex_pt . '<br>';
           // fetch($base_url, $base_url . $path, $fff[0], $pattern, '../', $ex_pt . '/');

            if (!file_exists(stream_resolve_include_path($path))) {
                file_put_contents($path, fopen($base_file, 'r'));
            }
            $sub_file = @file_get_contents($path);
            $sub_urls=[];
            $sub_pattern = "/url\(\"[^\"]+(\.eot|\.woff|\.ttf|\.png|\.jpg|\.jpeg|\.gif|\.svg)+\"\)|url\(\"[^\"]+(\.eot|\.woff|\.ttf|\.png|\.jpg|\.jpeg|\.gif|\.svg)+[^\"]+\"\)/";
            preg_match_all($sub_pattern, $sub_file, $sub_urls);
           var_dump($sub_urls);

        } else {
            if (!file_exists(stream_resolve_include_path($path))) {
               // file_put_contents($path, fopen($base_file, 'r'));
            }
        }
    }

    if (strlen($extra_path) == 0) {
        $file = @file_get_contents($file_name);


        $file = str_replace($base_url, '', $file);

        file_put_contents($file_name, $file);
    }
}
fetch($base_url, $site_url, $file_name, $pattern);
// if (!file_exists(stream_resolve_include_path('new-folder'))) {
//     mkdir('new-folder', 0777, true);
// }

// echo $file;