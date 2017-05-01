<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

if(isset(Yii::$app->request->cookies["user"])) {


    if(Yii::$app->session->getFlash("success_tourney")){
        echo "<div class='alert alert-success'>";
        echo Yii::$app->session->getFlash("success_tourney");
        echo "</div>";
    }
	
	
	if(isset($message)){
	echo "<div class='alert alert-info'>";
	echo $message;
	echo "</div>";
	}


    ?>
<div>

    <?php
    $form = ActiveForm::begin([
        'id' => 'add-tourney',
        'options' => ['class' => 'form-horizontal col-md-4 col-md-offset-4'],
    ]) ?>
    <?php
	
	$list = ArrayHelper::map($list, 'name_match', 'name_match');


    echo $form->field($model, 'name_match')->dropDownList($list);




    ?>

    <div class="form-group">
        <div>
            <?= Html::submitButton('Отменить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>


    <?php ActiveForm::end() ?>
</div>

    <?php
	
	
}






