<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "forecasts".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_match
 * @property integer $result1
 * @property integer $result2
 */
class Forecasts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forecasts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			
            [['id_user', 'name_match', 'result1', 'result2'], 'required'],
			[['id_user', 'name_match'], 'unique', 'targetAttribute' => ['id_user', 'name_match']],
            [['id_user','result1', 'result2'], 'integer'],
			['name_match','string'] 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'name_match' => 'Название матча',
            'result1' => 'Результат 1',
            'result2' => 'Результат 2',
        ];
    }
}
