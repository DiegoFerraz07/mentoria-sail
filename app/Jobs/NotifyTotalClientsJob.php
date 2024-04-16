<?php

namespace App\Jobs;

use App\Events\AlertTotalClienteEvent;
use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyTotalClientsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // get total clients and notify
        $totalClients = Client::count();
        // show in horizon
        echo $totalClients;
        AlertTotalClienteEvent::dispatch($totalClients);
    }
}
