<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SFMailableReply extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $content;

    public function __construct($name, $email, $content)
    {
        $this->name = $name;
        $this->email = $email;
        $this->content = $content;
    }

    public function build()
    {
        $Subject = $this->name . ' quiere contactarte';

        return $this->view('emails.reply-template', [
                            'name' => $this->name,
                            'email' => $this->email,
                            'content' => $this->content,
                           ])
                    ->subject($Subject);
    }
}
