<?php
if (!function_exists('session_regenerate_id')) {

    function php_combined_lcg() {
        $tv = gettimeofday();
        $lcg['s1'] = $tv['sec'] ^ (~$tv['usec']);
        $lcg['s2'] = posix_getpid();

        $q = (int) ($lcg['s1'] / 53668);
        $lcg['s1'] = (int) (40014 * ($lcg['s1'] - 53668 * $q) - 12211 * $q);

        if ($lcg['s1'] < 0)
            $lcg['s1'] += 2147483563;

        $q = (int) ($lcg['s2'] / 52774);
        $lcg['s2'] = (int) (40692 * ($lcg['s2'] - 52774 * $q) - 3791 * $q);
        if ($lcg['s2'] < 0)
            $lcg['s2'] += 2147483399;

        $z = (int) ($lcg['s1'] - $lcg['s2']);
        if ($z < 1) {
            $z += 2147483562;
        }
        return $z * 4.656613e-10;
    }

    function session_regenerate_id() {
        $tv = gettimeofday();
        $buf = sprintf("%.15s%ld%ld%0.8f", $_SERVER['REMOTE_ADDR'], $tv['sec'], $tv['usec'], php_combined_lcg() * 10);
        session_id(md5($buf));

        if (ini_get('session.use_cookies'))
            setcookie('PHPSESSID', session_id(), NULL, '/');

        return TRUE;
    }

}
function convert_number_to_words($number) {
    $hyphen = '-';
    $conjunction = ' and ';
    $separator = ', ';
    $negative = 'negative ';
    $decimal = ' point ';
    $dictionary = array(
      0 => 'zero',
      1 => 'one',
      2 => 'two',
      3 => 'three',
      4 => 'four',
      5 => 'five',
      6 => 'six',
      7 => 'seven',
      8 => 'eight',
      9 => 'nine',
      10 => 'ten',
      11 => 'eleven',
      12 => 'twelve',
      13 => 'thirteen',
      14 => 'fourteen',
      15 => 'fifteen',
      16 => 'sixteen',
      17 => 'seventeen',
      18 => 'eighteen',
      19 => 'nineteen',
      20 => 'twenty',
      30 => 'thirty',
      40 => 'fourty',
      50 => 'fifty',
      60 => 'sixty',
      70 => 'seventy',
      80 => 'eighty',
      90 => 'ninety',
      100 => 'hundred',
      1000 => 'thousand',
      1000000 => 'million',
      1000000000 => 'billion',
      1000000000000 => 'trillion',
      1000000000000000 => 'quadrillion',
      1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;

        case $number < 100:
            $tens = ((int) ($number / 10)) * 10;
            $units = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;

        case $number < 1000:
            $hundreds = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;

        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    return $string;
}

function limit_words($string, $word_limit) {
    $words = explode(" ", $string);
    return implode(" ", array_splice($words, 0, $word_limit));
}

function sendMail($toName, $toEmail, $subject, $bodyMsg) {
    require ("phpmailer/class.phpmailer.php");
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = "mail.bceindia.club";
    $mail->SMTPAuth = true;
    //$mail->SMTPSecure = "ssl";
    $mail->Port = 587;
    $mail->Username = "noreply@bceindia.club";
    $mail->Password = "UTj_LI@DUSJU";
    $mail->From = "noreply@bceindia.club";
    $mail->FromName = "Business Club of Entrepreneurs";
    $mail->AddAddress($toEmail);
    $mail->IsHTML(true);
    $mail->Subject = $subject;
    $mail->Body = preg_replace('/ \+/', ' ', $bodyMsg);

    //$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
    $mailed = $mail->Send();
    unset($mail);
    return $mailed;
}

//Amit Encryption Starts here
// Input: A decimal number as a String.
// Output: The equivalent hexadecimal number as a String.
//function dec2hex($number) {
//    $hexvalues = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
//    $hexval = '';
//    while ($number != '0') {
//        $hexval = $hexvalues[bcmod($number, '16')] . $hexval;
//        $number = bcdiv($number, '16', 0);
//    }
//    return $hexval;
//}
//
//// Input: A hexadecimal number as a String.
//// Output: The equivalent decimal number as a String.
//function hex2dec($number) {
//    $decvalues = array('0' => '0', '1' => '1', '2' => '2',
//      '3' => '3', '4' => '4', '5' => '5',
//      '6' => '6', '7' => '7', '8' => '8',
//      '9' => '9', 'a' => '10', 'b' => '11',
//      'c' => '12', 'd' => '13', 'e' => '14',
//      'f' => '15');
//    $decval = '0';
//    $number = strrev($number);
//    for ($i = 0; $i < strlen($number); $i++) {
//        $decval = bcadd(bcmul(bcpow('16', $i, 0), $decvalues[$number[$i]]), $decval);
//    }
//    return $decval;
//}

function ob_html_compress($buf) {
    // return str_replace(array("\n","\r","\t"),'',$buf);
    return preg_replace(array('/<!--(.*)-->/Uis', "/[[:blank:]]+/"), array('', ' '), str_replace(array("\n", "\r", "\t"), '', $buf));
}

function smart_resize_image($file, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false) {

    if ($height <= 0 && $width <= 0)
        return false;
    # Setting defaults and meta
    $info = getimagesize($file);
    $image = '';
    $final_width = 0;
    $final_height = 0;
    list($width_old, $height_old) = $info;
    # Calculating proportionality
    if ($proportional) {
        if ($width == 0)
            $factor = $height / $height_old;
        elseif ($height == 0)
            $factor = $width / $width_old;
        else
            $factor = min($width / $width_old, $height / $height_old);
        $final_width = round($width_old * $factor);
        $final_height = round($height_old * $factor);
    } else {
        $final_width = ( $width <= 0 ) ? $width_old : $width;
        $final_height = ( $height <= 0 ) ? $height_old : $height;
    }
    # Loading image to memory according to type
    switch ($info[2]) {
        case IMAGETYPE_GIF: $image = imagecreatefromgif($file);
            break;
        case IMAGETYPE_JPEG: $image = imagecreatefromjpeg($file);
            break;
        case IMAGETYPE_PNG: $image = imagecreatefrompng($file);
            break;
        default: return false;
    }


    # This is the resizing/resampling/transparency-preserving magic
    $image_resized = imagecreatetruecolor($final_width, $final_height);
    if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
        $transparency = imagecolortransparent($image);
        if ($transparency >= 0) {
            $transparent_color = imagecolorsforindex($image, $trnprt_indx);
            $transparency = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
            imagefill($image_resized, 0, 0, $transparency);
            imagecolortransparent($image_resized, $transparency);
        } elseif ($info[2] == IMAGETYPE_PNG) {
            imagealphablending($image_resized, false);
            $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
            imagefill($image_resized, 0, 0, $color);
            imagesavealpha($image_resized, true);
        }
    }
    imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);

    # Taking care of original, if needed
    if ($delete_original) {
        if ($use_linux_commands)
            exec('rm ' . $file);
        else
            @unlink($file);
    }
    # Preparing a method of providing result
    switch (strtolower($output)) {
        case 'browser':
            $mime = image_type_to_mime_type($info[2]);
            header("Content-type: $mime");
            $output = NULL;
            break;
        case 'file':
            $output = $file;
            break;
        case 'return':
            return $image_resized;
            break;
        default:
            break;
    }

    # Writing image according to type to the output destination
    switch ($info[2]) {
        case IMAGETYPE_GIF: imagegif($image_resized, $output);
            break;
        case IMAGETYPE_JPEG: imagejpeg($image_resized, $output);
            break;
        case IMAGETYPE_PNG: imagepng($image_resized, $output);
            break;
        default: return false;
    }
    return true;
}

