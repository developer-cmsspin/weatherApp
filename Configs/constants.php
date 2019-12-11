<?php

define('DEFAULT_CONTROLLER','Home');
define('CONTROLLER_EXT','Controller.php');
define('DEFAULT_ACTION','index');
define('ACTION_EXT','Action');
define('CONTROLLER_FOLDER',__DIR__.'/../controllers/');
define('MODEL_FOLDER',__DIR__.'/../models/');
define('VIEW_FOLDER',__DIR__.'/../views/');

define('DBHOST','localhost');
define('DBPORT','5432');
define('DBUSER','postgres');
define('DBPASS','123456');
define('DBNAME','worldvalidv2');
define('DBTYPE','postgres');

define('blockchain_root','https://blockchain.info/');
define('blockchain_receive_root','https://api.blockchain.info/');
define('my_xpub', "xpub6DS3YSRx7yWTbcuj8sv5k7gZkays5BgyFrcXYxC3iQyExthD2VVjoMXKkEFwZnGYggFWVQB5BVSABr6cMTEL8FVDpMh8NVNgKg1t5713doV");
define('my_api_key', "ddf8fc84-8c6c-4fc7-bd09-acbad911ce69");
define('secret', "Anxnosw49eh");
define('max_confirmations', 2);
define('min_pay_recharge', 20);
define('percent_recharge', 0.05);
define('mysite_root',"https://de4a593a.ngrok.io/William/worldvalidv2/api/?controller=webhook&action=receivePayments");