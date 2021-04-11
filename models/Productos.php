<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos".
 *
 * @property int $id
 * @property string $titulo
 * @property string $titulo_original
 * @property float $anyo
 * @property int $duracion
 * @property int $tipo_id
 * @property string $pais
 * @property string $sinopsis
 *
 * @property Criticas[] $criticas
 * @property Usuarios[] $usuarios
 * @property ListasProductos[] $listasProductos
 * @property UsuariosListas[] $listas
 * @property Premios[] $premios
 * @property Tipos $tipo
 * @property ProductosDirectores[] $productosDirectores
 * @property Directores[] $directors
 * @property ProductosFotografia[] $productosFotografias
 * @property Fotografia[] $fotografias
 * @property ProductosGeneros[] $productosGeneros
 * @property Generos[] $generos
 * @property ProductosGuionistas[] $productosGuionistas
 * @property Guionistas[] $guions
 * @property ProductosInterpretes[] $productosInterpretes
 * @property Interpretes[] $interpretes
 * @property ProductosMusica[] $productosMusicas
 * @property Musica[] $musicas
 * @property ProductosProductoras[] $productosProductoras
 * @property Productoras[] $productoras
 * @property Valoraciones[] $valoraciones
 * @property Usuarios[] $usuarios0
 */
class Productos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'titulo_original', 'anyo', 'duracion', 'tipo_id', 'pais', 'sinopsis'], 'required'],
            [['anyo'], 'number'],
            [['duracion', 'tipo_id'], 'default', 'value' => null],
            [['duracion', 'tipo_id'], 'integer'],
            [['sinopsis'], 'string'],
            [['titulo', 'titulo_original', 'pais'], 'string', 'max' => 255],
            [['tipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tipos::class, 'targetAttribute' => ['tipo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'titulo_original' => 'Título Original',
            'anyo' => 'Año',
            'duracion' => 'Duración',
            'tipo_id' => 'Tipo',
            'pais' => 'País',
            'sinopsis' => 'Sinopsis',
            'directors' => 'Dirección',
            'guions' => 'Guion',
            'musicas' => 'Música',
            'fotografia' => 'Fotografía',
            'interpretes' => 'Reparto',
            'productoras' => 'Porductora',
            'generos' => 'Géneros'
        ];
    }

    /**
     * Gets query for [[Criticas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCriticas()
    {
        return $this->hasMany(Criticas::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Usuarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::class, ['id' => 'usuario_id'])->viaTable('criticas', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[ListasProductos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListasProductos()
    {
        return $this->hasMany(ListasProductos::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Listas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getListas()
    {
        return $this->hasMany(UsuariosListas::class, ['id' => 'lista_id'])->viaTable('listas_productos', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[Premios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPremios()
    {
        return $this->hasMany(Premios::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Tipo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(Tipos::class, ['id' => 'tipo_id'])->inverseOf('productos');
    }

    /**
     * Gets query for [[ProductosDirectores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosDirectores()
    {
        return $this->hasMany(ProductosDirectores::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Directors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDirectors()
    {
        return $this->hasMany(Directores::class, ['id' => 'director_id'])->viaTable('productos_directores', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosFotografias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosFotografias()
    {
        return $this->hasMany(ProductosFotografia::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Fotografias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFotografias()
    {
        return $this->hasMany(Fotografia::class, ['id' => 'fotografia_id'])->viaTable('productos_fotografia', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosGeneros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosGeneros()
    {
        return $this->hasMany(ProductosGeneros::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Generos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGeneros()
    {
        return $this->hasMany(Generos::class, ['id' => 'genero_id'])->viaTable('productos_generos', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosGuionistas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosGuionistas()
    {
        return $this->hasMany(ProductosGuionistas::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Guions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGuions()
    {
        return $this->hasMany(Guionistas::class, ['id' => 'guion_id'])->viaTable('productos_guionistas', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosInterpretes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosInterpretes()
    {
        return $this->hasMany(ProductosInterpretes::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Interpretes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterpretes()
    {
        return $this->hasMany(Interpretes::class, ['id' => 'interprete_id'])->viaTable('productos_interpretes', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosMusicas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosMusicas()
    {
        return $this->hasMany(ProductosMusica::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Musicas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMusicas()
    {
        return $this->hasMany(Musica::class, ['id' => 'musica_id'])->viaTable('productos_musica', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[ProductosProductoras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosProductoras()
    {
        return $this->hasMany(ProductosProductoras::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Productoras]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductoras()
    {
        return $this->hasMany(Productoras::class, ['id' => 'productora_id'])->viaTable('productos_productoras', ['producto_id' => 'id']);
    }

    /**
     * Gets query for [[Valoraciones]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getValoraciones()
    {
        return $this->hasMany(Valoraciones::class, ['producto_id' => 'id'])->inverseOf('producto');
    }

    /**
     * Gets query for [[Usuarios0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios0()
    {
        return $this->hasMany(Usuarios::class, ['id' => 'usuario_id'])->viaTable('valoraciones', ['producto_id' => 'id']);
    }

    /**
     * Suma las valoraciones del producto
     *
     * @return int $number
     */
    private function suma()
    {
        return Valoraciones::find()->where(['producto_id' => $this->id])->sum('valoracion');
    }
    
    /**
     * Cuenta la cantidad de votos que tiene un producto
     *
     * @return int $number
     */
    public function votosTotales()
    {
        return Valoraciones::find()->where(['producto_id' => $this->id])->count();
    }

    /**
     * Hace la media de las valoraciones
     *
     * @return float $number
     */
    public function getMedia()
    {
        return number_format(
            ($this->votosTotales() !== 0
            ? $this->suma() / $this->votosTotales()
            : 0
            ),
            1
        );
    }


    /**
     * Suma las valoraciones de las críticas deĺ producto
     *
     * @return int $number
     */
    private function sumaCriticas()
    {
        return Criticas::find()->where(['producto_id' => $this->id])->sum('valoracion');
    }

    /**
     * Cuenta la cantidad de criticas que tiene un producto
     *
     * @return int $number
     */
    public function criticasTotales()
    {
        return Criticas::find()->where(['producto_id' => $this->id])->count();
    }

    /**
     * Hace la media de las valoraciones de las criticas
     *
     * @return float $number
     */
    public function getMediaCriticas()
    {
        return number_format(
            ($this->criticasTotales() !== 0
            ? $this->sumaCriticas() / $this->criticasTotales()
            : 0
            ),
            1
        );
    }

}
