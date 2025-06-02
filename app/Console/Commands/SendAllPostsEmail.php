<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Mail\AllPostsSummaryMail;
use Illuminate\Support\Facades\Mail;
use Log;

class SendAllPostsEmail extends Command
{
    protected $signature = 'email:send-all-posts';
    protected $description = 'Send all post details via email';

    public function handle()
    {
        $posts = Post::with('user')->latest()->get();
        // dd($posts);
        $recipientEmail = 'amanv@webmobtech.com';
        Mail::to($recipientEmail)->send(new AllPostsSummaryMail($posts));
        $this->info('All posts email sent successfully.');
    }
}
