<?php
/*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Intoeetive\Craftlogin\Listeners;

use Flarum\Event\ConfigureApiRoutes;
use Illuminate\Events\Dispatcher;

class AddCraftloginRoute
{
    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        //$events->listen(ConfigureApiRoutes::class, [$this, 'ConfigureApiRoutes']);
    }

    /**
     * @param ConfigureApiRoutes $event
     */
    /*public function ConfigureApiRoutes(ConfigureApiRoutes $event)
    {
        $event->post('/login/craft', 'login.craft', Intoeetive\Craftlogin\CraftloginController::class);
    }*/
}
