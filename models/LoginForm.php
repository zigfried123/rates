<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "Users".
 *
 * @property integer $id
 * @property string $fio
 * @property string $email
 * @property string $phone
 * @property string $date_create
 * @property string $password
 */
class LoginForm extends \yii\db\ActiveRecord
{


    public $password_repeat;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [


            [['username', 'password'], 'required', 'on' => 'login', 'message' => 'Заполните поле {attribute}'],
            [['password'], 'checkLogin', 'on' => 'login'],
            ['status', 'safe', 'on' => 'check'],
            [['username', 'password', 'password_repeat'], 'required', 'on' => 'register', 'message' => 'Заполните поле {attribute}'],
            [['date_create', 'status', 'verifyCode'], 'safe', 'on' => 'register'],
            [['username', 'password', 'password_repeat'], 'string', 'max' => 100, 'on' => 'register'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'on' => 'register', "message" => "Пароли должны совпадать"],
            [['username'], 'unique', 'on' => 'register'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'password_repeat' => 'Пароль еще раз',
        ];
    }


    public function checkStatus($username)
    {
        if ($user = $this->findOne(["username" => $username])) {
            if ($user->status == "admin") {
                return "admin";
            } else {
                return "user";
            }
        }
        return false;
    }

    public function checkLogin($attribute)
    {
        $user = $this->findOne(["username" => $this->username]);


        if ($user && Yii::$app->getSecurity()->validatePassword($this->password, $user->password)) {

            return true;

        }


        return $this->addError($attribute, 'Неправильный логин или пароль.');


    }


}
