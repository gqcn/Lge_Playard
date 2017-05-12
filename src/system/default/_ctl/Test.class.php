<?php
namespace Lge;

if(!defined('LGE')){
    exit('Include Permission Denied!');
}

class Controller_Test extends BaseController
{
    public function index()
    {
        $header = <<<MM
HTTP/1.1 200 OK
Server: nginx
Date: Fri, 12 May 2017 03:28:45 GMT
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
Vary: Accept-Encoding
Set-Cookie: PHPSESSID=654prc6deora4r51te3ir6ejs3; path=/
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate
Pragma: no-cache
Set-Cookie: Lge_Cookie=deleted; expires=Thu, 01-Jan-1970 00:00:01 GMT; Max-Age=0; path=/; domain=.gdgyun.com
Set-Cookie: oscid=""; Domain=.oschina.net; Expires=Thu, 01-Jan-1970 00:00:10 GMT; Path=/; HttpOnly
Set-Cookie: oscid=SrshfhMpRxBVRDLtqzEhjuO8drPs5hQKeCtZJswU0jHgjkckkaPu5ymVWDi2Ud9e9SaFmwA9vyfylJgLXZc5gWuTleltQT90U%2BUQEV%2FbzHcQmsvdWjUVNPrjMGGmMVV3T3q5R4URKcmDy9QAZ3%2BUZuoobg%2F48xSW6wjL1FTgO0c%3D; Domain=.oschina.net; Expires=Sat, 12-May-2018 03:52:13 GMT; Path=/; HttpOnly
MM;

        $returnArray = array();
        $headerArray = explode("\n", $header);
        foreach ($headerArray as $v) {
            $tArray = explode(": ", trim($v));
            print_r($tArray);
            if (!empty($tArray[0])) {
                if (empty($tArray[1])) {
                    $returnArray[0] = $tArray[0];
                } else {
                    $key = strtolower($tArray[0]);
                    if (isset($returnArray[$key])) {
                        if (is_array($returnArray[$key])) {
                            $returnArray[$key][] = $tArray[1];
                        } else {
                            $returnArray[$key] = array(
                                $returnArray[$key],
                                $tArray[1]
                            );
                        }
                    } else {
                        $returnArray[$key] = $tArray[1];
                    }
                }
            }
        }
        print_r($headerArray);

    }

    private function _parseCookie($inputCookie)
    {
        $cookieArray = array();
        if (is_array($inputCookie)) {
            $cookies = $inputCookie;
        } else {
            $cookies = array($inputCookie);
        }
        if (!empty($cookies)) {
            foreach ($cookies as $cookie) {
                $array = explode(';', $cookie);
                if (!empty($array[0])) {
                    $string = $array[0];
                    $t = explode('=', trim($string));
                    $k = $t[0];
                    $v = isset($t[1]) ? $t[1] : '';
                    $cookieArray[$k] = $v;
                }
            }
        }
        return $cookieArray;
    }
}
