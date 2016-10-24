<?php

namespace Intoeetive\Flarumcraftlogin;

use Illuminate\Contracts\Events\Dispatcher;

return function (Dispatcher $events) {
    $events->subscribe(Listeners\AddCraftloginRoute::class);
};
/*return function () {
    echo 'Hello, world!';
};*/