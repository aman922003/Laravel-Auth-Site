<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\User;
use App\Mail\AllPostsSummaryMail;
use Illuminate\Support\Facades\Mail;

class SendAllPostsEmail extends Command
{
    protected $signature = 'email:send-all-posts';
    protected $description = 'Send all post details via email';

    public function handle()
    {
        $posts = Post::with('user')->latest()->get();
        $recipient = User::inRandomOrder()->first(); 
        if (!$recipient) {
            $this->error('No users found in the database.');
            return;
        }
        Mail::to($recipient->email)->send(new AllPostsSummaryMail($posts));
        $this->info('All posts email sent successfully to ' . $recipient->email);
    }
}
