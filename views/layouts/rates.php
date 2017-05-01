<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Users;
use app\models\Forecasts;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>




<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => ["/rates"],
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [

			isset(Yii::$app->request->cookies["user"]) ? (
            ['label' => 'Сделать прогноз', 'url' => ['/rates/make-forecast']]
			
			) : (
			['label' => 'Создать турнир', 'url' => ['/rates/add-tourney']]
			),
			isset(Yii::$app->request->cookies["user"]) ? (
            ['label' => 'Отменить прогноз', 'url' => ['/rates/cancel-forecast']]
			) : (
			 ['label' => 'Добавить команду', 'url' => ['/rates/add-team']]
			),
			isset(Yii::$app->request->cookies["admin"]) ? (
            ['label' => 'Создать матч', 'url' => ['/rates/add-match']]
			) : (
			 ['label' => false]
			),
			isset(Yii::$app->request->cookies["admin"]) ? (
            ['label' => 'Добавить счет', 'url' => ['/rates/add-result']]
			) : (
			 ['label' => false]
			),
            Yii::$app->user->isGuest ? (
                ['label' => 'Войти', 'url' => ['/rates/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>
	
	
	<style>
	td{
		width:100px;
	}
	
	</style>
	

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
		<?php $users = Users::find()->all(); ?>
	
		<div style="position:absolute;right:0px">
		<table class="table-striped table-bordered">
		<th>user</th><th>rates</th><th>score</th>
		<?php
		foreach($users as $val){
			$val->rates = Forecasts::find()->where(["id_user"=>$val->id])->count();
			?>
			<tr>
			<td><?=$val->username;?></td><td><?=$val->rates;?></td><td><?=$val->score;?></td>
			</tr>
			<?php
		}
	
		?>
		
		</table>
		</div>
		
    </div>
	
	
	
	
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>




