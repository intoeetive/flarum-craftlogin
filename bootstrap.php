<?php

namespace Intoeetive\Craftlogin;

use Illuminate\Contracts\Events\Dispatcher;

return function (Dispatcher $events) {
    $events->subscribe(Listeners\AddCraftloginRoute::class);
};
/*return function () {
    echo 'Hello, world!';
};*/