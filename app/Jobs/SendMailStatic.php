<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMailStatic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($data)
    {
        $results = app('MailHelper')->setFrom(config('mail.from.name'))
            ->setContent(view('mail_templates.' . $data['type'], $data['data'] ?? [])->render())
            ->setFromEmail()
            ->setEmail($data['email'])
            ->setSubject($data['title'])
            ->setBcc(isset($data['bcc']) && is_array($data['bcc']) ? $data['bcc'] : [])
            ->setCc(isset($data['cc']) && is_array($data['cc']) ? $data['cc'] : [])
            ->setReplyTo()
            ->send();
        file_put_contents('log_send_mail.txt', json_encode($results).PHP_EOL, FILE_APPEND);
    }
}