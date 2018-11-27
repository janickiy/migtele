<?php

/**
 * Created by PhpStorm.
 * User: m.semyonov
 * Date: 08.02.2017
 * Time: 18:00
 */
class Helpers
{
    public static function checkGoogleCaptcha($response)
    {
        $secret = '6Ld2zhQUAAAAABfKGDV5Z97-uoRKikJerJmWZ5oC';
        $captcha = new GoogleCaptcha($secret);
        $response = $captcha->check($response);
        return $response->isSuccess();
    }

    public static function render($view, array $params = array()){

    }

    private static function rus2translit($string)
    {
        $converter = array(
            '�' => 'a', '�' => 'b', '�' => 'v',
            '�' => 'g', '�' => 'd', '�' => 'e',
            '�' => 'e', '�' => 'zh', '�' => 'z',
            '�' => 'i', '�' => 'y', '�' => 'k',
            '�' => 'l', '�' => 'm', '�' => 'n',
            '�' => 'o', '�' => 'p', '�' => 'r',
            '�' => 's', '�' => 't', '�' => 'u',
            '�' => 'f', '�' => 'h', '�' => 'c',
            '�' => 'ch', '�' => 'sh', '�' => 'sch',
            '�' => '\'', '�' => 'y', '�' => '\'',
            '�' => 'e', '�' => 'yu', '�' => 'ya',
            '�' => 'A', '�' => 'B', '�' => 'V',
            '�' => 'G', '�' => 'D', '�' => 'E',
            '�' => 'E', '�' => 'Zh', '�' => 'Z',
            '�' => 'I', '�' => 'Y', '�' => 'K',
            '�' => 'L', '�' => 'M', '�' => 'N',
            '�' => 'O', '�' => 'P', '�' => 'R',
            '�' => 'S', '�' => 'T', '�' => 'U',
            '�' => 'F', '�' => 'H', '�' => 'C',
            '�' => 'Ch', '�' => 'Sh', '�' => 'Sch',
            '�' => '\'', '�' => 'Y', '�' => '\'',
            '�' => 'E', '�' => 'Yu', '�' => 'Ya',
        );
        return strtr($string, $converter);
    }

    static function str2url($str)
    {
        $str = self::rus2translit($str);
        // � ������ �������
        $str = strtolower($str);
        // ������� ��� �������� ��� �� "-"
        $str = preg_replace('~[^-a-z0-9_ ]+~u', '', $str);
        $str = str_replace(' ', '-', $str);
        // ������� ��������� � �������� '-'
        $str = trim($str, "-");
        return $str;
    }
}