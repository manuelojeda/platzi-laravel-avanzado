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
    protected $signature = 'send:newsletter
                            {emails?*} : Correos electrónicos
                            {--s|schedule} : Si debe ser ejecutado directamente o no';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia un correo electrónico';

    public function handle()
    {
        $emails = $this->arguments()['emails'];
        $schedule = $this->arguments()['schedule'];
        
        $builder = User::query();

        if (count($emails) > 0) {
            $builder->whereIn('email', $emails);
        }

        $count = $builder->count();        

        if ($count) {
            $this->info("Se enviaran {$count} emails");
            
            
            if ($this->confirm('¿Estás seguro?') || $schedule) {
                $this->output->progressStart($count);
                
                $builder->whereNotNull('email_verified_at')
                ->each(function (User $user) {
                    $user->notify(new NewsletterNotification());
                    $this->output->progressAdvance();
                });
    
            }
            $this->output->progressFinish();
            $this->info('Mails enviados');
            return;
        }
        
        $this->info('No se enviaron mails');
    }
}
