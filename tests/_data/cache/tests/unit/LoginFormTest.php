<?php
namespace common\models;
use AspectMock\Test as test;

class LoginFormTest extends \PHPUnit_Framework_TestCase
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;

    public function setUp()
    {
        test::clean();
        test::double('common\models\User', [
            'findByUsername' => new User,
            'getId' => 1,
        ]);

    }

    public function testCanLoginWhenValid()
    {
        $user = test::double('common\models\User', ['validatePassword' => true]);

        $model = new LoginForm();
        $model->username = 'davert';
        $model->password = '123456';

        $this->assertTrue($model->login());
        $user->verifyInvoked('findByUsername',['davert']);
        $user->verifyInvoked('validatePassword',['123456']);
    }

     public function testCantLoginWhenInvalid()
     {
         $user = test::double('common\models\User', ['validatePassword' => false]);

         $model = new LoginForm();
         $model->username = 'davert';
         $model->password = '123456';

         $this->assertFalse($model->login());
         $user->verifyInvoked('findByUsername',['davert']);
         $user->verifyInvoked('validatePassword',['123456']);

     }

    public function testCantLoginWithoutPassword()
    {
        test::double('common\models\User', ['validatePassword' => true]);
        $model = new LoginForm();
        $model->username = 'davert';
        $this->assertFalse($model->login());
        $model->password = '123456';
        $this->assertTrue($model->login());
    }    

}