function pageination($page_rows = "", $sQLData = "", $db = "") {
    //echo $sQLData;
    //  echo "SELECT COUNT(*) FROM $sQLData";
    $resultscity = $db->query("SELECT COUNT(*) FROM $sQLData");
    $gettotalrows = $resultscity->fetch_row(); //hold total records in variable
    $rows = $gettotalrows[0];
    if (empty($page_rows)) {
        $page_rows = 50;
    }
    //$page_rows = 50;
    $last = ceil($rows / $page_rows);
    if ($last < 1) {
        $last = 1;
    }
    $pagenum = 1;
    if (isset($_GET['pn'])) {
        $pagenum = preg_replace('#[^0-9]#', '', $_GET['pn']);
    }
    if ($pagenum < 1) {
        $pagenum = 1;
    } else if ($pagenum > $last) {
        $pagenum = $last;
    }
    $limit = 'LIMIT ' . ($pagenum - 1) * $page_rows . ',' . $page_rows;
    $data = $db->query("SELECT * FROM $sQLData $limit");
    // pagination design start
    $paginationCtrls = '';
    if ($last != 1) {
        if ($pagenum > 1) {
            $previous = $pagenum - 1;
            $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=" class="btn btn-default btn-sm "><< </a> &nbsp;';
            $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '" class="btn btn-default  btn-sm ">Previous</a> &nbsp; &nbsp; ';
            for ($i = $pagenum - 4; $i < $pagenum; $i++) {
                if ($i > 0) {
                    $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $i . '" class="btn btn-default btn-sm ">' . $i . '</a> ';
                }
            }
        }
        $paginationCtrls .= '<button type="button" class="btn btn-primary btn-sm">' . $pagenum . '</button>';
        for ($i = $pagenum + 1; $i <= $last; $i++) {
            $paginationCtrls .= '<a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $i . '" class="btn btn-default btn-sm ">' . $i . '</a>';
            if ($i >= $pagenum + 4) {
                break;
            }
        }
        if ($pagenum != $last) {
            $next = $pagenum + 1;
            $paginationCtrls .= ' &nbsp; &nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $next . '" class="btn btn-default btn-sm ">Next</a> ';
            $paginationCtrls .= ' &nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $last . '" class="btn btn-default btn-sm "> >></a> ';
        }
    }
    if ($pagenum < 1) {
        $sl = 0;
    } else {
        $sl = $page_rows * ($pagenum - 1);
    }
    $returnData['data'] = $data;
    $returnData['sl'] = $sl;
    $returnData['rows'] = $rows;
    $returnData['paginationCtrls'] = $paginationCtrls;
    return $returnData;
}

function seo_friendly_url($string) {
    // Remove all non-word characters
    $string = preg_replace('/[^\w\s]/', '', $string);

    // Replace all spaces with hyphens
    $string = str_replace(' ', '-', $string);

    // Convert the string to lowercase
    $string = strtolower($string);

    // Remove any duplicate hyphens
    $string = preg_replace('/-+/', '-', $string);

    // Trim any leading or trailing hyphens
    $string = trim($string, '-');

    // Return the SEO-friendly URL
    return $string;
}

function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = '1122334455667788';
    $secret_iv = 'SHOPWEBkey';
    // hash
    $key = hash('sha256', $secret_key);
    // iv - encrypt method AES-256-CBC expects 16 bytes
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if ($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function getUserIP() {
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}
