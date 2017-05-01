<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "matches".
 *
 * @property integer $id
 * @property string $name
 * @property string $team1
 * @property string $team2
 * @property integer $result1
 * @property integer $result2
 * @property string $date
 */
class Matches extends \yii\db\ActiveRecord
{
	
	
	public $id_tourney;
	public $time_start;
	
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'matches';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		
			['team1', 'compare', 'compareAttribute' => 'team2', 'operator'=>'!='],

            [['name', 'team1', 'team2', 'date_start', "time_start"], 'required', 'on'=>'match'],
			
			['name', 'unique'],
			
			['time_start','date', 'format'=>'HH:mm:ss', "message"=>"Введите время в формате часы:минуты:секунды"],
			
			[['date_end', 'count'], 'safe'],
			
			['date_end', 'checkDate'],

            [['name', 'result1', 'result2'], 'required', 'on'=>'result'],
            [['result1', 'result2'], 'integer'],
            [['name', 'team1', 'team2'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Матч',
            'team1' => 'Команда 1',
            'team2' => 'Команда 2',
            'result1' => 'Счет 1',
            'result2' => 'Счет 2',
            'date_start' => 'Дата начала',
			'time_start' => 'Время начала',
			'id_tourney' => 'Турнир',
        ];
    }
	
	public static function getList(){
		return self::find()->all();
	}
	
	public function checkDate($attribute,$params)
    {
		if(time() < strtotime($this->date_end)){
			return $this->addError("123");
		}
	}
}
