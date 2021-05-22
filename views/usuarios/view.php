<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->login;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fondo p-2">
    <div class="col-12">

        <h1 class="text-center text-md-left h1"><?= Html::encode($this->title) ?></h1>

        <p class="text-right my-3">
            <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-principal']) ?>
            <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-eliminar',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'login',
                'nombre',
                'anyo_nac',
                'email:email',
                'rol.rol',
                'genero',
                'pais',
                'ciudad',
            ],
        ]) ?>

    </div>
</div>
