<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('match-queue:start')->everyMinute();
