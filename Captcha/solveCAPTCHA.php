<?php
/**
 * mcCS - solveCAPTCHA
 *
 * @author Masud Rana
 * @version 0.01
 */

namespace mcCS\captcha;

require_once __DIR__.'/../mcHC/ParseInterface.php';
require_once __DIR__.'/../mcHC/HeaderTrait.php';
require_once __DIR__.'/../mcHC/Client.php';
require_once __DIR__.'/../mcHC/Connection.php';
require_once __DIR__.'/../mcHC/Response.php';
require_once __DIR__.'/../mcHC/Request.php';
require_once __DIR__.'/../mcHC/Processor.php';
require_once __DIR__.'/../mcHC/UserAgent.php';
require_once __DIR__.'/../Constants/Constants.php';

use mcHC\http\Client;
use mcHC\http\Request;
use mcHC\http\Response;
use mcHC\http\Connection;
use mcHC\http\userAgent;
use mcHC\Constants\Constants;

class solveCAPTCHA
{
    public $url;
    public $key;
    
    public function __construct($url = '', $key = '')
    {
        if($url != null && $key != null)
        {
            $this->url = $url;
            $this->key = $key;
            $this->ua = $this->randUserAgent();
        } else {
            die("{'Error': 'Captcha Page or Key is Missing.'}");
        }
    }
    
    public function getRecaptchaToken()
    {
        $http = new Client();
        $http->setHeader('user-agent', $this->ua);
        $http->setHeader('Pragma', 'no-cache');
        $http->setHeader('Accept', '*/*');
        //Connection::useProxy(Constants::HTTP_PROXY);
        $result = $http->get($this->url);
        
        return trim(strip_tags($this->getSTR($result,'<input type="hidden" id="recaptcha-token" value="', '"')));
    }
    
    public function getToken()
    {
        $postFields = [
            'v'      => 'VZKEDW9wslPbEc9RmzMqaOAP',
            'reason' => 'q',
            'c'      => $this->getRecaptchaToken(),
            'k'      => '5mNs27FP3uLBP3KBPib88r1gยน03AGdBq24O5pcm_54kCY-TY7cMQJeNKAnAv1h8OJ_oSOzl_K-AhDPXFEQvuxEYY0tBUnErQAZ6OVUQIDqPWu8EyPh4ziTK7A1R1PLHGv2yJqdpnPVVlby5xxW08WrAJEYxW42-jI7bwAZl3CO4WqqGcqSwtCRHksyIKizHP13_AG1kI9Kg9uB0XRyjqadNnaO-qFPLx3dtouCYb7RtRlyl_wcLEz7o3eG69oUG5l3JYOxVSxl5XsjkjHnV78iYe_uAHZbGg0abDw97dHBJVUgP7EQcgavf7UrW2UGnKbF8ZhWgZQLP2VHs7BUEsV8j06tX66QA289fKbeQt862aM3H9q-vnrV_Rt64qe78bDm8eNp0z6HiqAOI3Vkq7jBZV5fS_3fofBSYe07GVBJcReWme3p95Yu8IEmttPnEtg8_Z6coPvz0ya4eH715A2xYR_cilUGZbn58VcM9KPxMmIu-Y3NJxfxwldoung7isHOQSFUD6sQJAi7E8HO2I5gwyELQcumioe7bsQ1Vxsv5lUf3lxyFrM9Iiw_SgKhGMdSWkHk0wYGtbF2agmYumE4r4_XhSHWiF1vVKvJVm15ic1Jz-yKIUHS1HcoC2j2eELxPigFHSyY2mapcwG6ZiPweNIV-gxOvn2xFF-PsHu0D4TC-4E5L62JW-ERh1FLoJ5Xs7GuzfgplyzXv1PaOzd0lr5S3NqkC7AYcYYAXSIYDcweI0WgDxJvWoVfunK80-GUQbjqb2wIZltyo7GHAG1lPOT1iQeojfiHpGRt28vfktAA6QGJ1dB44jwsDqHptR0c2-QpbTZKFll77PrsaBrzF7iNe0jloZbXRJjxXpNX7ErI9gAHvLLruDBjvXs9Jciod8xWcbJPVanCXurw3ss7v5lDKDNUnAeEdPaQMkn_x47XDK6uzbWvYeIUO1oKswyrI5XbOEUD6toXKqykRfnI2tKr2Ych2zBNs1vxbHu5nItRQF1elT6cBDjSJOnYKVGo7eOTPFmiEX0c4036DmFleYlWy5XJSHnSFyk5Gfi9RGwCBWKA4bmcXrWLsIRPz9BVBO7UhY_YejZ5l1Ok[42,1,28]'
        ];
        
        $http = new Client();
        $http->setHeader('user-agent', $this->ua);
        $http->setHeader('accept', '*/*');
        $http->setHeader('content-type', 'application/x-protobuffer');
        $http->setHeader('sec-fetch-site', 'same-origin');
        $http->setHeader('sec-fetch-mode', 'cors');
        $http->setHeader('sec-fetch-dest', 'empty');
        $http->setHeader('referer', $this->url);
        $http->setHeader('accept-encoding', '');
        $http->setHeader('accept-language', 'en-US,en;q=0.9');
        //Connection::useProxy(Constants::HTTP_PROXY);
        $result = $http->post(Constants::CAPTCHA_ENTERPRISE_RELOAD_URL.$this->key, $postFields);
        
        return trim(strip_tags($this->getSTR($result,'["rresp","', '"')));
    }

    public function getSTR($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        
        return substr($string, $ini, $len);
    }
    
    public function randUserAgent()
	{
	    $agent = new userAgent();
        $rua = array('windows','mac','mobile');
        $ua = $agent->generate($rua[array_rand($rua)]);
        return $ua;
	}
}
?>
