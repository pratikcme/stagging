<?php

function get_country($ip)
{
    $CI = &get_instance();
    $CI->load->model('curl_function');
    $url = "http://api.wipmania.com/" . $ip . "?" . base_url();
    $result = $CI->curl_function->get($url);
    return $result;
}

function admin_url($url = '')
{
    $CI = &get_instance();
    return $CI->config->config['admin_url'] . $url;
}
function get_project_name()
{
    $CI = &get_instance();
    return $CI->config->config['project_name'];
}
function user_url($url = '')
{
    $CI = &get_instance();
    return $CI->config->config['user_url'] . $url;
}

function account_url($url = '')
{
    $CI = &get_instance();
    return $CI->config->config['account_url'];
}

function category_url($url = '')
{
    $CI = &get_instance();
    return $CI->config->config['category_url'];
}
function dashboard_url($url = '')
{
    $CI = &get_instance();
    return $CI->config->config['dashboard_url'];
}
function push_message($url = '')
{
    $CI = &get_instance();
    return $CI->config->config['push_message'];
}
function category_list($url = '')
{
    $CI = &get_instance();
    return $CI->config->config['category_list'];
}
function about_url($url = '')
{
    $CI = &get_instance();
    return $CI->config->config['about_url'];
}
function logout($url = '')
{
    $CI = &get_instance();
    return $CI->config->config['logout'];
}
function skill($url = '')
{
    $CI = &get_instance();
    return $CI->config->config['skill'];
}
function get_skip($page_no = 1, $per_page = 24)
{
    return (($page_no - 1) * $per_page);
}
function venue($url = '')
{
    $CI = &get_instance();
    return $CI->config->config['venue'];
}
function upload_single_image($file, $name, $path, $thumb = FALSE){
    
    $CI = &get_instance();

    $return['error'] = '';
    $image_name = $name . '_' . time();
    $CI->load->helper('form');
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|PNG|JPG|GIF';
    $config['file_name'] = $image_name;

    $CI->load->library('upload', $config);
    $CI->upload->initialize($config);

    $CI->upload->set_allowed_types('gif|jpg|png|jpeg|JPEG|PNG|JPG|GIF');

    if (!$CI->upload->do_upload(key($file))) {
        $return['error'] = $CI->upload->display_errors();
    } else {
        $result = $CI->upload->data();
        $return['data'] = $result;
    }

    if ($thumb == TRUE && $return['error'] == '') {
        $CI->load->library('Mylibrary');
        $thumb_array = array(
            array('width' => '100', 'height' => '100', 'image_type' => 'SMALL'),
            array('width' => '250', 'height' => '250', 'image_type' => 'MEDIUM'));
        for ($i = 0; $i < count($thumb_array); $i++) {
            $imageinfo = getimagesize($result['full_path']);
            $thumbSize = $CI->mylibrary->calculateResizeImage($imageinfo[0], $imageinfo[1], $thumb_array[$i]['width'], $thumb_array[$i]['height']);

            $CI->load->library('image_lib');
            $conf['image_library'] = 'gd2';
            $conf['source_image'] = $path . $result['orig_name'];
            $conf['create_thumb'] = TRUE;
            $conf['maintain_ratio'] = TRUE;
            $conf['new_image'] = $result['orig_name'];
            $conf['thumb_marker'] = "_" . $thumb_array[$i]['image_type'];
            $conf['width'] = $thumbSize['width'];
            $conf['height'] = $thumbSize['height'];
            $CI->image_lib->clear();
            $CI->image_lib->initialize($conf);
            if (!$CI->image_lib->resize()) {
                $return['error'] = 'Thumb Not Created';
            }
        }
    }

    return $return;
}

