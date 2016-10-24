<?php

namespace Intoeetive\Craftlogin;

require __DIR__.'/vendor/autoload.php';

use Illuminate\Contracts\Events\Dispatcher;

return function (Dispatcher $events) {
    $events->subscribe(Listeners\AddCraftloginRoute::class);
};