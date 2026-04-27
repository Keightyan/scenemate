<?php

namespace App\Mail;

use App\Models\Message;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewMessageReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Message $message,
        public Thread $thread,
        public User $recipient,
    ) {}

    public function envelope(): Envelope
    {
        $senderName = $this->message->sender->username ?? $this->message->sender->email;
        return new Envelope(subject: "[SceneMate] {$senderName} さんからメッセージが届きました");
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.new-message-received');
    }

    public function attachments(): array
    {
        return [];
    }
}