function upload_single_image_ByName($file, $name, $path, $thumb = FALSE)
{
    $CI = &get_instance();

    $return['error'] = '';
    $image_name = $name . '_' . time();

    $CI->load->helper('form');
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|PNG|JPG';
    $config['file_name'] = $image_name;

    $CI->load->library('upload', $config);
    $CI->upload->initialize($config);

    $CI->upload->set_allowed_types('gif|jpg|png|jpeg|JPEG|PNG|JPG|GIF');

    if (!$CI->upload->do_upload($name)) {
        $return['error'] = $CI->upload->display_errors();
    } else {
        $result = $CI->upload->data();
        $return['data'] = $result;
    }

    if ($thumb == TRUE && $return['error'] == '') {
        $CI->load->library('Mylibrary');
        $thumb_array = array(
            array('width' => '100', 'height' => '100', 'image_type' => 'SMALL'),
            array('width' => '250', 'height' => '250', 'image_type' => 'MEDIUM'));
        for ($i = 0; $i < count($thumb_array); $i++) {
            $imageinfo = getimagesize($result['full_path']);
            $thumbSize = $CI->mylibrary->calculateResizeImage($imageinfo[0], $imageinfo[1], $thumb_array[$i]['width'], $thumb_array[$i]['height']);

            $CI->load->library('image_lib');
            $conf['image_library'] = 'gd2';
            $conf['source_image'] = $path . $result['orig_name'];
            $conf['create_thumb'] = TRUE;
            $conf['maintain_ratio'] = TRUE;
            $conf['new_image'] = $result['orig_name'];
            $conf['thumb_marker'] = "_" . $thumb_array[$i]['image_type'];
            $conf['width'] = $thumbSize['width'];
            $conf['height'] = $thumbSize['height'];
            $CI->image_lib->clear();
            $CI->image_lib->initialize($conf);
            if (!$CI->image_lib->resize()) {
                $return['error'] = 'Thumb Not Created';
            }
        }
    }

    return $return;
}


function delete_single_image($fullPath, $fileName)
{
    unlink($fullPath . '/' . $fileName);
}

function delete_image($array, $path)
{
    $CI = &get_instance();
    $img = $CI->db->select($array['field'])->where('int_glcode', $array['id'])->get($array['table'])->row_array();
    $mainImg = $img[$array['field']];
    $expImg = explode('.', $mainImg);
    $imgdelete = $path . $mainImg;
    if (file_exists($imgdelete)) {
        unlink($imgdelete);
    }
    return TRUE;
}

function apply_lang($string, $delimiter = ' ')
{
    $CI = &get_instance();
    $str_array = explode($delimiter, $string);
    $return_string = '';

    for ($i = 0; $i < count($str_array); $i++) {
        $return_string .= $CI->lang->line($str_array[$i]);
        if ($i < count($str_array)) {
            $return_string .= $delimiter;
        }
    }
    if ($return_string == '') {
        return $CI->lang->line($string);
    }
    return $return_string;
}

function sorttextlen($text, $limit)
{
    if (strlen($text) < $limit) {
        $sort_text = mb_substr($text, 0, $limit);
    } else if (strlen($text) > $limit) {
        $sort_text = mb_substr($text, 0, $limit) . '...';
    }

    return $sort_text;
}


function date_formate($date)
{
    $date = date('M', strtotime($date)) . ' ' . date('j', strtotime($date)) . "'" . date('y', strtotime($date)) . ' at' . ' ' . date('h:i', strtotime($date));
    return $date;
}

function str_replace_first($from, $to, $subject)
{
    $from = '/' . preg_quote($from, '/') . '/';

    return preg_replace($from, $to, $subject, 1);
}

