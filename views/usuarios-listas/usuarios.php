<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

$this->title = $usuario->login;;
if (!Yii::$app->user->isGuest) {
    $this->params['breadcrumbs'][] = ['label' => 'Mis amigos', 'url' => ['/seguidores/mis-amigos']];
}
$this->params['breadcrumbs'][] = ['label' => 'Buscar amigos', 'url' => ['usuarios/buscar-amigos']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="fondo p-2">
    <div class="col-12">


        <section class="perfil-usuario">
            <?= $this->render('/usuarios/_perfil', [
                'usuario' => $usuario
            ]) ?>
        </section>
        <ul class="nav-user col-12 mb-5">
            <li>
                <?= Html::a('<i class="far fa-newspaper"></i> Críticas [' . count($usuario->criticas) . ']',  ['/criticas/usuarios', 'id' => $usuario->id]) ?>
            </li>
            <li>
                <?= Html::a('<i class="far fa-star"></i> Valoraciones [' . count($usuario->valoraciones) . ']', ['/valoraciones/usuarios', 'id' => $usuario->id]) ?>
            </li>
            <li>
                <?= Html::a('<i class="fas fa-list"></i> Listas [' .  $usuario->listasTotales . ']', '', ['class' => 'user-selected']) ?>
            </li>
        </ul>
        <section class="py-5 my-5">
            <?= GridView::widget([
                'dataProvider' => $listas,
                'layout' => "{summary}\n{items}\n<div class='d-flex justify-content-center'>{pager}</div>",
                'columns' => [
                    [
                        'label' => 'Listas',
                        'value' => function ($model) {
                            return Html::a(Html::encode($model->lista->titulo), ['usuarios-listas/view', 'id' => $model->id]);
                        },
                        'format' => 'html'

                    ],
                ],
                'options' => [
                    'class' => 'table table-responsive '
                ]
            ]); ?>


        </section>
    </div>
</div>
