<?php
/*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Intoeetive\Flarumcraftlogin\Listeners;

use Flarum\Event\ConfigureApiRoutes;
use Illuminate\Contracts\Events\Dispatcher;
use Intoeetive\Flarumcraftlogin\FlarumcraftloginController;

class AddCraftloginRoute
{
    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(ConfigureApiRoutes::class, [$this, 'configureApiRoutes']);
    }

    /**
     * @param ConfigureApiRoutes $event
     */
    public function configureApiRoutes(ConfigureApiRoutes $event)
    {
        $event->post('/login/craft', 'login.craft', FlarumcraftloginController::class);
    }
}
