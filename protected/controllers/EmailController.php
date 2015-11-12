<?php
	class EmailController extends Controller	{

		public function filters() {
			return array(
				'accessControl', 
				'postOnly + delete', 
			);
		}

		public function accessRules() {
			return array(
				array('allow', 
					'actions'=>array(),
					'users'=>array('*'),
				),
				array('allow', 
					'actions'=>array('index'),
					'roles'=>array('Admin','Email manager'),
				),

				array('deny',  
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

////////////////////////////////////////////////////////////////////////////////////////////

		

		




/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

		


	}

?>