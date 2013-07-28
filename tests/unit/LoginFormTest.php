<?php
namespace common\models;
use AspectMock\Test as test;

class LoginFormTest extends \Codeception\TestCase\Test
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;

    protected function _before()
    {
        test::clean();
        // test::double('common\models\User', [
        //     'findByUsername' => new User
        // ]);                
    }

    public function testCanLoginWhenValid()
    {
        $user = test::double('common\models\User', [
            // 'validatePassword' => true,
            // 'findByUsername' => new User
        ]);                
        $model = new LoginForm();
        $model->username = 'davert';
        $model->password = '123456';

        $this->assertTrue($model->login());
        $user->verifyInvoked('findByUsername',['davert']);
        $user->verifyInvoked('validatePassword',['123456']);
    }

    // public function testCantLoginWhenInvalid()
    // {
    //     $user = test::double('common\models\User', ['validatePassword' => true]);                
    //     $model = new LoginForm();        
    //     $model->load(['username' => 'davert', 'password' => '123456']);            
    //     $this->assertFalse($model->login());
    //     $user->verifyInvoked('findByUsername',['davert']);
    //     $user->verifyInvoked('validatePassword',['123456']);      

    // }

    public function testCantLoginWithoutPassword()
    {
        $model = new LoginForm();
        $model->load(['username' => 'davert']);            
        $this->assertFalse($model->login());
        $model->load(['password' => 'davert']);            
        $this->assertFalse($model->login());
    }    

}