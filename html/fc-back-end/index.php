<?php
set_time_limit(6000);
$links = [];

$base_url = 'https://themes.pixelstrap.com/fastkart/';

$file_name = 'index.html';
$root = 'https://themes.pixelstrap.com/fastkart/back-end/';
$site_url = $root . $file_name;
$index_fetch = 1;





$links[$file_name] = $file_name;

$pattern = "/\"https:\/\/themes.pixelstrap.com\/fastkart\/[^\"]+\"/"; //  pattern=> \"XXX[^\"]+\"

function fetch($_base_url, $_site_url, $_file_name, $_pattern, $out_path = '../', $extra_path = '')
{
    echo '<div>' . $_base_url . '---' . $_site_url . '...' . $_file_name . '...' . $_pattern . '</div>';
    global $links, $root, $index_fetch;
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
    $arr_path = [];
    foreach ($urls[0] as $url) {
        $path = "";
        $arr_path = [];
        $base_file = str_replace('"', '', $url);
        $temp_url = str_replace($base_url, '', $url);
        $temp_url = str_replace('"', '', $temp_url);

        $ex = explode("/", $extra_path . $temp_url);

        $vir = "";
        for ($x = 0; $x < count($ex) - 1; $x++) {
            $path .= $vir . $ex[$x];
            $arr_path[] = $path;
            $vir = "/";
            if (!file_exists(stream_resolve_include_path($path))) {
                mkdir($path, 0777, true);
            }
        }

        $fff = preg_split('/(?|#)/', $ex[count($ex) - 1]);

        $ex_pt = str_replace($base_url, '', $path);
        $path .= '/' . $fff[0];

        if (strlen($fff[0]) > 5 && substr($fff[0], -5) == '.html') {
            // echo $ex_pt . '<br>';
            // fetch($base_url, $base_url . $path, $fff[0], $pattern, '../', $ex_pt . '/');

        } else  if (strlen($fff[0]) > 4 && substr($fff[0], -4) == '.css') {
            // echo $ex_pt . '<br>';
            // fetch($base_url, $base_url . $path, $fff[0], $pattern, '../', $ex_pt . '/');
            if (!file_exists(stream_resolve_include_path($path.'.map'))) {

                $map = @file_get_contents($base_url . '/' . $path.'.map');
                if(strlen($map)>4)
                {
                    file_put_contents($path.'.map', $map);
                }

            }
            if (!file_exists(stream_resolve_include_path($path))) {
                file_put_contents($path, fopen($base_file, 'r'));
            }
            $sub_file = @file_get_contents($path);
            $sub_urls = [];
            $sub_pattern = "/(url\([^\)]+\))|url\(\"[^\"]+(\.eot|\.woff|\.ttf|\.png|\.jpg|\.jpeg|\.gif|\.svg)+\"\)|url\(\"[^\"]+(\.eot|\.woff|\.ttf|\.png|\.jpg|\.jpeg|\.gif|\.svg)+[^\"]+\"\)|url\(\'[^\']+(\.eot|\.woff|\.ttf|\.png|\.jpg|\.jpeg|\.gif|\.svg)+\'\)|url\(\'[^\']+(\.eot|\.woff|\.ttf|\.png|\.jpg|\.jpeg|\.gif|\.svg)+[^\']+\'\)/";

            preg_match_all($sub_pattern, $sub_file, $sub_urls);

            if (isset($sub_urls[0]) && is_array($sub_urls[0])) {
                $path_1 = "";
                foreach ($sub_urls[0] as $item) {
                    $path_1 = "";

                    $temp_url_1 = str_replace($base_url, '', $item);
                    $temp_url_1 = str_replace('"', '', $temp_url_1);
                    $temp_url_1 = str_replace('\'', '', $temp_url_1);
                    $temp_url_1 = str_replace('url(', '', $temp_url_1);
                    $temp_url_1 = str_replace(')', '', $temp_url_1);


                    $pe = explode('../', $temp_url_1);

                    $vir_1 = "";
                    if (isset($arr_path[count($arr_path) - count($pe)])) {
                        $vir_1 = "/";
                        $path_1 = $arr_path[count($arr_path) - count($pe)];
                    }


                    $temp_url_1 = str_replace('../', '', $temp_url_1);
                    $temp_url_1 = str_replace('./', '', $temp_url_1);


                    $ex_1 = explode("/", $extra_path . $temp_url_1);

                    if (count($ex_1) > 1) {
                        for ($x_1 = 0; $x_1 < count($ex_1) - 1; $x_1++) {
                            $path_1 .= $vir_1 . $ex_1[$x_1];
                            $vir_1 = "/";
                            if (!file_exists(stream_resolve_include_path($path_1))) {

                                mkdir($path_1, 0777, true);
                            }
                        }
                    }


                    $fff_1 = preg_split('/(\?|\#|\?\#)/', $ex_1[count($ex_1) - 1]);
                    // echo '<div>' . $ex_1[count($ex_1) - 1] . '</div>';

                    $ex_pt = str_replace($base_url, '', $path_1);
                    $path_1 .= '/' . $fff_1[0];

                    if (!file_exists(stream_resolve_include_path($path_1))) {
                        file_put_contents($path_1, fopen($base_url . '/' . $path_1, 'r'));
                    }
                }
            }
        } else {
            if (strlen($fff[0]) > 3 && substr($fff[0], -3) == '.js')
            {
                if (!file_exists(stream_resolve_include_path($path.'.map'))) {
                    $map = @file_get_contents($base_url . '/' . $path.'.map');
                    
                    if(strlen($map)>4)
                    {
                        file_put_contents($path.'.map', $map);
                    }
                }
            }
            if (!file_exists(stream_resolve_include_path($path))) {
                file_put_contents($path, fopen($base_file, 'r'));
            }
        }
    }

    if (strlen($extra_path) == 0) {
        $file = @file_get_contents($file_name);


        $file = str_replace($base_url, '', $file);

        file_put_contents($file_name, $file);

        $pattern_1 = "/href=\"[^\"]+(\.html)+\"/";
        $ur = [];
        preg_match_all($pattern_1, $file, $ur);

        // $index_fetch++;
        // if($index_fetch > 2)
        // {
        //    // return;
        // }
        foreach ($ur[0] as $it) {
            $it_url = str_replace('href="', '', $it);
            $it_url = str_replace('"', '', $it_url);
            if (!isset($links[$it_url])) {
                $links[$it_url] = $it_url;
                $temp_url_1 = $it_url;
                $url_arr_1 = explode('/', $temp_url_1);
                if (count($url_arr_1) > 1) {
                    fetch($base_url, $base_url . $it_url, $it_url, $pattern);
                } else {
                    fetch($base_url, $root . $it_url, $it_url, $pattern);
                }
            }
        }
    }
}

fetch($base_url, $site_url, $file_name, $pattern);
//var_dump($links);
// if (!file_exists(stream_resolve_include_path('new-folder'))) {
//     mkdir('new-folder', 0777, true);
// }

// echo $file;