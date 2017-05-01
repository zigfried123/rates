<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\Tourneys;
use app\models\Teams;
use app\models\Matches;
use app\models\Forecasts;
use app\models\Users;



class RatesController extends Controller
{
	
	public $layout = "rates";
	
	

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAdmin()
    {
        return $this->render("admin");
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {

        $model = new LoginForm();

        $model->setScenario("login");

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            unset(Yii::$app->response->cookies["user"]);
            unset(Yii::$app->response->cookies["admin"]);

            if ($model->checkStatus($model->username) == "user") {
                Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'user',
                    'value' => $model->username
                ]));
            } else {
                Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'admin',
                    'value' => $model->username
                ]));
            }
			Yii::$app->session->setFlash('success_login', 'Вход успешно выполнен!');
			
            return $this->redirect(["rates/"]);
        }

        return $this->render("Login", ["model" => $model]);
    }

    public function actionRegistration()
    {
        $model = new LoginForm();

        $model->setScenario("register");


        if ($model->load(Yii::$app->request->post())) {


            $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);

            $model->password_repeat = $model->password;

            $model->save();


            Yii::$app->session->setFlash('success_register', 'Регистрация выполнена успешно! Для активации аккаунта необходимо перейти по ссылке в электронном письме.');
            $this->redirect(["rates/"]);


        }

        return $this->render("Registration", ["model" => $model]);


    }

    public function actionAddTourney()
    {
        if (isset(Yii::$app->request->cookies["admin"])) {
            $model = new Tourneys();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('success_tourney', 'Турнир успешно создан!', false);
                $this->refresh();
            }
            return $this->render("add-tourney", ["model" => $model]);
        }
        return "Вы не имеете право добавлять турниры";
    }

    public function actionAddTeam(){
        if (isset(Yii::$app->request->cookies["admin"])) {

            $list_tourneys = Tourneys::getList();

            $model = new Teams();
            if ($model->load(Yii::$app->request->post())) {
				if($model->save()){
                Yii::$app->session->setFlash('success_team', 'Команда успешно добавлена!');
                $this->refresh();
				}else{
					var_dump($model->errors);
				}
            }
            return $this->render("add-team", ["model" => $model, "list"=>$list_tourneys]);



        }
        return "Вы не имеете право добавлять команды";
    }


    public function actionAddMatch()
    {
		
		
		
		
		if(Yii::$app->request->isAjax){
			
			$data = Yii::$app->request->get();
			
			$list = Teams::findAll(["id_tourney"=>$data["id_tourney"]]);
			
            Yii::$app->response->format = 'json';
            return ['list' => $list];
		}
		
		
		
		
		
		
        if (isset(Yii::$app->request->cookies["admin"])) {
            $model = new Matches();
            $model->setScenario("match");


            if ($model->load(Yii::$app->request->post())) {
				
				$model->date_start = $model->date_start." ".$model->time_start;
				$model->date_start = strtotime($model->date_start);
				$model->date_end = $model->date_start + 5400;
				
                if($model->save()) {
                    Yii::$app->session->setFlash('success_match', 'Матч успешно создан!', false);
                    $this->refresh();

                }else{
					$model->errors;
				}
				
		
            }
		
		
			$list = Teams::findAll(["id_tourney"=>1]);
		
			$list_tourneys = Tourneys::getList();
            return $this->render("add-match", ["model" => $model, "list"=>$list, "list_tourneys"=>$list_tourneys]);

        }
        return "Вы не имеете право добавлять матчи";
    }


    public function actionAddResult()
    {
        if (isset(Yii::$app->request->cookies["admin"])) {
            $model = new Matches();
            $model->setScenario("result");
            if ($model->load(Yii::$app->request->post())) {
                $match = $model->find()->where(["name"=>$model->name])->one();
				
				if(time() >= $match->date_end){
				
					$match->result1 = $model->result1;
					$match->result2 = $model->result2;
					
					$forecast = Forecasts::find()->where(["name_match"=>$match->name])->all();
					
					foreach($forecast as $key=>$val){
					
						$user = Users::find()->where(["id"=>$val->id_user])->one();
						
						$user->status = "user";
						
						if($val->result1 == $match->result1 && $val->result2 == $match->result2){
							$user->score = 4;
						}else if($val->result1 - $val->result2 == $match->result1 - $match->result2 || $val->result2 - $val->result1 == $match->result1 - $match->result2){
							$user->score = 3;
						}else if($val->result1 - $val->result2 == $match->result2 - $match->result1 || $val->result2 - $val->result1 == $match->result2 - $match->result1){
							$user->score = 3;
						}else if($val->result1 > $val->result2 && $match->result1 > $match->result2){
							$user->score = 2;
						}else if($val->result1 < $val->result2 && $match->result1 < $match->result2){
							$user->score = 2;
						}else if($val->result1 == $val->result2 && $match->result1 == $match->result2){
							$user->score = 2;
						}else if($val->result1 == $match->result1 || $val->result2 == $match->result2){
							$user->score = 1;
						}else{
							$user->score = 0;
						}
						
						$user->update();
					
					}
					
				
					if($match->update()) {
						
						Yii::$app->session->setFlash('success_result', 'Результат успешно записан!', false);
						$this->refresh();
					}else{
						$model->errors();
					}
					
					
				
				}else{
					
					$message = "Матч еще не закончился";
					
					return $this->render("add-result", ["model" => $model, "list"=>$model->list, "message"=>$message]);
				
				}
                
            }
			
			
			
            return $this->render("add-result", ["model" => $model, "list"=>$model->list]);
        }
        return "Вы не имеете право добавлять турниры";
    }
	
	
	
	
	
	 public function actionMakeForecast()
    {
		$model = new Forecasts();
		
		$list = Matches::getList();
		
		
		if ($model->load(Yii::$app->request->post())) {
			
			if(isset(Yii::$app->request->cookies["user"])){
				$user = Users::findOne(["username"=>Yii::$app->request->cookies["user"]]);
			}
			
			$model->id_user = $user->id;
			
			$match = Matches::findOne(["name" => $model->name_match]);
			
			if($match->date_start > time()){
			
				if($model->save()){
					$this->refresh();
				}else{
					var_dump($model->errors);
				}
			
			}else{
				$message = "Матч уже начался";
				return $this->render("make-forecast", ["model" => $model, "list" => $list, "message"=>$message]);
			}
			
			
		}
		
		
		return $this->render("make-forecast", ["model" => $model, "list" => $list]);
	}
	
	
	 public function actionCancelForecast()
    {
		
		
		$model = new Forecasts();
		
		$user = Users::find()->where(["username"=>Yii::$app->request->cookies["user"]])->one();
		
		$list = $model->find()->where(["id_user"=>$user->id])->orderBy("name_match")->all();
		
		
		if ($model->load(Yii::$app->request->post())) {
			
			$forecast = $model->find()->where(["name_match"=>$model->name_match])->one();
			
			$match = Matches::findOne(["name" => $model->name_match]);

			if($match->date_start > time()){
				if($forecast->delete()){
					$this->refresh();
				}
			}else{
				$message = "Матч уже начался";
				return $this->render("cancel-forecast", ["model" => $model, "list" => $list, "message"=>$message]);
			}
		}
		
		
		
		return $this->render("cancel-forecast", ["model" => $model, "list" => $list]);
		
	}
	
	
	
	 public function actionRating(){
		 
		 return $this->render("rating");
		 
	 }
	
	


}