<?php

namespace App\Jobs;

use App\Mail\UserNewProduct;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewProductJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Array $clients,
        protected Product $product
    )
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->clients as $client) {
            Mail::to($client['email'])
            ->send(new UserNewProduct($this->product->nome));
        }
    }
}
