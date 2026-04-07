<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification implements ShouldQueue //this is for the email ShouldQueue on the notification class, Laravel automatically Wraps the email notification in a job behind the scenes and throw it to the Queue — you don't need to manually create one with make:job.
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Comment $comment)
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Someone commented on your post!')
            ->line('Dear '.$this->comment->post->user->name)
            ->line('You have new comment by '. $this->comment->user->name .' on your post with title "'. $this->comment->post->title.'".')
            ->line('Please if you noticed any harmful content do not hesitate to report to us.')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
        'comment_id'   => $this->comment->id,
        'comment_body' => $this->comment->body,
        'commenter'    => $this->comment->user->name,
        'post_id'      => $this->comment->post->id,
        'post_title'   => $this->comment->post->title,
    ];
    }
}

// toDatabase method
// This method defines what gets saved in the data column of the notifications table when someone comments on a post.
// So when User B comments on User A's post, Laravel takes this array and saves it as JSON in the database like this:
// json{
//     "comment_id": 3,
//     "comment_body": "Great post!",
//     "commenter": "Ahmed",
//     "post_id": 7,
//     "post_title": "My first post"
// }

// Why do we save all this data?
// Because later when User A opens the bell icon, you want to show something like:

// Ahmed commented on your post "My first post"
// "Great post!"

// All the info needed to display that message is already stored in the data column — you don't need to do any extra database queries to show the notification.

// What about $notifiable?
// That's the user who receives the notification (User A). You don't need it here since all the data comes from the comment itself, but it's available if you need it — for example $notifiable->name would give you User A's name.