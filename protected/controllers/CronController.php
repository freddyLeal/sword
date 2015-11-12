<?php

class CronController extends Controller {

	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function accessRules() {
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(	'getPublicIp', 'SendEmail'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('logout'),
				'users'=>array('@'),//colocar el @ para usuarios logueados 
			),
			array('deny',  // deny 
				'users'=>array('*'),
			),
		);
	}

	public function actions() {
		return array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}



	///////////////////////////////////////////////////////////////////////////////	


	public function actionGetPublicIp(){
		$url = "http://www.une.com.co/miip/";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$htmltext = trim(curl_exec($ch));
		$index = strrpos($htmltext, '<span');
		$htmltext = substr($htmltext, $index, strlen($htmltext)  ); 		
		$index = strrpos($htmltext, '">');
		$htmltext = substr($htmltext, $index+2, strlen($htmltext) );
		$index = strrpos($htmltext, '</span>');
		$htmltext = substr($htmltext, 0, $index ); 
		$ip = Yii::app()->systemUtils->getSystemVariable('publicIp');
		if( $ip->sv_value_text != $htmltext){
			Yii::app()->systemUtils->setSystemVariable('publicIp', false, $htmltext);
			$users = User::model()->findAll(array('condition'=>"user_active = 1"));
			foreach ($users as $user){
				Yii::app()->emailUtils->addQueue(	Yii::app()->params['TEMPLATE_NOTIFICATION_EMAIL'],
													100,
													"The application's ip has changed",
													$user->user_email,
													$user->user_name,
													null,
													array('data'=>$htmltext),
													0 );
			}
		}
	}


	public function actionSendEmail() {
		$emailQueue = EmailQueue::model()->find("eq_sent <> 1 ORDER BY eq_priority DESC");
		if ($emailQueue != null){
			Yii::app()->emailUtils->sendSimpleEmail(	$emailQueue->eqEt->et_url, 
														array($emailQueue->eq_recipient_email => $emailQueue->eq_recipient_name), 
														$emailQueue->eq_sender_name,
														$emailQueue->eq_subject, 
														unserialize($emailQueue->eq_dynamic_data_json) );	
			$emailQueue->eq_sent = 1;
			$emailQueue->save();		
		}		
	}	






}
?>