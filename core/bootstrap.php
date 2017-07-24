<?php

use App\Core\App;
use App\Core\Database\{QueryBuilder, Connection};

       
(new App)->init(realpath(__DIR__.'/../'));

App::bind('database', new QueryBuilder(
    Connection::make(App::get('config')['database'])
));


