<?php
// error_reporting(0);
class Utility_apiv2
{
    
    /*
     * REFERENCE BY :
     * http://stackoverflow.com/questions/27633584/php-fatal-error-call-to-undefined-function-mcrypt-get-iv-size-in-appserv
     */
    public $skey = "SHAREMYPET_PRODUCT-CRTD16092016\0";
                    
    function encodeText($value, $removeTags = false)
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $val = $removeTags ? strip_tags($v) : $v;
                $val = addslashes($val);
                $value [$k] = $val;
            }
        }
        else {
            $value = $removeTags ? strip_tags($value) : $value;
            $value = addslashes($value);
        }
        return $value;
    }

    function decodeText($value, $htmlEntity = true)
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $val = stripslashes($v);
                $value [$k] = $htmlEntity ? htmlentities($val) : $val;
            }
        }
        elseif (is_object($value)) {
            foreach ($value as $k => $v) {
                $val = stripslashes($v);
                $value->$k = $htmlEntity ? htmlentities($val) : $val;
            }
        }
        else {
            $value = stripslashes($value);
            $value = $htmlEntity ? htmlentities($value) : $value;
        }
        return $value;
    }

    public function safe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array(
            '+',
            '/',
            '='
        ), array(
            '-',
            '_',
            ''
        ), $data);
        return $data;
    }

    public function safe_b64decode($string)
    {
        $data = str_replace(array(
            '-',
            '_'
        ), array(
            '+',
            '/'
        ), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public function encode($value)
    {   
        $data = base64_encode($value);
        $data = str_replace(array(
            '+',
            '/',
            '='
        ), array(
            '-',
            '_',
            ''
        ), $data);
        return $data;
    }

    public function decode($value)
    {
        if (! $value) {
            return false;
        }
        $data = str_replace(array(
            '-',
            '_'
        ), array(
            '+',
            '/'
        ), $value);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public function setFlashMessage($type, $message)
    {
        $CI = & get_instance();
        $template = '<div class="alert alert-' . $type . ' alert-dismissible text-center" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						   <span aria-hidden="true">&times;</span>
							</button>' . $message . '</div>';
        
        $CI->session->set_flashdata("myMessage", $template);
    }

    public function setFlashMessage_cartValue($type, $message)
    {
        $CI = & get_instance();
        $template = '<div class="alert alert-' . $type . ' alert-dismissible text-center" id="cart_value" data-msg="'. $message . '" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                            </button>' . $message . '</div>';
        
        $CI->session->set_flashdata("myMessage", $template);
    }

    public function sendMailSMTP($data)
    {
        $config ['protocol'] = "smtp";
        $config ['smtp_host'] = SMTP_HOST;
        $config ['smtp_port'] = SMTP_PORT;
        $config ['smtp_user'] = SMTP_USER;
        $config ['smtp_pass'] = SMTP_PASS;
        $config ['smtp_timeout'] = 20;
        $config ['priority'] = 1;
        
        $config ['charset'] = 'utf-8';
        $config ['wordwrap'] = TRUE;
        $config ['crlf'] = "\r\n";
        $config ['newline'] = "\r\n";
        $config ['mailtype'] = "html";
        
        $CI = & get_instance();
        $message = $data ["message"];
        $CI->load->library('email', $config);
        $CI->email->initialize($config);
        $CI->email->clear();
        $CI->email->from($config ['smtp_user'], PROJECT_NAME);
        $CI->email->to($data ["to"]);
        if (isset($data ["bcc"])) {
            $CI->email->bcc($data ["bcc"]);
        }
        $CI->email->reply_to($config ['smtp_user'], '<noreply@stagegator.com>');
        $CI->email->subject($data ["subject"]);
        $CI->email->message($message);
        $response = $CI->email->send();
        
        return true;
    }
      
    /**
     * fbShareButton()
     * This function is used to facebook share button
     *
     * Developer - Pravin Dabhi
     * Datetime - 7-11-2016 03:44
     *
     * @param : $content: String content to share
     * @return : Google plus share button
     */
    public function fbShareButton($image = null, $title = null, $description = null, $url = null)
    {
        $description = urldecode($description);
        $description = str_replace([
            "</br>",
            "<br/>",
            "</p>"
        ], [
            "\r\n",
            "\r\n",
            "</p>\r\n"
        ], $description);
        $description = strip_tags($description);
        $description = urlencode($description);
        ?>
<a
	href="https://www.facebook.com/sharer/sharer.php?u=<?=$url?>&title=<?php echo trim($title); ?>
        		<?php if($image != ""){?>&picture=<?php echo $image; ?> <?php } ?>&description=<?php echo $description; ?>"
	onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
	target="_blank" title="Share on Facebook"><img
	src="<?php echo EXTERNAL_PATH ?>images/fb_share_s.png" /> </a>

<?php
    }
    
    
    function sendNotification($deviceToken,$type=null,$result,$unread=null,$key=NULL){
            $jsonData = '';
        $message = array(
            'message' => $deviceToken['message'],
        );
            if($deviceToken['type'] == 'i' || $deviceToken['type']=='I'){
                $this->notificationForIOS($deviceToken,$message,$type,$unread,$key,$result);
            }else if($deviceToken['type'] == 'a' || $deviceToken['type']=='A'){
                $this->notificationForAndroid($deviceToken,$message,$jsonData,$type,$unread,$key,$result);
            }
        // print_r($deviceToken);exit;
        //         echo 2;exit;
        return TRUE;
    }
     
    function notificationForIOS_old($deviceId,$msg,$jsonData,$type,$unread,$key){
        if($key==NULL){
            $ck = 'ck.pem';
        }else{
            $ck = 'ck_delivery.pem';
        }

           // echo $ck;exit;
        $passphrase = '1234';

        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $ck);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 30, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

        
        $message = $msg;

            // Create the payload body
        $body ['aps'] = array(
            'alert' => $message['message'],
            'badge' => (int)$unread,
            'sound' => 'default',
            'type' => $type,
        );
                // 'data' => $jsonData,

            // Encode the payload as JSON
        $payload = json_encode($body);

            // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceId) . pack('n', strlen($payload)) . $payload;

            // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));
//            var_dump($result); die;
        fclose($fp);
            
    }

    function notificationForIOS($deviceIds,$msg,$status,$unread,$key,$result) {
        // $CI = &get_instance();
        // $CI->load->model('common_model');        
        // $result = $CI->common_model->getNotificationKey();
        // if(empty($result)){
        //     return true;
        // }
        $key_id = $result[0]->key_id;
        $team_id = $result[0]->team_id;
        $user_bandle_id = $result[0]->user_bandle_id;
        $staff_bandle_id = $result[0]->staff_bandle_id;
        $delivery_bandle_id = $result[0]->delivery_bandle_id;
        $admin_bandle_id = $result[0]->admin_bandle_id;

        $deviceId = $deviceIds['device_id'];
        // echo $deviceId;die;
        // $deviceId = 'E5FA6E1F6E840ABB449336B52B10C63C3A228C18D9133CDA6DE75CB4D2A3D004';
        $msg = $msg['message'];

       if(!isset($deviceIds['for_admin'])){

            if(isset($deviceIds['for_staff'])){
                $ck = $staff_bandle_id;
            }else{
                
                if($key==NULL){
                    $ck = $user_bandle_id;
                }else{
                    $ck = $delivery_bandle_id;
                }
            }
       }else{
            $ck = $admin_bandle_id;
       }

        $payload = array(
            'iss' => $team_id,
            'iat' => time()
        );
        # <- Your AuthKey file
          $keyfile = 'AuthKey_QUHR7V9B5Z.p8';
          if($result[0]->p8_file != ''){
            $keyfile = $result[0]->p8_file;               # <- Your AuthKey file  
          }  
          
          $keyid = $key_id;                            # <- Your Key ID
          $teamid = $team_id;                           # <- Your Team ID (see Developer Portal)
          $bundleid = $ck;                # <- Your Bundle ID
         
          $url = 'https://api.development.push.apple.com';  # <- development url, or use http://api.push.apple.com for production environment
          // $token = '5412db72d82307bb3b606eeae2885bd742c2acc9806a7c0f4b76b9b723e11adf';              # <- Device Token
          $token = $deviceId;              # <- Device Token

          $message = '{"aps":{"alert":"'.$msg.'","sound":"default","status":"'.$status.'"}}';
          $key = openssl_pkey_get_private('file://'.$keyfile);
          $header = ['alg'=>'ES256','kid'=>$keyid];
          $claims = ['iss'=>$teamid,'iat'=>time()];

          $header_encoded = $this->base64($header);
          $claims_encoded = $this->base64($claims);

          $signature = '';
          openssl_sign($header_encoded . '.' . $claims_encoded, $signature, $key, 'sha256');
          $jwt = $header_encoded . '.' . $claims_encoded . '.' . base64_encode($signature);

          // only needed for PHP prior to 5.5.24
          if (!defined('CURL_HTTP_VERSION_2_0')) {
              define('CURL_HTTP_VERSION_2_0', 3);
          }

          $http2ch = curl_init();
          curl_setopt_array($http2ch, array(
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
            CURLOPT_URL => "$url/3/device/$token",
            CURLOPT_PORT => 443,
            CURLOPT_HTTPHEADER => array(
              "apns-topic: {$bundleid}",
              "authorization: bearer $jwt"
          ),
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => $message,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HEADER => 1
        ));

          $result = curl_exec($http2ch);
          if ($result === FALSE) {
            throw new Exception("Curl failed: ".curl_error($http2ch));
        }

        $status = curl_getinfo($http2ch, CURLINFO_HTTP_CODE);
    }

        function base64($data) {
        return rtrim(strtr(base64_encode(json_encode($data)), '+/', '-_'), '=');
    }
    
    function notificationForAndroid($deviceId,$msg,$jsonData,$type , $unread,$key,$result) {
        
        // print_r($result);die;
        // $firebase_key = $result[0]->user_firebase_key;
        // print_r($firebase_key);die;
        $message = $msg;

        $body['message'] = $message['message'];
        $body['title'] = "Grocery";
        $body['type'] = $type;
        $body['badge'] = $unread;
        $body['notify'] = 'notification';

        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'to' => $deviceId['device_id'],                
            'data' => $body
        );
            // echo $key;exit;
        $fields_json = json_encode($fields);
        if(!isset($deviceId['for_admin'])){
          
            if(isset($deviceId['delivery_notification'])){
            // echo '1';die;
                $headers = array(
                    'Authorization: key= '.$result[0]->delivery_firebase_key,
                    'Content-Type: application/json'
                );
            // print_r($headers);die;
            }else{

                if($key==NULL){
                // $headers = array(
                //     'Authorization: key= AAAAN7pGzqM:APA91bGjSoksYAJHdxtvBaNqt2VCqKuNiBzJiYsMwvNVuyGAJ8Iuj1HNEClo_VkzgdGuTHWoHp7O9FYP7Et_l2eI_iNNEEePeao3Q5qlVNNMIsp93_60xvxAAPMvIspLzQ3nsFM6_9n7',
                //     'Content-Type: application/json'
                // );
                   $headers = array(
                    'Authorization: key= '.$result[0]->user_firebase_key,
                    'Content-Type: application/json'
                );

               }else{
                $headers = array(
                    'Authorization: key= '.$result[0]->staff_firebase_key,
                    'Content-Type: application/json'
                );
            }
        }
    }else{
        $admin_firebase_key = 'AAAAYmVu0RM:APA91bGMSKZnWRlSZrDilKghySf-ywPbiyRgT5C0Gnfa4-TQRI-Bz7-RiKL6FbL632rbX7mNIszlDnJ1dAogf4GFOBaSRAi5NcxnRlOdXbAxhDVoVOjXiqfICuHPCpnlGysK4_Ygitx9';
        $headers = array(
            'Authorization: key= '.$admin_firebase_key,
            'Content-Type: application/json'
        );
    } 
        // print_r($headers);die;
        //         echo $key;exit;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_json);
        $result = curl_exec($ch);
        curl_close($ch);
            // print_r($result);exit;
        return $result;
            
        }

    function notificationForAndroid_old($deviceId,$msg,$jsonData,$type , $unread) {
            $message = $msg;
            
            $url = 'https://fcm.googleapis.com/fcm/send';
            $fields = array(
                'to' => $deviceId,
                'notification' => array(
                    "body" => $message['message'],
                    "title" => "Grocery",
                    
                ),
                "data" => array(
                    "body" => $message['message'],
                    "title" => "Grocery",
                    "notify" => "notification",
                    'type' => $type,
                    'badge' => $unread,
                )
                    // 'data' => $jsonData,
            );
            
            $fields_json = json_encode($fields);
            
            $headers = array(
                'Authorization: key= AAAAN7pGzqM:APA91bGjSoksYAJHdxtvBaNqt2VCqKuNiBzJiYsMwvNVuyGAJ8Iuj1HNEClo_VkzgdGuTHWoHp7O9FYP7Et_l2eI_iNNEEePeao3Q5qlVNNMIsp93_60xvxAAPMvIspLzQ3nsFM6_9n7',
                'Content-Type: application/json'
            );
           
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_json);
            $result = curl_exec($ch);
            curl_close($ch);
            // print_r($result);exit;
            
        }
        // set Response for api /

    function sentResponse($array) {
        $arrayCount = count($array);

        if ($arrayCount == 2) {
            $setResponse = array(
                'success' => $array[0],
                'message' => $array[1],
            );
        } else {
            $setResponse = array(
                'success' => $array[0],
                'message' => $array[1],
                $array[3] => $array[2],
            );
        }

        return $setResponse;
    }
}

?>