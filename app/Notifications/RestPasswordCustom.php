<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RestPasswordCustom extends Notification
{
    /**
     * The password reset token.
     * @var string
    */
    public $token;


    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    // ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    // ->line('Thank you for using our application!')
                    ->from('nihongo.typing@example.com', config('app.name'))
                    ->subject('パスワード再設定')
                    ->line('上のボタンをクリックしてパスワードを再設定してください。')
                    ->action('パスワード再設定', url(config('app.url').route('password.reset', $this->token, false)))
                    ->line('もし心当たりがない場合は、本メッセージは破棄してください。');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