/* ----   Start Function to get the client IP address ----- */
function dd($arr){
    echo "<pre>";
    print_r($arr);
    die;
}
function lq(){
      $CI = &get_instance();
    echo $CI->db->last_query();
    die;
}
function get_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP')) {
        $ipaddress = getenv('HTTP_CLIENT_IP');
    } else if (getenv('HTTP_X_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    } else if (getenv('HTTP_X_FORWARDED')) {
        $ipaddress = getenv('HTTP_X_FORWARDED');
    } else if (getenv('HTTP_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    } else if (getenv('HTTP_FORWARDED')) {
        $ipaddress = getenv('HTTP_FORWARDED');
    } else if (getenv('REMOTE_ADDR')) {
        $ipaddress = getenv('REMOTE_ADDR');
    } else {
        $ipaddress = 'UNKNOWN';
    }
    return $ipaddress;
}

/* ---- End Function to get the client IP address ----- */

function getLoginUserData()
{
    $CI = &get_instance();
    if ($CI->session->userdata['valid_user']) {
        $result = $CI->session->userdata['valid_user'];
    } elseif ($CI->session->userdata['valid_dealer']) {
        $result = $CI->session->userdata['valid_dealer'];
    } elseif ($CI->session->userdata['valid_admin']) {
        $result = $CI->session->userdata['valid_admin'];
    }
    return $result;
}

function get_img($path, $image, $multiple_img = FALSE)
{
    $path = trim($path);
    $image = trim($image);
    if ($multiple_img == TRUE) {
        if (!empty($image)) {
            $img = explode(',', $image);
            if (file_exists($path . $img[0])) {
                $data = base_url() . $path . $img[0];
            } else {
                $data = base_url() . NO_IMAGE;
            }
        } else {
            $data = base_url() . NO_IMAGE;
        }
    } else {
        if (!empty($image) && !empty($path)) {
            if (file_exists($path . $image)) {
                $data = base_url() . $path . $image;
            } else {
                $data = base_url() . NO_IMAGE;
            }
        } else {
            $data = base_url() . NO_IMAGE;
        }
    }
    return $data;
}

function getLoginUserType($userData)
{
    $CI = &get_instance();
    if ($CI->session->userdata['valid_dealer'] && $CI->uri->segment(1) == 'dealer') {
        $result = $CI->session->userdata['valid_dealer'];
    } elseif ($CI->session->userdata['valid_user'] && $CI->uri->segment(1) == 'user') {
        $result = $CI->session->userdata['valid_user'];
    } elseif ($CI->session->userdata['valid_admin'] && $CI->uri->segment(1) == 'admin') {
        $result = $CI->session->userdata['valid_admin'];
    }
    return $result['user_type'];
}

function getbaseURL($url = '')
{
    $CI = &get_instance();
    if ($CI->session->userdata['valid_dealer'] && $CI->uri->segment(1) == 'dealer') {
        return dealer_url($url);
    } elseif ($CI->session->userdata['valid_user'] && $CI->uri->segment(1) == 'user') {
        return user_url($url);
    } elseif ($CI->session->userdata['valid_admin'] && $CI->uri->segment(1) == 'admin') {
        return admin_url($url);
    } else {
        return base_url($url);
    }
}

function tz_date($date, $formate = 'Y-m-d H:i:s', $zone = null)
{
    return date($formate, strtotime($date));
}

function timezone_offset_string($offset)
{
    return sprintf("%s%02d:%02d", ($offset >= 0) ? '+' : '-', abs($offset / 3600), abs($offset % 3600));
}

function getTimezoneOfset($timeZone, $isString = FALSE)
{
    $offset = timezone_offset_get(new DateTimeZone($timeZone), new DateTime());
    if ($isString === TRUE) {
        $offset = timezone_offset_string($offset);
    }
    return $offset;
}

function getTimeZone()
{
    $CI = &get_instance();
    $settings = $CI->authlibrary->getStoreSetting();
    $settings = $settings[0];
    return ($settings['var_time_zone']) ? $settings['var_time_zone'] : "UTC";
}

function date_tz($format = 'Y-m-d H:i:s')
{
    return convert_date_from_utc(date('Y-m-d H:i:s'), getTimeZone(), $format);
}

function array_insert($array, $index, $val)
{
    $size = count($array); //because I am going to use this more than one time
    if (!is_int($index) || $index < 0 || $index > $size) {
        return -1;
    } else {
        $temp = array_slice($array, 0, $index);
        $temp[] = $val;
        return array_merge($temp, array_slice($array, $index, $size));
    }
}

function escapeJavaScriptText($string)
{
    return str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$string), "\0..\37'\\")));
}

