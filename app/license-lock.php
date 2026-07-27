<?php

/*
|--------------------------------------------------------------------------
| Direct Code-Based System Lock
|--------------------------------------------------------------------------
|
| The simplest way to lock the whole system: change 'locked' to true below
| (with an optional 'message' shown to users), commit, and deploy exactly
| as you normally deploy any other code change. No .env, no database, no
| server access beyond whatever you already use to ship code.
|
| To unlock: set 'locked' back to false and deploy again.
|
| This file is read directly (not through Laravel's config cache), so it
| takes effect immediately on deploy even if the server runs
| `php artisan config:cache`.
|
*/

return [
    'locked'  => false,
    'message' => null,
];
