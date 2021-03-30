<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "generos".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property ProductosGeneros[] $productosGeneros
 * @property Productos[] $productos
 */
class Generos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'generos';
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
     * Gets query for [[ProductosGeneros]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductosGeneros()
    {
        return $this->hasMany(ProductosGeneros::className(), ['genero_id' => 'id'])->inverseOf('genero');
    }

    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::className(), ['id' => 'producto_id'])->viaTable('productos_generos', ['genero_id' => 'id']);
    }
}
