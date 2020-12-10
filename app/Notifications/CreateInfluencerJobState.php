<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CreateInfluencerJobState extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    /**
     * User
     * 
     * @var \App\User
     */
    private $user;
    
    /**
     * Username
     * 
     * @var string
     */
    private $username;
    
    /**
     * Influencer
     * 
     * @var \App\Influencer
     */
    private $influencer;

    /**
     * Create a new notification instance.
     *
     * @param \App\User $user
     * @param string $username
     * @param \App\Influencer|null $influencer
     * @return void
     */
    public function __construct(User $user, string $username, Influencer $influencer = null)
    {
        $this->user = $user;
        $this->username = $username;
        $this->influencer = $influencer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
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
            'data'  =>  !is_null($this->influencer) ? "Influencer @{$this->influencer->username} added successfully." : "Failed to add influencer @{$this->username}"
        ];
    }

    /**
     * Get the broadcast representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toBroadcast($notifiable)
    {
        return [
            'data'  =>  [
                'message'       =>  !is_null($this->influencer) ? "Influencer @{$this->influencer->username} added successfully." : "Failed to add influencer @{$this->username}",
                'user'          =>  $this->user,
                'influencer'    =>  $this->influencer
            ]
        ];
    }
}
