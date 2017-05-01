<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;


use yii\console\Controller;
use app\models\Users;
use app\models\Forecasts;
use app\models\Matches;


class CounterController extends Controller
{

    public function actionIndex()
    {

		$name_matches = Forecasts::find()->select(['name_match','count(*)'])->groupBy(["name_match"])->asArray()->all();
		
		
		foreach($name_matches as $val){
			$m = Matches::find()->where(['name'=>$val["name_match"]])->one();
			if(isset($m)){
				
				$m->count = $val["count(*)"];
					
				$m->update();
			}
		}
	
    }
				
}
