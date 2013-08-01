<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\Identity;

/**
 * class User__AopProxied
 * @package common\models
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */
class User__AopProxied extends ActiveRecord implements Identity
{
	/**
	 * @var string the raw password. Used to collect password input and isn't saved in database
	 */
	public $password;

	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 10;

	const ROLE_USER = 10;

	public function behaviors()
	{
		return array(
			'timestamp' => array(
				'class' => 'yii\behaviors\AutoTimestamp',
				'attributes' => array(
					ActiveRecord::EVENT_BEFORE_INSERT => array('create_time', 'update_time'),
					ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
				),
			),
		);
	}

	/**
	 * Finds an identity by the given ID.
	 *
	 * @param string|integer $id the ID to be looked for
	 * @return Identity|null the identity object that matches the given ID.
	 */
	public static function findIdentity($id)
	{
		return static::find($id);
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return null|User
	 */
	public static function findByUsername($username)
	{
		return static::find(array('username' => $username, 'status' => static::STATUS_ACTIVE));
	}

	/**
	 * @return int|string current user ID
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string current user auth key
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * @param string $authKey
	 * @return boolean if auth key is valid for current user
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Security::validatePassword($password, $this->password_hash);
	}

	public function rules()
	{
		return array(
			array('username', 'filter', 'filter' => 'trim'),
			array('username', 'required'),
			array('username', 'string', 'min' => 2, 'max' => 255),

			array('email', 'filter', 'filter' => 'trim'),
			array('email', 'required'),
			array('email', 'email'),
			array('email', 'unique', 'message' => 'This email address has already been taken.', 'on' => 'signup'),
			array('email', 'exist', 'message' => 'There is no user with such email.', 'on' => 'requestPasswordResetToken'),

			array('password', 'required'),
			array('password', 'string', 'min' => 6),
		);
	}

	public function scenarios()
	{
		return array(
			'signup' => array('username', 'email', 'password'),
			'login' => array('username', 'password'),
			'resetPassword' => array('password'),
			'requestPasswordResetToken' => array('email'),
		);
	}

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if (($this->isNewRecord || $this->getScenario() === 'resetPassword') && !empty($this->password)) {
				$this->password_hash = Security::generatePasswordHash($this->password);
			}
			if ($this->isNewRecord) {
				$this->auth_key = Security::generateRandomKey();
			}
			return true;
		}
		return false;
	}
}
/**
 * Class User
 * @package common\models
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */
class User extends User__AopProxied implements \Go\Aop\Proxy
{


    /**
     *Property was created automatically, do not change it manually
     */
    private static $__joinPoints = array();
    
    
    public function beforeSave($insert)
    {
        return self::$__joinPoints['method:beforeSave']->__invoke($this, array($insert));
    }
    
    
    public function behaviors()
    {
        return self::$__joinPoints['method:behaviors']->__invoke($this);
    }
    
    /**
     * Finds user by username
     *
     * @param string $username
     * @return null|User
     */
    public static function findByUsername($username)
    {
        return self::$__joinPoints['static:findByUsername']->__invoke(get_called_class(), array($username));
    }
    
    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return Identity|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return self::$__joinPoints['static:findIdentity']->__invoke(get_called_class(), array($id));
    }
    
    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return self::$__joinPoints['method:getAuthKey']->__invoke($this);
    }
    
    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return self::$__joinPoints['method:getId']->__invoke($this);
    }
    
    
    public function rules()
    {
        return self::$__joinPoints['method:rules']->__invoke($this);
    }
    
    
    public function scenarios()
    {
        return self::$__joinPoints['method:scenarios']->__invoke($this);
    }
    
    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return self::$__joinPoints['method:validateAuthKey']->__invoke($this, array($authKey));
    }
    
    /**
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return self::$__joinPoints['method:validatePassword']->__invoke($this, array($password));
    }
    
}
\Go\Proxy\ClassProxy::injectJoinPoints('common\models\User', unserialize('a:10:{s:16:"method:behaviors";a:2:{i:0;C:40:"Go\\Aop\\Framework\\MethodAroundInterceptor":132:{a:1:{s:12:"adviceMethod";a:3:{s:5:"scope";s:6:"aspect";s:6:"method";s:11:"stubMethods";s:6:"aspect";s:22:"AspectMock\\Core\\Mocker";}}}i:1;C:40:"Go\\Aop\\Framework\\MethodAroundInterceptor":140:{a:1:{s:12:"adviceMethod";a:3:{s:5:"scope";s:6:"aspect";s:6:"method";s:19:"registerMethodCalls";s:6:"aspect";s:22:"AspectMock\\Core\\Mocker";}}}}s:19:"static:findIdentity";a:2:{i:0;r:3;i:1;r:9;}s:21:"static:findByUsername";a:2:{i:0;r:3;i:1;r:9;}s:12:"method:getId";a:2:{i:0;r:3;i:1;r:9;}s:17:"method:getAuthKey";a:2:{i:0;r:3;i:1;r:9;}s:22:"method:validateAuthKey";a:2:{i:0;r:3;i:1;r:9;}s:23:"method:validatePassword";a:2:{i:0;r:3;i:1;r:9;}s:12:"method:rules";a:2:{i:0;r:3;i:1;r:9;}s:16:"method:scenarios";a:2:{i:0;r:3;i:1;r:9;}s:17:"method:beforeSave";a:2:{i:0;r:3;i:1;r:9;}}'));