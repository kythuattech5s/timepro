<?php

namespace Roniejisa\Comment\Jobs;

use Roniejisa\Comment\Models\News;
use Roniejisa\Comment\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BuildDataRatingForProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle($table, $id)
    {
        switch ($table) {
            case 'products':
                $product = Product::with('ratings')->find($id);
                $product->info_rating = $product->getRating('add');
                $product->save();
                break;
            case 'news':
                $product = News::with('ratings')->find($id);
                $product->info_rating = $product->getRating('add');
                $product->save();

        }
    }
}