function addForeignKey($sourceTable, $sourceField, $targetTable, $targetField = 'id', $onDelete = 'RESTRICT', $onUpdate = 'RESTRICT')
{
    $CI = &get_instance();
    $dbName = $CI->db->database;

    $CI->db->query('ALTER TABLE ' . $dbName . '.`ps_' . $sourceTable . '` ADD INDEX `ps_' . $sourceTable . '_' . $sourceField . '` (`' . $sourceField . '`);');
    $CI->db->query('ALTER TABLE `ps_' . $sourceTable . '` ADD CONSTRAINT `ps_' . $sourceTable . '_' . $sourceField . '` FOREIGN KEY (`' . $sourceField . '`) REFERENCES ' . $dbName . '.`ps_' . $targetTable . '`(`' . $targetField . '`) ON DELETE ' . $onDelete . ' ON UPDATE ' . $onUpdate . '; ');
}

function dropForeignKey($sourceTable, $sourceField, $targetTable, $targetField = 'id')
{
    $CI = &get_instance();
    $CI->db->query('ALTER TABLE ps_' . $sourceTable . ' DROP FOREIGN KEY ps_' . $sourceTable . '_' . $sourceField . ';');
    $CI->db->query('ALTER TABLE ps_' . $sourceTable . ' DROP INDEX ps_' . $sourceTable . '_' . $sourceField . ';');
}

//ALTER TABLE ps_news DROP FOREIGN KEY ps_news_fk_category;

function convertNumber($number)
{
    return preg_replace('/[^\\d.]+/', '', $number);
}


function age_diff($fromdate, $todate)
{
    if (trim($fromdate) != '0000-00-00' && trim($todate) != '0000-00-00' && date('Y-m-d', strtotime($fromdate)) <= date('Y-m-d', strtotime($todate))) {
        $datediff = (new DateTime(date('Y-m-d', strtotime($todate))))->diff((new DateTime(date('Y-m-d', strtotime($fromdate)))));

        if ($datediff->y == 0 && $datediff->m == 0) {
            if ($datediff->d > 1) {
                $result = $datediff->d . ' days';
            } else if ($datediff->d == 1 || $datediff->d == 0) {
                $result = '1 day';
            }
        } else if ($datediff->y == 0 && $datediff->m > 0) {
            if ($datediff->m > 1) {
                $result = $datediff->m . ' months';
            } else if ($datediff->m == 1 || $datediff->m == 0) {
                $result = '1 month';
            }
        } else {
            if ($datediff->y > 1) {
                $result = $datediff->y . ' years ';
            } else {
                $result = $datediff->y . ' year';
            }
        }
    } else {
        $result = '-';
    }
    return $result;
}

function time_ago($datetime, $todate, $seconds = FALSE)
{
    if (is_numeric($datetime)) {
        $timestamp = $datetime;
    } else {
        $timestamp = strtotime($datetime);
    }
    if (is_numeric($todate)) {
        $to_timestamp = $todate;
    } else {
        $to_timestamp = strtotime($todate);
    }
    $diff = $to_timestamp - $timestamp;

    $min = 60;
    $hour = 60 * 60;
    $day = 60 * 60 * 24;
    $month = $day * 30;
    $year = $month * 12;
    $timeago = '';

    if ($diff < 60) { //Under a min
        if ($seconds) {
            $timeago .= $diff . " seconds";
        }
    } elseif ($diff < $hour) { //Under an hour
        $timeago .= round($diff / $min) . " mins";
    } elseif ($diff < $day) { //Under a day
        $timeago .= round($diff / $hour) . " hours";
    } elseif ($diff < $month) { //Under a day
        $timeago .= round($diff / $day) . " days";
    } elseif ($diff < $year) { //Under a day
        $timeago .= round($diff / $month) . " months";
    } else {
        if (round($diff / $year) > 1) {
            $timeago .= round($diff / $year) . " years";
        } else {
            $timeago .= round($diff / $year) . " year";
        }
    }

    return $timeago;
}

