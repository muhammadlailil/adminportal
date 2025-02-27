<?php

namespace Laililmahfud\Adminportal\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordLinkNotification extends Notification
{
     use Queueable;

     /**
      * Create a new notification instance.
      */
     public function __construct(public $token)
     {
          //
     }

     /**
      * Get the notification's delivery channels.
      *
      * @return array<int, string>
      */
     public function via(object $notifiable): array
     {
          return ['mail'];
     }

     /**
      * Get the mail representation of the notification.
      */
     public function toMail(object $notifiable): MailMessage
     {

          $url = URL::temporarySignedRoute(
               'admin.auth.reset-password',
               Carbon::now()->addHours(2),
               [
                    'uuid' => $notifiable->uuid,
                    'token' => $this->token,
                    'email' => $notifiable->email
               ]
          );
          return (new MailMessage)
               ->subject('Reset Password')
               ->view('portal::mails.reset-password', [
                    'name' => $notifiable->name,
                    'url' => $url
               ]);
     }
}
