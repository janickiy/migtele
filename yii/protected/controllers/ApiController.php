<?php

class ApiController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionUpdateOrder(){
		$landing = Landings::model()->findByAttributes(array(
			'login'=>$_GET['login']
		));	
		$hash = $_GET['hash'];		
		// print_r($_GET);
		$hashArray[] = $_GET['login'];
		$hashArray[] = $landing->password;
		$hashArray[] = $_GET['orderId'];
		$hashArray[] = $_GET['name'];
		$hashArray[] = $_GET['email'];
		$hashArray[] = $_GET['phone'];
		$hashArray[] = $_GET['address'];
		$hashArray[] = $_GET['workinfo'];
		$hashArray[] = $_GET['amount'];
		$hashArray[] = $_GET['timestamp'];		
		$ourHash = md5(implode(';',$hashArray));		
		if($ourHash != $hash){
			$data['result'] = 0;
			$data['error'] = 'Неправильный логин или пароль';
			echo json_encode($data);
			exit();			
		}
		$_GET['orderId'] = (int) $_GET['orderId'];
		$search = "|Заказ №{$_GET['orderId']}|";	
		$sql = "SELECT * FROM orders WHERE `workinfo` LIKE '%{$search}%'";
		$order = Orders::model()->findBySql($sql);		
		if($order===NULL){
			$order = new Orders;
			$order->goodId = 0;
			$order->landingId = 2;						
		}
		// var_dump($order);exit();		
		$order->name = $_GET['name'];
		$order->phone = $_GET['phone'];
		$order->email = $_GET['email'];
		$order->address = $_GET['address'];		
		$order->price = $_GET['amount'];
		$order->workInfo = $_GET['workinfo'];
		var_dump($order->save());
		// print_r($order->getErrors());		
	}
	public function actionIndex()
	{		
		$login = $_GET['login'];
		$landing = Landings::model()->findByAttributes(array(
			'login'=>$login
		));
		$timestamp = $_GET['timestamp'];
		$hash = $_GET['hash'];
		$ourHash = md5($_GET['action'].';'.$login.';'.$landing->password.';'.$_GET['version'].';'.$timestamp);
		if($landing===NULL || $ourHash != $hash){
			$data['result'] = 0;
			$data['error'] = 'Неправильный логин или пароль';
			echo json_encode($data);
			exit();			
		}	
		switch($_GET['action']){
			case 'getUpdate':				
				if($landing->version<=$_GET['version']){
					$data['result'] = 0;
					$data['error'] = 'Нет новых версий';					
				}else{
					$data['result'] = 1;
					$data['path'] = $landing->updatePath;
					$log = date('d.m.Y H:i:s')." обновление успешно, IP адрес: {$_SERVER['REMOTE_ADDR']}, версия софта: {$landing->version} \n";
					$landing->log .= $log;
					$landing->save(false);
				}
				echo json_encode($data);
				//var_dump($landing);
				break;
			case 'addOrder':
				$order = new Orders;
				$order->name = urldecode($_GET['name']);
				$order->phone = urldecode($_GET['phone']);
				$order->email = urldecode($_GET['email']);
				$order->address = urldecode($_GET['address']);
				// print_r($_GET);
				$order->goodId = $_GET['good'];
				$good = Goods::model()->findByPk($_GET['good']);
				// print_r($good);
				$order->price = $good->price;
				$order->landingId = $landing->id;
				if($good!==NULL && $order->save()){
					$data['result'] = 1;
				}else{
					$data['result'] = 0;
					$data['error'] = 'Данные не прошли валидацию';
				}
				echo json_encode($data);
				// print_r($_GET);
				break;
		}
	}
	public function actionAddOrder(){
		// $result = array();
		$model = new Orders;
		$model->landingId = urldecode($_GET['landingId']);
		$model->name = urldecode($_GET['name']);
		$model->phone = urldecode($_GET['phone']);
		$model->email = urldecode($_GET['email']);
		$model->address = urldecode($_GET['address']);
		if(count($_GET['contains']) && $model->save()){
			// print_r($_GET['contains']);
			foreach((array)$_GET['contains'] as $order){
				$contain = new Ordercontains;
				$contain->goodId = $order['good'];
				$contain->colorId = $order['color'];
				$contain->sizeId = $order['size'];
				$contain->count = $order['count'];
				$contain->orderId = $model->id;
				$good = Goodsprices::model()->findByAttributes(array(
					'goodId'=>$contain->goodId,
					'sizeId'=>$contain->sizeId,
					'colorId'=>$contain->colorId,
				));
				// var_dump($good);
				$contain->price = $good->price;
				if(!$contain->save()){
					// print_r($contain->getErrors());
					$model->delete();
					// echo 'delete';
					break;
				}
			}
		}
		// print_r($model);
		// echo $model->id;
		// print_r($model->getErrors());
		echo ($model->id)?1:0;
		// if($model->)
	}
	//Так как все сайты не стандартные - для каждого сайта пишем отдельный action для обновления	
	public function actionPiggy(){
		$data = array();
		$landing = Landings::model()->findByAttributes(array(
			'login'=>$_GET['login']
		));
		$array = array(
			'login'=>$_GET['login'],
			'password'=>$landing->password,
			'version'=>$_GET['version'],
			'timestamp'=>$_GET['timestamp'],
			'action'=>$_GET['action'],
		);
		ksort($array);
		$hash = md5(implode(';',$array));
		if($landing===NULL || $hash != $_GET['hash']){
			$data['result'] = 0;
			$data['error'] = 'Неправильный логин или пароль';
			echo serialize($data);
			exit();			
		}
		if($landing->version<=$_GET['version']){
			$data['result'] = 0;
			$data['error'] = 'Нет новых версий';
		}else{
			$data['result'] = 1;
			$data['path'] = $landing->updatePath;
			$log = date('d.m.Y H:i:s')." обновление успешно, IP адрес: {$_SERVER['REMOTE_ADDR']}, версия софта: {$landing->version} \n";
			$landing->log .= $log;
			$landing->save(false);
		}
		echo serialize($data);
	}
}