function dateDifference($date_1, $date_2, $days = FALSE)
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    $differenceFormat = '';
    $interval = date_diff($datetime1, $datetime2);

    if ($interval->y > 0) {
        if ($interval->y > 1) {
            $differenceFormat .= '%y years';
        } else {
            $differenceFormat .= '1 year';
        }
    }

    if ($interval->m > 0) {
        if ($interval->m > 1) {
            if ($interval->y > 0) {
                $differenceFormat .= ' and %m months';
            } else {
                $differenceFormat .= '%m months';
            }
        } else {
            $differenceFormat .= '1 month';
        }
    }
    if ($days) {
        if ($interval->d > 0) {
            if ($interval->d > 1) {
                if ($interval->m > 0) {
                    $differenceFormat .= ' and %d days';
                } else {
                    $differenceFormat .= '%d days';
                }
            } else {
                $differenceFormat .= '1 day';
            }
        }
    }

    return $interval->format($differenceFormat);
}

function getPastYears($startFromYear = FALSE, $cnt = 50)
{
    if ($startFromYear) {
        $cur_year = $startFromYear;
    } else {
        $cur_year = date('Y');
    }
    for ($i = 0; $i <= $cnt; $i++) {
        $years[] = $cur_year--;
    }
    return $years;
}

function getMonths($full = FALSE)
{

    $months = array(
        '01' => ($full) ? 'January' : 'Jan',
        '02' => ($full) ? 'February' : 'Feb',
        '03' => ($full) ? 'March' : 'Mar',
        '04' => ($full) ? 'April' : 'Apr',
        '05' => ($full) ? 'May' : 'May',
        '06' => ($full) ? 'June' : 'Jun',
        '07' => ($full) ? 'July' : 'Jul',
        '08' => ($full) ? 'August' : 'Aug',
        '09' => ($full) ? 'September' : 'Sep',
        '10' => ($full) ? 'Octomber' : 'Oct',
        '11' => ($full) ? 'November' : 'Nov',
        '12' => ($full) ? 'December' : 'Dec');

    return $months;
}

function sortMultiArray($arr, $k, $sort)
{
    $tmp = Array();
    foreach ($arr as &$ma)
        $tmp[] = &$ma[$k];
    $tmp = array_map('strtolower', $tmp);      // to sort case-insensitive
    array_multisort($tmp, $sort, $arr);
    return $arr;
}


function convert_date($datetime, $sourceTimeZone, $targetTimezone, $format = 'Y-m-d H:i:s')
{
//    echo "$datetime, $sourceTimeZone, $targetTimezone,";exit;
    if(empty($targetTimezone)){
        $targetTimezone="UTC";
    }
    $date = new \DateTime($datetime, new \DateTimeZone($sourceTimeZone));
    $date->setTimezone(new \DateTimeZone($targetTimezone));
    return $date->format($format);
}

function getTimeZoneChoice($selectedzone)
{
    $all = timezone_identifiers_list();

    $html = '';
    for ($i = 0; $i < count($all); $i++) {
        $html .= '<option ' . (($selectedzone == $all[$i]) ? 'selected="selected "' : '') . ' value="' . $all[$i] . '">' . $all[$i] . '</option>';
    }
    return $html;

    $i = 0;
    foreach ($all AS $zone) {
        $zone = explode('/', $zone);
        $zonen[$i]['continent'] = isset($zone[0]) ? $zone[0] : '';
        $zonen[$i]['city'] = isset($zone[1]) ? $zone[1] : '';
        $zonen[$i]['subcity'] = isset($zone[2]) ? $zone[2] : '';
        $i++;
    }

    asort($zonen);

    $structure = '';
    foreach ($zonen AS $zone) {
        extract($zone);
        if ($continent == 'Africa' || $continent == 'America' || $continent == 'Antarctica' || $continent == 'Arctic' || $continent == 'Asia' || $continent == 'Atlantic' || $continent == 'Australia' || $continent == 'Europe' || $continent == 'Indian' || $continent == 'Pacific') {
            if (!isset($selectcontinent)) {
                $structure .= '<optgroup label="' . $continent . '">'; // continent
            } elseif ($selectcontinent != $continent) {
                $structure .= '</optgroup><optgroup label="' . $continent . '">'; // continent
            }

            if (isset($city) != '') {
                if (!empty($subcity) != '') {
                    $city = $city . '/' . $subcity;
                }
                $structure .= "<option " . ((($continent . '/' . $city) == $selectedzone) ? 'selected="selected "' : '') . " value=\"" . ($continent . '/' . $city) . "\">" . str_replace('_', ' ', $city) . "</option>"; //Timezone
            } else {
                if (!empty($subcity) != '') {
                    $city = $city . '/' . $subcity;
                }
                $structure .= "<option " . (($continent == $selectedzone) ? 'selected="selected "' : '') . " value=\"" . $continent . "\">" . $continent . "</option>"; //Timezone
            }

            $selectcontinent = $continent;
        }
    }
    $structure .= '</optgroup>';
    return $structure;
}

