<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = "Регистрация нового пользователя";
?>


<?php
$form = ActiveForm::begin([
    'id' => 'registration',
    'options' => ['class' => 'form-horizontal col-md-4 col-md-offset-4'],
]) ?>
<h2 class="text-center"><?= $this->title ?></h2>
<?php


echo $form->field($model, 'username');
echo $form->field($model, 'password');
echo $form->field($model, 'password_repeat');


?>

<div class="form-group">
    <div>
        <?= Html::submitButton('Выбрать', ['class' => 'btn btn-primary']) ?>
    </div>
</div>


<?php ActiveForm::end() ?>
