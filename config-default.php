<?php

$config['atk']['base_path']='/atk42/atk4/';

$config['dbtests']['mysql']='mysql://root:root@localhost/project';
$config['dbtests']['sqlite']=array('sqlite:/tmp/atk4-test.sq3');
$config['dsn']='mysql://root:root@localhost/project';

$config['url_postfix']='';
$config['url_prefix']='?page=';

$config['addons']['active']=array(
    'atk4/atk4tests',
);
