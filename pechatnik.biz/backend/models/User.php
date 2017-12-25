<?php
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\db\Expression;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
  const STATUS_DELETED = 0;
  const STATUS_INACTIVE = 1;
  const STATUS_ACTIVE = 2;
  const STATUS_SUSPENDED = 3;

  const FRONTEND_USER_ID = 0;
  
  private $_isSuperAdmin = null;

  public $role;

  public $password;
  public $repeat_password;

  public function behaviors()
  {
    return [
      'timestamp' => [
        'class' => 'yii\behaviors\TimestampBehavior',
        'attributes' => [
          self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
        ],
        'value' => function () {
          return new Expression('CURRENT_TIMESTAMP');
        }
      ],
    ];
  }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    // public function behaviors()
    // {
    //     return [
    //         TimestampBehavior::className(),
    //     ];
    // }

    /**
     * @inheritdoc
     */

     public function rules()
    	{
    		return [
    			['status', 'required'],
    			['status', 'default', 'value' => self::STATUS_ACTIVE],
          ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED, self::STATUS_INACTIVE, self::STATUS_SUSPENDED]],

    			['username', 'filter', 'filter' => 'trim'],
    			['username', 'required'],
    			['username', 'unique', 'message' => 'Это имя уже занато.'],
    			['username', 'string', 'min' => 2, 'max' => 255],

          ['description', 'filter', 'filter' => 'trim'],
    			['description', 'required'],

    			['email', 'filter', 'filter' => 'trim'],
    			['email', 'required'],
    			['email', 'email'],
    			['email', 'unique', 'message' => 'Этот email уже занят.'],
    			['email', 'exist', 'message' => 'Нет пользователя с таким email.', 'on' => 'requestPasswordResetToken'],

          ['id_city', 'required'],
          ['id_city', 'integer'],

    			['role', 'required'],

    			['password', 'required', 'on'=>'default'],
    			['password', 'string', 'min' => 6, 'tooShort' => 'Пароль должен быть больше 6 символов'],
    			['password', 'match', 'pattern'=>'/(?=.*\d)(?=.*[a-z]).*/', 'message' =>'Пароль должен должен содержать буквы и цифры'],

          ['repeat_password','compare','compareAttribute'=>'password', 'message'=>'Пароли не совпадают'],
    		];
    	}

      public function scenarios()
    	{
    		return [
    			'default' => ['username', 'email', 'password_hash','password', 'repeat_password','status', 'role', 'id_city', 'description'],
    			'profile' => ['username', 'email', 'password_hash','password','repeat_password','status', 'role', 'id_city', 'description'],
    			'resetPassword' => ['password_hash'],
    		] + parent::scenarios();
    	}

    	/**
    	 * @inheritdoc
    	 */
    	public function attributeLabels()
    	{
    		return [
    			'id' => 'ID',
    			'username' => 'Логин',
          'description' => 'Имя',
    			'email' =>'Email',
    			'password_hash' => 'Password Hash',
    			'password_reset_token' => 'Password Reset Token',
    			'auth_key' => 'Auth Key',
    			'status' => 'Статус',
    			'last_visit_time' => 'Время последнего визита',
    			'created_at' => 'Create Time',
    			'updated_at' => 'Update Time',
    			'password' => 'Пароль',
          'new_password' => 'Новый пароль',
          'repeat_password' => 'Повторите пароль',
    			'role' => 'Роль',
          'id_city' => 'Город',
    		];
    	}


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function beforeSave($insert) {
        if ($this->password !== '') {
            $this->setPassword($this->password);
        }
        return parent::beforeSave($insert);
    }

    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'id_city']);
    }
}
