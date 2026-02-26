<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('media:cleanup')->dailyAt('03:00');
Schedule::command('carts:cleanup')->dailyAt('04:00');
