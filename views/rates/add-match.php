<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\helpers\ArrayHelper;

if(isset(Yii::$app->request->cookies["admin"])) {


    if(Yii::$app->session->getFlash("success_tourney")){
        echo "<div class='alert alert-success'>";
        echo Yii::$app->session->getFlash("success_tourney");
        echo "</div>";
    }
	
	
	$list = ArrayHelper::map($list, 'name', 'name');
	
	$list_tourneys = ArrayHelper::map($list_tourneys, 'id', 'name');


    ?>
	
	


    <?php
    $form = ActiveForm::begin([
        'id' => 'add-tourney',
        'options' => ['class' => 'form-horizontal col-md-4 col-md-offset-4'],
    ]) ?>
    <?php

	echo $form->field($model, 'id_tourney')->textInput(['id' => 'add_tourney'])->dropDownList($list_tourneys);

    echo $form->field($model, 'name');

    echo $form->field($model, 'team1')->dropDownList($list);

    echo $form->field($model, 'team2')->dropDownList($list);

    echo $form->field($model, 'date_start')->widget(\yii\jui\DatePicker::classname(), [
    //'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',

]);

	echo $form->field($model, 'time_start');


    ?>

    <div class="form-group">
        <div>
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>


    <?php ActiveForm::end() ?>


    <?php



}else{
	echo "<div class='alert alert-info'>";
	echo "Вы не имеете право добавлять матчи";
	echo "</div>";
}

