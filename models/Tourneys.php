<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tourneys".
 *
 * @property integer $id
 * @property string $name
 */
class Tourneys extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tourneys';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
            'name' => 'Турнир',
        ];
    }

    public static function getList(){
        return self::find()->all();
    }
}
