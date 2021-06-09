<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductorasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Productoras';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="fondo p-2">
    <div class="col-12">
        <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>
        <div class="my-3 text-right">
            <?= Html::a('Crear', ['create'], ['class' => 'btn btn-principal']) ?>
            <?php echo $this->render('_search', ['model' => $searchModel]) ?>
        </div>

        <?php if (!Yii::$app->user->isGuest) : ?>
        <?php endif ?>
        <div id="listas">


            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{summary}\n{items}\n<div class='d-flex justify-content-center'>{pager}</div>",
                'columns' => [
                    'nombre',
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>

        </div>

    </div>
</div>
