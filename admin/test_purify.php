<?php
    require_once 'htmlpurifier/HTMLPurifier.auto.php';
    
    $config = HTMLPurifier_Config::createDefault();
    $config->set('Core.Encoding', 'cp1251'); // replace with your encoding
    //$config->set('HTML', 'Doctype', 'HTML 4.01 Transitional'); // replace with your doctype
    $purifier = new HTMLPurifier($config);
    
    $clean_html = $purifier->purify("<table><tr><td>Тест</tr>");
	echo $clean_html;
?>