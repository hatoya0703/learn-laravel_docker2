<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class ContactAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    // app/Http/Controllers/ContactController.phpの
    // Mail::to(users: 'user@example.com')->send(new ContactAdminMail($validated_request));
    // で渡された$validated_requestを受け取る
    public function __construct(public array $contactInfo)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Addressクラスのインスタンスを使用することで差出人も指定できる
            from: new Address($this->contactInfo['email'], $this->contactInfo['name']),
            subject: 'お問い合わせがありました',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            // view: 'view.name',
            text: 'email.contact.admin', // resources/views/email/contact/admin.blade.php
        );
    }

    // 添付ファイルをつける場合は以下を使用
    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}
