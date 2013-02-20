<?php
class Model_AuthUser2 extends Model_AuthUser {
    public $test_user_field='username';
    public $test_pass_field='password';
    public $cipher='md5';

    
    function setPassword($pass){
        $this['password']=md5($pass);
    }
}
