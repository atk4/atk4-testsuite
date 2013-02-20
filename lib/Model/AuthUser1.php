<?php
class Model_AuthUser1 extends Model_AuthUser {
    public $test_user_field='email';
    public $test_pass_field='password';
    public $cipher=null;

    function setPassword($pass){
        $this['password']=$pass;
    }
}
