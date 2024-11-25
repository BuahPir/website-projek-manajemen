<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskActivityAdded extends Notification implements ShouldQueue
{
    use Queueable;

    public $activity;

    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    public function via($notifiable)
    {
        return ['database']; // Send notification via database
    }

    public function toDatabase($notifiable)
    {
        return [
            'task_id' => $this->activity->task_id,
            'activity_name' => $this->activity->activity_name,
            'description' => $this->activity->description,
            'activity_date' => $this->activity->activity_date,
            'file_path' => $this->activity->file_path,
        ];
    }
}
