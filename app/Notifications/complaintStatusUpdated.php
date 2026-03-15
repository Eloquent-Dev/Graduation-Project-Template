<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class complaintStatusUpdated extends Notification
{
    use Queueable;

    public $complaint;

    /**
     * Create a new notification instance.
     */
    public function __construct($complaint)
    {
        $this->complaint = $complaint;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $formattedStatus = ucwords(str_replace('_',' ',$this->complaint->status));

        $icon = match($this->complaint->status){
            'under_review' => 'magnifying-glass',
            'in_progress' => 'person-digging',
            'resolved' => 'check-double',
            'closed' => 'folder-close',
            default => 'bell'
        };

        return [
            'complaint_id' => $this->complaint->id,
            'title' => 'Status Update',
            'message' => 'your complaint ('.$this->complaint->title .') has been updated to: '. $formattedStatus.'.',
            'url' => '/my-complaints/'. $this->complaint->id,
            'icon' => $icon
        ];
    }
}
