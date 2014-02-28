<?php

class FacebookController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','logout','gavelife'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Users;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Users']))
		{
			$model->attributes=$_POST['Users'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        echo '<h1>Welcome</h1>';
        $user_id = Yii::app()->facebook->getUser();
        echo '</br>';

        if($user_id) {

            // We have a user ID, so probably a logged in user.
            // If not, we'll get an exception, which we handle below.

            try {

                $user_profile = Yii::app()->facebook->api('/me','GET');
                //print_r($user_profile);

                $permissions = Yii::app()->facebook->api("/me/permissions");
                if(! array_key_exists('publish_stream', $permissions['data'][0]) ) {
                    header( "Location: " . Yii::app()->facebook->getLoginUrl(array("scope" => "publish_stream")) );
                }

                $ret_obj = Yii::app()->facebook->api('/me/feed', 'POST',
                    array(
                        'link' => 'http://mp3.zing.vn/bai-hat/Dong-Acoustic-Vu-Cat-Tuong-Vu-Cat-Tuong/IW9768I0.html',
                        'message' => 'Đông...'
                    ));
                echo '<pre>Post ID: ' . $ret_obj['id'] . '</pre>';

                // Give the user a logout link
                $logout_url = 'http://studiogame.vcmobile.vn/user/index.php/facebook/logout';
                echo '</br><a href="' . $logout_url . '">Đăng xuất Facebook.</a>';


            } catch(FacebookApiException $e) {
                // If the user is logged out, you can have a
                // user ID even though the access token is invalid.
                // In this case, we'll get an exception, so we'll
                // just ask the user to login again here.

                // No user, print a link for the user to login
                $login_url = Yii::app()->facebook->getLoginUrl(array(
                    'scope' => 'publish_stream'
                ));
                echo 'Hãy <a href="' . $login_url . '">Đăng nhập Facebook.</a>';

                $logout_url = 'http://studiogame.vcmobile.vn/user/index.php/facebook/logout';
                echo '</br><a href="' . $logout_url . '">Đăng xuất Facebook.</a>';

                error_log($e->getType());
                error_log($e->getMessage());
            }
        } else {

            // No user, print a link for the user to login
            $login_url = Yii::app()->facebook->getLoginUrl(array(
                'scope' => 'publish_stream'
            ));
            echo '</br>';
            echo 'Hãy <a href="' . $login_url . '">Đăng nhập Facebook.</a>';
            $logout_url = 'http://studiogame.vcmobile.vn/user/index.php/facebook/logout';
            echo '</br><a href="' . $logout_url . '">Đăng xuất Facebook.</a>';

        }
	}

    public function actionLogout(){
        $user_id = Yii::app()->facebook->getUser();
        if($user_id) {

            // We have a user ID, so probably a logged in user.
            // If not, we'll get an exception, which we handle below.

            try {

                // Give the user a logout link
                $params = 'http://studiogame.vcmobile.vn/user/index.php/facebook/index';
                Yii::app()->facebook->destroySession();
                header('Location: '.$params);
                exit;


            } catch(FacebookApiException $e) {
                // If the user is logged out, you can have a
                // user ID even though the access token is invalid.
                // In this case, we'll get an exception, so we'll
                // just ask the user to login again here.

                // No user, print a link for the user to login

                $params = 'http://studiogame.vcmobile.vn/user/index.php/facebook/index';
                Yii::app()->facebook->destroySession();
                header('Location: '.$params);
                exit;

                error_log($e->getType());
                error_log($e->getMessage());
            }
        } else {
            $params = 'http://studiogame.vcmobile.vn/user/index.php/facebook/index';
            Yii::app()->facebook->destroySession();
            header('Location: '.$params);
            exit;

        }
    }

    public function actionGaveLife(){

        $user_id = Yii::app()->facebook->getUser();

        if($user_id) {

            // We have a user ID, so probably a logged in user.
            // If not, we'll get an exception, which we handle below.

            try {

                // Get the current access token
                $access_token = Yii::app()->facebook->getAccessToken();

                // Get the publish_actions
                $permissions = Yii::app()->facebook->api("/me/permissions");
                if(! array_key_exists('publish_stream', $permissions['data'][0]) ) {
                    header( "Location: " . Yii::app()->facebook->getLoginUrl(array("scope" => "publish_actions")) );
                }

                //Action!
                Yii::app()->facebook->api(
                    'me/sohastudiosdk:gave',
                    'POST',
                    array(
                        'life' => "studiogame.vcmobile.vn/user/index.php/facebook/"
                    )
                );
                // handle the response

                // Give the user a logout link
                $logout_url = 'http://studiogame.vcmobile.vn/user/index.php/facebook/logout';
                echo '</br><a href="' . $logout_url . '">Đăng xuất Facebook.</a>';


            } catch(FacebookApiException $e) {
                // If the user is logged out, you can have a
                // user ID even though the access token is invalid.
                // In this case, we'll get an exception, so we'll
                // just ask the user to login again here.

                // No user, print a link for the user to login
                $login_url = Yii::app()->facebook->getLoginUrl(array(
                    'scope' => 'publish_stream'
                ));
                echo 'Hãy <a href="' . $login_url . '">Đăng nhập Facebook.</a>';

                $logout_url = 'http://studiogame.vcmobile.vn/user/index.php/facebook/logout';
                echo '</br><a href="' . $logout_url . '">Đăng xuất Facebook.</a>';

                error_log($e->getType());
                error_log($e->getMessage());
            }
        } else {

            // No user, print a link for the user to login
            $login_url = Yii::app()->facebook->getLoginUrl(array(
                'scope' => 'publish_stream'
            ));
            echo '</br>';
            echo 'Hãy <a href="' . $login_url . '">Đăng nhập Facebook.</a>';
            $logout_url = 'http://studiogame.vcmobile.vn/user/index.php/facebook/logout';
            echo '</br><a href="' . $logout_url . '">Đăng xuất Facebook.</a>';

        }
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
