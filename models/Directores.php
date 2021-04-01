<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "directores".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property ProductosDirectores[] $productosDirectores
 * @property Productos[] $productos
 */
class Directores extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'directores';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[ProductosDirectores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosDirectores()
    {
        return $this->hasMany(ProductosDirectores::class, ['director_id' => 'id'])->inverseOf('director');
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::class, ['id' => 'producto_id'])->viaTable('productos_directores', ['director_id' => 'id']);
    }

    /**
    * Devuelve una lista con los directores
    *
    * @return array
    */
    public static function lista()
    {
        return static::find()->select('nombre')->indexBy('id')->column();
    }
}
