<?php

namespace App\Mail;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Report $report) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: '[SceneMate] ユーザー通報が届きました');
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.report-received');
    }

    public function attachments(): array
    {
        return [];
    }
}
