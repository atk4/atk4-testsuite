<?php
class Model_AuthUser3 extends Model_AuthUser {
    public $test_user_field='username';
    public $test_pass_field='password';
    public $cipher='php';

    
    function setPassword($pass){
        $this['password']=password_hash($pass,PASSWORD_DEFAULT);
    }
}
