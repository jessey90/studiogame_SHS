<?php

class ApiController extends Controller
{

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

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
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view','create','login','logout','playbydevice','facebook'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('update'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
     * Tạo mới tài khoản qua API
	 */
    public function actionCreate()
    {
        $model=new Users;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $private_key = 'b0afba546260ff7bc5f796bb75eee822';

        if(isset($_POST['Users']) && $_POST['Users']['secure'])
        {
            //Check key

            $email = $_POST['Users']['email'];
            $require_id = $_POST['Users']['reqid'];
            $secure = $_POST['Users']['secure'];

            //Check biến call back
            if(isset($_POST['Users']['callback']))
            {
                $callback_url = $_POST['Users']['callback'];
            }else{
                $callback_url = array('view','id'=>$model->user_id);
            }

            $check_secure = md5(md5($require_id.$private_key));

            if($check_secure == $secure)
            {
                if(isset($_POST['Users']['device_id']))
                {
                    $device_id = $_POST['Users']['device_id'];
                    $criteria = new CDbCriteria;
                    $criteria->addCondition("`device_id`  = '".$device_id."'");
                    $user = Users::model()->find($criteria);
                    $model=$this->loadModel($user['user_id']);
                        $model->attributes=$_POST['Users'];
                        if($model->save())
                        {
                            $string='{"success":"Đã update email thành công"}';
                            $json=json_decode($string,true);
                            print_r($json);
                        }else{
                            $string='{"error_001":"Email đã tồn tại"}';
                            $json=json_decode($string,true);
                            print_r($json);
                        }
                }else{
                    $model->attributes=$_POST['Users'];
                    if($model->save()){
                        $string='{"success":"Đã tạo user thành công"}';
                        $json=json_decode($string,true);
                        print_r($json);
                    }else{
                        $string='{"error_001":"Email đã tồn tại"}';
                        $json=json_decode($string,true);
                        print_r($json);
                    }
                }
            }
        }
    }

    /**
     * Tạo mới tài khoản qua API mà không cần email.
	 */
    public function actionPlayByDevice()
    {
        $model=new Users;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $private_key = 'b0afba546260ff7bc5f796bb75eee822';

        if(isset($_POST['Users']) && $_POST['Users']['secure'])
        {
            //Check key
            $require_id = $_POST['Users']['reqid'];
            $secure = $_POST['Users']['secure'];

            $check_secure = md5(md5($require_id.$private_key));

            if($check_secure == $secure)
            {


                $model->attributes=$_POST['Users'];
                if($model->save()){
                    $string='{"success":"Đã tạo user thành công"}';
                    $json=json_decode($string,true);
                    print_r($json);
                }else{
                    $string='{"error_002":"Device_id đã tồn tại"}';
                    $json=json_decode($string,true);
                    print_r($json);
                }
            }else{
                echo "sai mã bảo mật";
            }
        }
    }

    /**
     * Login Action
     */
    public function actionLogin()
    {
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $private_key = 'b0afba546260ff7bc5f796bb75eee822';

        if(isset($_POST['Users']) && $_POST['Users']['secure'])
        {
            //Check key
            $require_id = $_POST['Users']['reqid'];
            $secure = $_POST['Users']['secure'];
            $email = $_POST['Users']['email'];
            $game_id = $_POST['Users']['game_id'];

            $check_secure = md5(md5($require_id.$private_key));

            if($check_secure == $secure)
            {
                $criteria = new CDbCriteria;
                $criteria->addCondition("`email`  = '".$email."'");
                $user = Users::model()->find($criteria);
                $user_id = $user["user_id"];
                $token = md5($require_id.md5($private_key.md5($game_id.md5($user_id))));

                $criteria = new CDbCriteria;
                $criteria->addCondition("`session`  = '".$token."'");
                $token_check = Session::model()->find($criteria);
                if(!is_null($token_check))
                {
                    $json = '{"token":"'.$token_check["session"].'"}';
                    print_r(json_decode($json));
                }else{
                    $session = new Session;
                    $session->session = $token;
                    $session->user_game_id = $user_id;
                    $session->game_id = $game_id;
                    $session->save();

                    $json = '{"token":"'.$token.'"}';
                    print_r(json_decode($json));
                }
            }else{
                echo "sai mã bảo mật";
            }
        }
    }

    /**
     * Login Action
     */
    public function actionLogout()
    {
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $private_key = 'b0afba546260ff7bc5f796bb75eee822';


        if(isset($_POST['Users']) && $_POST['Users']['secure'])
        {
            //Check key
            $require_id = $_POST['Users']['reqid'];
            $secure = $_POST['Users']['secure'];
            $token = $_POST['Users']['token'];

            $check_secure = md5(md5($require_id.$private_key));

            if($check_secure == $secure)
            {
                $criteria = new CDbCriteria;
                $criteria->addCondition("`session`  = '".$token."'");
                $token_check = Session::model()->find($criteria);
                if(!is_null($token_check))
                {
                    $session = Session::model()->findByPk($token_check["session_id"]);
                    $session->delete();
                    echo "đã logout thành công";
                }else{
                    $json = '{"sai token":"'.$token.'"}';
                    print_r(json_decode($json));
                }
            }else{
                echo "sai mã bảo mật";
            }
        }
    }

    /*Dùng Facebook SDK*/
    public function actionFacebook(){

    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Users');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Users('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Users']))
			$model->attributes=$_GET['Users'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Users the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Users::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Users $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='users-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
