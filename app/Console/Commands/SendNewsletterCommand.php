<?php

namespace App\Console\Commands;

use App\Notifications\NewsletterNotification;
use App\User;
use Illuminate\Console\Command;

class SendNewsletterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:newsletter {emails?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia un correo electrónico';

    public function handle()
    {
        $emails = $this->arguments()['emails'];
        
        $builder = User::query();

        if (count($emails) > 0) {
            $builder->whereIn('email', $emails);
        }

        $count = $builder->count();        

        if ($count) {
            $this->output->progressStart($count);

            $builder->whereNotNull('email_verified_at')
            ->each(function (User $user) {
                $user->notify(new NewsletterNotification());
                $this->output->progressAdvance();
            });

            $this->info("Se enviaron {$count} emails");
            $this->output->progressFinish();
        } else {
            $this->info('No se enviaron mails');
        }
    }
}
