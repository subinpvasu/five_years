<?php

/**
 * Description of CurlGetAndPostMethods
 *
 * @author bisjo
 */
class CurlGetAndPostMethods {
    
    
    
    public function curlGetMethod($formatedUrl) {
        $ch = curl_init($formatedUrl);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
    
    
}
