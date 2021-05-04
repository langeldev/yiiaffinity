<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

use function PHPSTORM_META\map;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $login
 * @property string|null $nombre
 * @property float|null $anyo_nac
 * @property string $email
 * @property string $password
 * @property string $password_repeat
 * @property string|null $auth_key
 * @property int $rol_id
 * @property string|null $genero
 * @property string|null $pais
 * @property string|null $ciudad
 *
 * @property Roles $rol
 * @property Criticas[] $criticas
 * @property Productos[] $productos
 */
class Usuarios extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    public $password_repeat;
    private static $_generos = ['Hombre', 'Mujer','No bibario'];
   
    
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
            [['login', 'email'], 'required'],
            [['password', 'password_repeat'], 'required', 'on' => [self::SCENARIO_CREATE]],
            [['password_repeat'], 'compare', 'compareAttribute' => 'password', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['password_repeat'], 'safe', 'on' => [self::SCENARIO_UPDATE]],
            [['anyo_nac'], 'number', 'max' => 9999],
            [['rol_id'], 'default', 'value' => 2],
            [['rol_id'], 'integer'],
            [['login', 'nombre', 'email', 'auth_key', 'pais', 'ciudad'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 80],
            [['genero'], 'string', 'max' => 16],
            [['email', 'login'], 'unique'],
            [['rol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::class, 'targetAttribute' => ['rol_id' => 'id']],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['password_repeat']);
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
            'anyo_nac' => 'Año',
            'email' => 'Email',
            'password' => 'Contraseña',
            'password_repeat' => 'Repetir Contraseña',
            'auth_key' => 'Auth Key',
            'rol_id' => 'Rol',
            'genero' => 'Género',
            'pais' => 'País',
            'ciudad' => 'Ciudad',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
            
        if ($insert) {
            if ($this->scenario === self::SCENARIO_CREATE) {
                $this->auth_key = Yii::$app->security
                                    ->generateRandomString();
                goto salto;
            }
        } else {
            if ($this->scenario === self::SCENARIO_UPDATE) {
                if ($this->password === '') {
                    $this->password = $this->getOldAttribute('password');
                } else {
                    salto:
                    $this->password = Yii::$app->security
                    ->generatePasswordHash($this->password);
                }
            }
        }

        return true;
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

     /**
     * Gets query for [[Criticas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCriticas()
    {
        return $this->hasMany(Criticas::class, ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
    * Gets query for [[Valoraciones]].
    *
    * @return \yii\db\ActiveQuery
    */
    public function getValoraciones()
    {
        return $this->hasMany(Valoraciones::class, ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
    * Gets query for [[Usuario]].
    *
    * @return \yii\db\ActiveQuery
    */
    public function getUsuariosListas()
    {
        return $this->hasOne(UsuariosListas::class, ['usuario_id' => 'id'])->inverseOf('usuario');
    }
    
    /**
     * Gets query for [[Productos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Productos::class, ['id' => 'producto_id'])->viaTable('criticas', ['usuario_id' => 'id']);
    }
    /**
     * Genera un array de clave y valor con los géneros de usuarios
     * @return array
     */
    public static function listaGeneros()
    {
        $genero_array = [];
        foreach (self::$_generos as $genero) {
            $genero_array[] = ['id' => $genero, 'name' => $genero];
        }
      
        return ArrayHelper::map($genero_array, 'id', 'name');
    }
    
    /**
     * Comprueba si el usuario logueado es Administrador
     * @return bool
     */
    public function getSoyAdmin()
    {
        $usuario = Usuarios::findOne(Yii::$app->user->id);
        return $usuario->rol->rol === 'admin';
    }
}
