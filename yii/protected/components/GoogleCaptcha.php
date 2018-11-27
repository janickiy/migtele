<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 08.02.2017
 * Time: 17:41
 */
class GoogleCaptcha
{
    const API_URL = 'https://www.google.com/recaptcha/api/siteverify';
    /**
     * @var string
     */
    protected $secret;

    /**
     * GoogleCaptcha constructor.
     * @param $secret string
     */
    public function __construct($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @param $response string
     * @return GoogleCaptchaResponseObject
     * @throws Exception
     */
    public function check($response)
    {
        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query(
                    array(
                        'secret' => $this->secret,
                        'response' => $response,
                    )
                )
            )
        );
        $context  = stream_context_create($opts);

        $result = @file_get_contents(self::API_URL, false, $context);
        $this->guardIsNotFalse($result,'Can not connect to API');
        return $this->createResponseObject($result);

    }

    protected function guardIsNotFalse($parameter, $message){
        if(!$parameter)
            throw new Exception($message);
    }

    protected function createResponseObject($result){
        $object = json_decode($result);
        return $response = new GoogleCaptchaResponseObject($object->success, $object->challenge_ts, $object->hostname);
    }
}

class GoogleCaptchaResponseObject{

    /**
     * @var bool
     */
    protected $success;

    /**
     * @var string
     */
    protected $challengeTs;

    /**
     * @var string
     */
    protected $hostName;

    /**
     * @var array
     */
    protected $errorCodes = array();

    public function __construct($success, $challengeTs, $hostName, $errorCodes = array())
    {
        $this->success = $success;
        $this->challengeTs = $challengeTs;
        $this->hostName = $hostName;
        $this->errorCodes = $errorCodes;
    }

    /**
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getChallengeTs()
    {
        return $this->challengeTs;
    }

    /**
     * @return string
     */
    public function getHostName()
    {
        return $this->hostName;
    }

    /**
     * @return array
     */
    public function getErrorCodes()
    {
        return $this->errorCodes;
    }



}