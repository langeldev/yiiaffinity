<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos_generos".
 *
 * @property int $producto_id
 * @property int $genero_id
 *
 * @property Generos $genero
 * @property Productos $producto
 */
class ProductosGeneros extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos_generos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'genero_id'], 'required'],
            [['producto_id', 'genero_id'], 'default', 'value' => null],
            [['producto_id', 'genero_id'], 'integer'],
            [['producto_id', 'genero_id'], 'unique', 'targetAttribute' => ['producto_id', 'genero_id']],
            [['genero_id'], 'exist', 'skipOnError' => true, 'targetClass' => Generos::className(), 'targetAttribute' => ['genero_id' => 'id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Productos::className(), 'targetAttribute' => ['producto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'producto_id' => 'Producto ID',
            'genero_id' => 'Genero ID',
        ];
    }

    /**
     * Gets query for [[Genero]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenero()
    {
        return $this->hasOne(Generos::className(), ['id' => 'genero_id'])->inverseOf('productosGeneros');
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::className(), ['id' => 'producto_id'])->inverseOf('productosGeneros');
    }
}
