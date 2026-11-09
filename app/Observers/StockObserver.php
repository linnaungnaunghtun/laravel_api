<?php

namespace App\Observers;

use App\Models\Stock;

class StockObserver
{
    /**
     * Handle the Stock "created" event.
     */
    public function created(Stock $stock): void
    {
        $product = $stock->product;
        $sizes = $product->sizes;
        $uniqueSizes = $sizes->pluck('size')->unique()->toArray();
        $product->available_size = count($uniqueSizes) ? "." . join(".", $uniqueSizes) . "." : null;
        $product->stocks_count = $sizes->count();
        $product->save();
    }

    /**
     * Handle the Stock "updated" event.
     */
    public function updated(Stock $stock): void
    {
        //
    }

    /**
     * Handle the Stock "deleted" event.
     */
    public function deleted(Stock $stock): void
    {
        $product = $stock->product;
        $sizes = $product->sizes;
        $uniqueSizes = $sizes->pluck('size')->unique()->toArray();
        $product->available_size = count($uniqueSizes) ? "." . join(".", $uniqueSizes) . "." : null;
        $product->stocks_count = $sizes->count();
        $product->save();
    }

    /**
     * Handle the Stock "restored" event.
     */
    public function restored(Stock $stock): void {}

    /**
     * Handle the Stock "force deleted" event.
     */
    public function forceDeleted(Stock $stock): void {}
}