function getTimeZoneList()
{
    return timezone_identifiers_list();
}

function getExpertTimeZone($id)
{
    $CI = &get_instance();
    return $CI->db->get_where('experts', array('id' => $id))->row_array()['var_timezone'];
}

function getClientTimeZone($id)
{
    $CI = &get_instance();
    return $CI->db->get_where('client', array('id' => $id))->row_array()['var_timezone'];
}

function formatNumber($number)
{
    if ($number != '') {
        return sprintf("%s %s %s %s",
            substr($number, 0, 3),
            substr($number, 3, 3),
            substr($number, 6, 3),
            substr($number, 9));
    } else {
        return $number;
    }
}

function isFileExist($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // $retcode >= 400 -> not found, $retcode = 200, found.
    curl_close($ch);
    if ($responseCode == 200) {
        return true;
    } else {
        return false;
    }

}
if(!function_exists('GetDialcodelist'))
        {
            function GetDialcodelist()
            {
                $arr =    array(
                    "+213"=>"Algeria (+213)",
                    "+376"=>"Andorra (+376)",
                    "+244"=>"Angola (+244)",
                    "+1264"=>"Anguilla (+1264)",
                    "+1268"=>"Antigua & Barbuda (+1268)",
                    "+54"=>"Argentina (+54)",
                    "+374"=>"Armenia (+374)",
                    "+297"=>"Aruba (+297)",
                    "+61"=>"Australia (+61)",
                    "+43"=>"Austria (+43)",
                    "+994"=>"Azerbaijan (+994)",
                    "+1242"=>"Bahamas (+1242)",
                    "+973"=>"Bahrain (+973)",
                    "+880"=>"Bangladesh (+880)",
                    "+1246"=>"Barbados (+1246)",
                    "+375"=>"Belarus (+375)",
                    "+32"=>"Belgium (+32)",
                    "+501"=>"Belize (+501)",
                    "+229"=>"Benin (+229)",
                    "+1441"=>"Bermuda (+1441)",
                    "+975"=>"Bhutan (+975)",
                    "+591"=>"Bolivia (+591)",
                    "+387"=>"Bosnia Herzegovina (+387)",
                    "+267"=>"Botswana (+267)",
                    "+55"=>"Brazil (+55)",
                    "+673"=>"Brunei (+673)",
                    "+359"=>"Bulgaria (+359)",
                    "+226"=>"Burkina Faso (+226)",
                    "+257"=>"Burundi (+257)",
                    "+855"=>"Cambodia (+855)",
                    "+237"=>"Cameroon (+237)",
                    "+1"=>"Canada (+1)",
                    "+238"=>"Cape Verde Islands (+238)",
                    "+1345"=>"Cayman Islands (+1345)",
                    "+236"=>"Central African Republic (+236)",
                    "+56"=>"Chile (+56)",
                    "+86"=>"China (+86)",
                    "+57"=>"Colombia (+57)",
                    "+269"=>"Comoros (+269)",
                    "+242"=>"Congo (+242)",
                    "+682"=>"Cook Islands (+682)",
                    "+506"=>"Costa Rica (+506)",
                    "+385"=>"Croatia (+385)",
                    "+53"=>"Cuba (+53)",
                    "+90392"=>"Cyprus North (+90392)",
                    "+357"=>"Cyprus South (+357)",
                    "+42"=>"Czech Republic (+42)",
                    "+45"=>"Denmark (+45)",
                    "+253"=>"Djibouti (+253)",
                    "+1809"=>"Dominica (+1809)",
                    "+1809"=>"Dominican Republic (+1809)",
                    "+593"=>"Ecuador (+593)",
                    "+20"=>"Egypt (+20)",
                    "+503"=>"El Salvador (+503)",
                    "+240"=>"Equatorial Guinea (+240)",
                    "+291"=>"Eritrea (+291)",
                    "+372"=>"Estonia (+372)",
                    "+251"=>"Ethiopia (+251)",
                    "+500"=>"Falkland Islands (+500)",
                    "+298"=>"Faroe Islands (+298)",
                    "+679"=>"Fiji (+679)",
                    "+358"=>"Finland (+358)",
                    "+33"=>"France (+33)",
                    "+594"=>"French Guiana (+594)",
                    "+689"=>"French Polynesia (+689)",
                    "+241"=>"Gabon (+241)",
                    "+220"=>"Gambia (+220)",
                    "+7880"=>"Georgia (+7880)",
                    "+49"=>"Germany (+49)",
                    "+233"=>"Ghana (+233)",
                    "+350"=>"Gibraltar (+350)",
                    "+30"=>"Greece (+30)",
                    "+299"=>"Greenland (+299)",
                    "+1473"=>"Grenada (+1473)",
                    "+590"=>"Guadeloupe (+590)",
                    "+671"=>"Guam (+671)",
                    "+502"=>"Guatemala (+502)",
                    "+224"=>"Guinea (+224)",
                    "+245"=>"Guinea - Bissau (+245)",
                    "+592"=>"Guyana (+592)",
                    "+509"=>"Haiti (+509)",
                    "+504"=>"Honduras (+504)",
                    "+852"=>"Hong Kong (+852)",
                    "+36"=>"Hungary (+36)",
                    "+354"=>"Iceland (+354)",
                    "+91"=>"India (+91)",
                    "+62"=>"Indonesia (+62)",
                    "+98"=>"Iran (+98)",
                    "+964"=>"Iraq (+964)",
                    "+353"=>"Ireland (+353)",
                    "+972"=>"Israel (+972)",
                    "+39"=>"Italy (+39)",
                    "+1876"=>"Jamaica (+1876)",
                    "+81"=>"Japan (+81)",
                    "+962"=>"Jordan (+962)",
                    "+7"=>"Kazakhstan (+7)",
                    "+254"=>"Kenya (+254)",
                    "+686"=>"Kiribati (+686)",
                    "+850"=>"Korea North (+850)",
                    "+82"=>"Korea South (+82)",
                    "+965"=>"Kuwait (+965)",
                    "+996"=>"Kyrgyzstan (+996)",
                    "+856"=>"Laos (+856)",
                    "+371"=>"Latvia (+371)",
                    "+961"=>"Lebanon (+961)",
                    "+266"=>"Lesotho (+266)",
                    "+231"=>"Liberia (+231)",
                    "+218"=>"Libya (+218)",
                    "+417"=>"Liechtenstein (+417)",
                    "+370"=>"Lithuania (+370)",
                    "+352"=>"Luxembourg (+352)",
                    "+853"=>"Macao (+853)",
                    "+389"=>"Macedonia (+389)",
                    "+261"=>"Madagascar (+261)",
                    "+265"=>"Malawi (+265)",
                    "+60"=>"Malaysia (+60)",
                    "+960"=>"Maldives (+960)",
                    "+223"=>"Mali (+223)",
                    "+356"=>"Malta (+356)",
                    "+692"=>"Marshall Islands (+692)",
                    "+596"=>"Martinique (+596)",
                    "+222"=>"Mauritania (+222)",
                    "+269"=>"Mayotte (+269)",
                    "+52"=>"Mexico (+52)",
                    "+691"=>"Micronesia (+691)",
                    "+373"=>"Moldova (+373)",
                    "+377"=>"Monaco (+377)",
                    "+976"=>"Mongolia (+976)",
                    "+1664"=>"Montserrat (+1664)",
                    "+212"=>"Morocco (+212)",
                    "+258"=>"Mozambique (+258)",
                    "+95"=>"Myanmar (+95)",
                    "+264"=>"Namibia (+264)",
                    "+674"=>"Nauru (+674)",
                    "+977"=>"Nepal (+977)",
                    "+31"=>"Netherlands (+31)",
                    "+687"=>"New Caledonia (+687)",
                    "+64"=>"New Zealand (+64)",
                    "+505"=>"Nicaragua (+505)",
                    "+227"=>"Niger (+227)",
                    "+234"=>"Nigeria (+234)",
                    "+683"=>"Niue (+683)",
                    "+672"=>"Norfolk Islands (+672)",
                    "+670"=>"Northern Marianas (+670)",
                    "+47"=>"Norway (+47)",
                    "+968"=>"Oman (+968)",
                    "+680"=>"Palau (+680)",
                    "+507"=>"Panama (+507)",
                    "+675"=>"Papua New Guinea (+675)",
                    "+595"=>"Paraguay (+595)",
                    "+51"=>"Peru (+51)",
                    "+63"=>"Philippines (+63)",
                    "+48"=>"Poland (+48)",
                    "+351"=>"Portugal (+351)",
                    "+1787"=>"Puerto Rico (+1787)",
                    "+974"=>"Qatar (+974)",
                    "+262"=>"Reunion (+262)",
                    "+40"=>"Romania (+40)",
                    "+7"=>"Russia (+7)",
                    "+250"=>"Rwanda (+250)",
                    "+378"=>"San Marino (+378)",
                    "+239"=>"Sao Tome & Principe (+239)",
                    "+966"=>"Saudi Arabia (+966)",
                    "+221"=>"Senegal (+221)",
                    "+381"=>"Serbia (+381)",
                    "+248"=>"Seychelles (+248)",
                    "+232"=>"Sierra Leone (+232)",
                    "+65"=>"Singapore (+65)",
                    "+421"=>"Slovak Republic (+421)",
                    "+386"=>"Slovenia (+386)",
                    "+677"=>"Solomon Islands (+677)",
                    "+252"=>"Somalia (+252)",
                    "+27"=>"South Africa (+27)",
                    "+34"=>"Spain (+34)",
                    "+94"=>"Sri Lanka (+94)",
                    "+290"=>"St. Helena (+290)",
                    "+1869"=>"St. Kitts (+1869)",
                    "+1758"=>"St. Lucia (+1758)",
                    "+249"=>"Sudan (+249)",
                    "+597"=>"Suriname (+597)",
                    "+268"=>"Swaziland (+268)",
                    "+46"=>"Sweden (+46)",
                    "+41"=>"Switzerland (+41)",
                    "+963"=>"Syria (+963)",
                    "+886"=>"Taiwan (+886)",
                    "+7"=>"Tajikstan (+7)",
                    "+66"=>"Thailand (+66)",
                    "+228"=>"Togo (+228)",
                    "+676"=>"Tonga (+676)",
                    "+1868"=>"Trinidad & Tobago (+1868)",
                    "+216"=>"Tunisia (+216)",
                    "+90"=>"Turkey (+90)",
                    "+7"=>"Turkmenistan (+7)",
                    "+993"=>"Turkmenistan (+993)",
                    "+1649"=>"Turks & Caicos Islands (+1649)",
                    "+688"=>"Tuvalu (+688)",
                    "+44"=>"UK (+44)",
                    "+1"=>"USA (+1)",
                    "+256"=>"Uganda (+256)",
                    "+380"=>"Ukraine (+380)",
                    "+971"=>"United Arab Emirates (+971)",
                    "+598"=>"Uruguay (+598)",
                    "+7"=>"Uzbekistan (+7)",
                    "+678"=>"Vanuatu (+678)",
                    "+379"=>"Vatican City (+379)",
                    "+58"=>"Venezuela (+58)",
                    "+84"=>"Vietnam (+84)",
                    "+84"=>"Virgin Islands - British (+1284)",
                    "+84"=>"Virgin Islands - US (+1340)",
                    "+681"=>"Wallis & Futuna (+681)",
                    "+969"=>"Yemen (North)(+969)",
                    "+967"=>"Yemen (South)(+967)",
                    "+260"=>"Zambia (+260)",
                    "+263"=>"Zimbabwe (+263)",
                );
                return $arr;
            }   
        }