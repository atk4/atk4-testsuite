<?php
class Model_AuthUser4 extends Model_AuthUser {
    public $test_user_field='foo';
    public $test_pass_field='bar';
    public $cipher='sha256/salt';

    
    function setPassword($pass){
        $key=$this->api->getConfig('auth/key',$this->api->name);
        $this['bar']=hash_hmac('sha256',
            $pass.$this['foo'],
            $key);
    }
}
