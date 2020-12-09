<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateInfluencerJobState extends Notification
{
    use Queueable;

    /**
     * Job details
     * 
     * @var array
     */
    private $details;

    /**
     * Create a new notification instance.
     *
     * @param array $details
     * @return void
     */
    public function __construct(array $details)
    {
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'data'  =>  isset($this->details['influencer_id']) ? "Influencer @{$this->details['username']} added successfully." : "Failed to add influencer @{$this->details['username']}"
        ];
    }
}
