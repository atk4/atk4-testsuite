<?php
class Model_AuthUser extends Model_Table {
    public $table;
    function init(){
        $this->table=get_class($this);
        $this->table=strtolower(str_replace('Model_','',$this->table));
        parent::init();

        $this->addField($this->test_user_field);
        $this->addField($this->test_pass_field);
        $this->addField('result')->defaultValue('not tested');
        $this->addField('debug')->type('text')->display(array('grid'=>'html'));
    }

    function test(){
        $a=$this->add('Auth');
        $a->setModel($this->newInstance(),$this->test_user_field,$this->test_pass_field);
        $a->debug();
        $a->usePasswordEncryption($this->cipher);
        $res=$a->verifyCredentials($this[$this->test_user_field],'demo');
        $this['result']=$res?'OK':'FAIL';
        $this['debug']=$this->api->logger->debug_log;
        $this->api->logger->debug_log=null;

        $this->save();
    }

}
