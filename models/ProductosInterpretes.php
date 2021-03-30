<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos_interpretes".
 *
 * @property int $producto_id
 * @property int $interprete_id
 *
 * @property Interpretes $interprete
 * @property Productos $producto
 */
class ProductosInterpretes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos_interpretes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'interprete_id'], 'required'],
            [['producto_id', 'interprete_id'], 'default', 'value' => null],
            [['producto_id', 'interprete_id'], 'integer'],
            [['producto_id', 'interprete_id'], 'unique', 'targetAttribute' => ['producto_id', 'interprete_id']],
            [['interprete_id'], 'exist', 'skipOnError' => true, 'targetClass' => Interpretes::className(), 'targetAttribute' => ['interprete_id' => 'id']],
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
            'interprete_id' => 'Interprete ID',
        ];
    }

    /**
     * Gets query for [[Interprete]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterprete()
    {
        return $this->hasOne(Interpretes::className(), ['id' => 'interprete_id'])->inverseOf('productosInterpretes');
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::className(), ['id' => 'producto_id'])->inverseOf('productosInterpretes');
    }
}
