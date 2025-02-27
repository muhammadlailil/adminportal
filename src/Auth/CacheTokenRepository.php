<?php
namespace Laililmahfud\Adminportal\Auth;

use Illuminate\Auth\Passwords\TokenRepositoryInterface;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Support\Str;

class CacheTokenRepository implements TokenRepositoryInterface
{
     protected $cache;
     protected $expires;

     public function __construct(Cache $cache, $expires = 60)
     {
          $this->cache = $cache;
          $this->expires = $expires;
     }

     public function create($user)
     {
          $email = $user->email;
          $token = Str::random(64);

          $this->cache->put("admin:password-reset:{$email}", $token, now()->addMinutes($this->expires));

          return $token;
     }

     public function exists($user, $token)
     {
          $email = $user->email;
          return $this->cache->get("admin:password-reset:{$email}") === $token;
     }

     public function recentlyCreatedToken($user)
     {
     }

     public function delete($user)
     {
          $this->cache->forget("admin:password-reset:{$user->email}");
     }

     public function deleteExpired()
     {
     }

     public function existsToken($email, $token)
     {
          return $this->cache->get("admin:password-reset:{$email}") === $token;
     }
}
