<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;


?>


    <?php
    $form = ActiveForm::begin([
        'id' => 'login',
        'options' => ['class' => 'form-horizontal col-md-4 col-md-offset-4'],
    ]) ?>
	<h2 class="text-center">Авторизация</h2>
    <?php

    echo $form->field($model, 'username');
    echo $form->field($model, 'password');


    ?>

    <div class="form-group">
        <div>
            <?= Html::submitButton('Выбрать', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
	
	<div class="text-center">
    Вы еще не зарегистрированы?
    <br>
    <?= Html::a('Регистрация',['/rates/registration']);?>
	</div>


    <?php ActiveForm::end() ?>


