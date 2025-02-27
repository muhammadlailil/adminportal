<?php

namespace Laililmahfud\Adminportal\Auth;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Laililmahfud\Adminportal\Auth\CacheTokenRepository;


class CachePasswordBrokerManager extends PasswordBrokerManager
{
     protected function createTokenRepository(array $config)
     {
          if ($config['provider'] != "admin") {
               return parent::createTokenRepository($config);
          }
          return new CacheTokenRepository(
               $this->app->make(Cache::class),
               $config['expire'] ?? 120
          );
     }

     public function broker($name = null)
     {
          $name = $name ?: config('auth.defaults.passwords');
          if ($name != "admin") {
               return parent::broker($name);
          }
          $config = config("auth.passwords.{$name}");
          return new PasswordBroker(
               $this->createTokenRepository($config),
               $this->app['auth']->createUserProvider($config['provider']),
               $this->app->make(Dispatcher::class)
          );
     }
}
