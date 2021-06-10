<?php



use yii\bootstrap4\Html;
use yii\helpers\Url;


\yii\web\YiiAsset::register($this);

$urlCambiar = Url::to(['listas-productos/cambiar-posicion']);
$urlEliminar = Url::to(['listas-productos/delete']);

$js = <<<EOT
$('.subir').click(function(ev){
    ev.preventDefault();      
    let el = $(this).parents('li');
    let bajar = el.prev();  
    cambairPoscion(el, bajar,'$urlCambiar')
});

$('.bajar').click(function(ev){
      ev.preventDefault();      
      let el = $(this).parents('li');
      let subir = el.next();
      
      cambairPoscion(subir,el,'$urlCambiar')
    });

    $('.eliminar').click(function (ev) {
        ev.preventDefault();
        var el = $(this);
      var lista_id = el.data('key');
      var titulo = el.data('titulo');
      var confirmado = confirm('¿Estás seguro que quiere eliminar "' + titulo + ' de esta lista?');
      if (confirmado) {
          el.attr('disabled', true);
      $.ajax({
          type: 'POST',
          url: '$urlEliminar',
          data: {
              lista_id: lista_id
            },
          success: function(data){
              if (data.titulo == titulo){
                  el.parents('li').slideUp('normal', function (event) {
                      $(this).remove();
                      inhabilitar(); 
                    });
                }
            }
        });
    }
     return false;
    });
  
    
  inhabilitar();  
EOT;
$this->registerJs($js);
?>

<li id="<?= $model->id ?>" class="lista-producto">
    <div class="row">
        <div class="col img-lista pr-0">
            <?= Html::img($model->producto->getImagen(), ['class' => 'img-fluid']) ?>
        </div>
        <h3 class="col-7">
       
            <?= Html::a(Html::encode($model->producto->titulo), ['/productos/ficha', 'id' => $model->producto->id]) ?>
        </h3>
        <div class="col-3">
            <?php if (!Yii::$app->user->isGuest) : ?>
                <?php if ($model->lista->usuario_id === Yii::$app->user->id) : ?>
                    <?= Html::button('<i class="fas fa-arrow-up"></i>', [
                        'class' => 'btn btn-outline-info border-0 rounded-0 subir',
                        'method' => 'post'
                    ])
                    ?>
                    <?= Html::button('<i class="fas fa-arrow-down"></i>', [
                        'class' => 'btn btn-outline-info border-0 rounded-0 bajar',
                        'data-key' => $model->id,
                        'method' => 'post'
                    ])
                    ?>
                    <?= Html::button('x', [
                        'class' => 'btn btn-outline-danger rounded-0 eliminar',
                        'data-key' => $model->id,
                        'data-method' => 'POST',
                        'title' => 'Eliminar  de esta lista',
                        'data-titulo' => $model->producto->titulo
                    ])
                    ?>
                <?php endif ?>
            <?php endif ?>
        </div>
    </div>
</li>
