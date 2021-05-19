<?php

use Carbon\Carbon;

define('SERVER_NAME', 'localhost');
define('MATCH_DATE', Carbon::now('Europe/Brussels')->locale('fr_BE')->isoFormat('dddd MMMM YYYY'));