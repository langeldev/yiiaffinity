<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productos_guionistas".
 *
 * @property int $producto_id
 * @property int $persona_id
 *
 * @property Personas $persona
 * @property Productos $producto
 */
class ProductosGuionistas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productos_guionistas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['producto_id', 'persona_id'], 'required'],
            [['producto_id', 'persona_id'], 'default', 'value' => null],
            [['producto_id', 'persona_id'], 'integer'],
            [['producto_id', 'persona_id'], 'unique', 'targetAttribute' => ['producto_id', 'persona_id']],
            [['persona_id'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::class, 'targetAttribute' => ['persona_id' => 'id']],
            [['producto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Productos::class, 'targetAttribute' => ['producto_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'producto_id' => 'Producto ID',
            'persona_id' => 'Persona ID',
        ];
    }

    /**
     * Gets query for [[Persona]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersona()
    {
        return $this->hasOne(Personas::class, ['id' => 'persona_id'])->inverseOf('productosGuionistas');
    }

    /**
     * Gets query for [[Producto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducto()
    {
        return $this->hasOne(Productos::class, ['id' => 'producto_id'])->inverseOf('productosGuionistas');
    }
}
