<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
if(isset(Yii::$app->request->cookies["admin"])) {




    if(Yii::$app->session->getFlash("success_team")){
        echo "<div class='alert alert-success'>";
        echo Yii::$app->session->getFlash("success_team");
        echo "</div>";
    }


    ?>


    <?php
    $form = ActiveForm::begin([
        'id' => 'add-tourney',
        'options' => ['class' => 'form-horizontal col-md-4 col-md-offset-4'],
    ]) ?>
    <?php

    $list = ArrayHelper::map($list, 'id', 'name');

    echo $form->field($model, 'id_tourney')->dropDownList($list);

    echo $form->field($model, 'name');


    ?>

    <div class="form-group">
        <div>
            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>


    <?php ActiveForm::end() ?>


<?php



}
