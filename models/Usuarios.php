<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $login
 * @property string|null $nombre
 * @property float|null $anyo_nac
 * @property string $email
 * @property string $password
 * @property string|null $auth_key
 * @property int $rol_id
 * @property string|null $genero
 * @property string|null $pais
 * @property string|null $ciudad
 *
 * @property Roles $rol
 */
class Usuarios extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['login', 'email', 'password'], 'required'],
            [['anyo_nac'], 'number'],
            [['rol_id'], 'default', 'value' => null],
            [['rol_id'], 'integer'],
            [['login', 'nombre', 'email', 'auth_key', 'pais', 'ciudad'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 80],
            [['genero'], 'string', 'max' => 16],
            [['email'], 'unique'],
            [['login'], 'unique'],
            [['rol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['rol_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'nombre' => 'Nombre',
            'anyo_nac' => 'Anyo Nac',
            'email' => 'Email',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'rol_id' => 'Rol ID',
            'genero' => 'Genero',
            'pais' => 'Pais',
            'ciudad' => 'Ciudad',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    { 
    
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public static function findByLogin($login)
    {
        return static::findOne(['login' => $login]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Gets query for [[Rol]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Roles::class, ['id' => 'rol_id'])->inverseOf('usuarios');
    }
}
