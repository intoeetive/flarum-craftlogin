<?php
/*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Intoeetive\Flarumcraftlogin;

use Flarum\Http\Controller\ControllerInterface;
use Flarum\Settings\SettingsRepositoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\JsonResponse;


use Flarum\Http\AccessToken;
use Flarum\Api\ApiKey;
use Flarum\Core\Guest;
use Flarum\Core\User;

use Guzzle\Http\Message\Response;

use Flarum\Api\Command\GenerateAccessToken;
use DateTime;


use Flarum\Forum\Controller\WriteRememberCookieTrait;
use Flarum\Forum\UrlGenerator;
use Illuminate\Contracts\Bus\Dispatcher;


class FlarumcraftloginController implements ControllerInterface
{
    //use WriteRememberCookieTrait;
    
    protected $prefix = 'Token ';

    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @var UrlGenerator
     */
    protected $url;
    protected $bus;

    /**
     * @param SettingsRepositoryInterface $settings
     * @param UrlGenerator $url
     * @param Dispatcher $bus
     */
    public function __construct(SettingsRepositoryInterface $settings, UrlGenerator $url, Dispatcher $bus)
    {
        $this->settings = $settings;
        $this->url = $url;
        $this->bus = $bus;
    }

    /**
     * @param Request $request
     * @param array $routeParams
     * @return \Psr\Http\Message\ResponseInterface|RedirectResponse
     */
    public function handle(ServerRequestInterface $request, array $routeParams = [])
    {
        $header = $request->getHeaderLine('authorization');

        $parts = explode(';', $header);

        $actor = new Guest;
        
        

        if (isset($parts[0]) && starts_with($parts[0], $this->prefix)) {
            $token = substr($parts[0], strlen($this->prefix));

            if (($accessToken = AccessToken::find($token)) && $accessToken!=NULL){// $accessToken->isValid()) {
                $actor = $accessToken->user;

                $actor->updateLastSeen()->save();
            } elseif (isset($parts[1]) && ($apiKey = ApiKey::valid($token))) {
                $userParts = explode('=', trim($parts[1]));

                if (isset($userParts[0]) && $userParts[0] === 'userId') {
                    $actor = User::find($userParts[1]);
                }
            }
        }

        if ($actor->exists) {
            $locale = $actor->getPreference('locale');
        } else {
            $locale = array_get($request->getCookieParams(), 'locale');
        }

        if ($locale && $this->locales->hasLocale($locale)) {
            $this->locales->setLocale($locale);
        }
        
        $is_admin = $actor->isAdmin();
        $actor_arr = (array)$actor;
        $actor_attrs = $actor_arr[chr(0).'*'.chr(0).'attributes'];

        if ($is_admin OR $actor_attrs['id']==1)
        {
        
            $request->withAttribute('actor', $actor ?: new Guest);
            
            $data = $request->getParsedBody();
            
            $user = User::where(['username' => $data['username']])->first();

            if ($user) {
                
                if ($user->is_activated==0)
                {
                    $user->activate();
                    $user->save();
                }
                $payload = ['authenticated' => true];

                $token = AccessToken::generate($user->id, 1209600);
                $token->save();
                $tokenId = $token->getAttribute('id');
                
                /*$accessToken = $this->bus->dispatch(new GenerateAccessToken($user->id));
                
                $accessToken::unguard();
                $accessToken->update(['expires_at' => new DateTime('+2 weeks')]);
*/
                echo $tokenId;
                exit();
            } 
        
        }
        
        exit();
        
    }
}
