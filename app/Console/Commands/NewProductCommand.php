<?php

namespace App\Console\Commands;

use App\Jobs\NewProductJob;
use App\Models\Product;
use Illuminate\Console\Command;

class NewProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:new-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia email para todos clientes que foi cadastrado um novo produto';

    
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //NewProductJob::dispatch($this->clients, $this->product);
    }
}
