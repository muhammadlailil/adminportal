<?php

namespace Laililmahfud\Adminportal\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Notifications\Messages\MailMessage;

class VerificationEmailNotification extends Notification
{
     use Queueable;

     /**
      * Create a new notification instance.
      */
     public function __construct()
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
               'admin.verification.verify',
               Carbon::now()->addHours(2),
               [
                    'uuid' => $notifiable->uuid,
                    'hash' => sha1($notifiable->email),
               ]
          );
          return (new MailMessage)
               ->subject('Verify Email Address')
               ->view('portal::mails.register-verification', [
                    'name' => $notifiable->name,
                    'url' => $url
               ]);
     }
}
