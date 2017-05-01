<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "teams".
 *
 * @property integer $id
 * @property integer $id_tourney
 * @property string $name
 */
class Teams extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'teams';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tourney', 'name'], 'required'],
            [['id_tourney'], 'integer'],
            [['name'], 'string', 'max' => 30],
			['name', 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tourney' => 'Турнир',
            'name' => 'Команда',
        ];
    }
	
	public static function getList(){
		return self::find()->all();
	}
}
