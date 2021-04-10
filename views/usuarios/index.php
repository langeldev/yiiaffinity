<?php

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="fondo p-2">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Usuario', ['create'], ['class' => 'btn btn-principal']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'login',
            'nombre',
            'anyo_nac',
            'email:email',
            'rol.rol',
            'genero',
            'pais',
            'ciudad',
            ['__class' => ActionColumn::class], 
        ],
        'options' => [
            'class' => 'table table-responsive'
        ]
    ]); ?>

</div>
