<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm__AopProxied extends Model
{
	public $username;
	public $password;
	public $rememberMe = true;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return array(
			// username and password are both required
			array('username, password', 'required'),
			// password is validated by validatePassword()
			array('password', 'validatePassword'),
			// rememberMe must be a boolean value
			array('rememberMe', 'boolean'),
		);
	}

	/**
	 * Validates the password.
	 * This method serves as the inline validation for password.
	 */
	public function validatePassword()
	{
		$user = User::findByUsername($this->username);
		if (!$user || !$user->validatePassword($this->password)) {
			$this->addError('password', 'Incorrect username or password.');
		}
	}

	/**
	 * Logs in a user using the provided username and password.
	 * @return boolean whether the user is logged in successfully
	 */
	public function login()
	{
		if ($this->validate()) {
			$user = User::findByUsername($this->username);
			Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
			return true;
		} else {
			return false;
		}
	}
}
/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends LoginForm__AopProxied implements \Go\Aop\Proxy
{


    /**
     *Property was created automatically, do not change it manually
     */
    private static $__joinPoints = array();
    
    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        return self::$__joinPoints['method:login']->__invoke($this);
    }
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return self::$__joinPoints['method:rules']->__invoke($this);
    }
    
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        return self::$__joinPoints['method:validatePassword']->__invoke($this);
    }
    
}
\Go\Proxy\ClassProxy::injectJoinPoints('common\models\LoginForm', unserialize('a:3:{s:12:"method:rules";a:2:{i:0;C:40:"Go\\Aop\\Framework\\MethodAroundInterceptor":132:{a:1:{s:12:"adviceMethod";a:3:{s:5:"scope";s:6:"aspect";s:6:"method";s:11:"stubMethods";s:6:"aspect";s:22:"AspectMock\\Core\\Mocker";}}}i:1;C:40:"Go\\Aop\\Framework\\MethodAroundInterceptor":140:{a:1:{s:12:"adviceMethod";a:3:{s:5:"scope";s:6:"aspect";s:6:"method";s:19:"registerMethodCalls";s:6:"aspect";s:22:"AspectMock\\Core\\Mocker";}}}}s:23:"method:validatePassword";a:2:{i:0;r:3;i:1;r:9;}s:12:"method:login";a:2:{i:0;r:3;i:1;r:9;}}'));