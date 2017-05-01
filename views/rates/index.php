<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;


if(Yii::$app->session->getFlash('success_login')){
	?>
	<div class="alert alert-success">
	Вы успешно зашли
	</div>
	<?php
}




