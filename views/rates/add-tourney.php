<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
if(isset(Yii::$app->request->cookies["admin"])) {


    if(Yii::$app->session->getFlash("success_tourney")){
        echo "<div class='alert alert-success'>";
        echo Yii::$app->session->getFlash("success_tourney");
        echo "</div>";
    }


    ?>


    <?php
    $form = ActiveForm::begin([
        'id' => 'add-tourney',
        'options' => ['class' => 'form-horizontal col-md-4 col-md-offset-4'],
    ]) ?>
    <?php


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
