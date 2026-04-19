<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class CatalogSearch extends Component
{
    // Reactive Property
    public $search = '';

    public function render()
    {
        // Simulasi O(log N) Instant Search tanpa reload halaman.
        // Memanfaatkan query ILIKE (Case-Insensitive Postgres) untuk mencari kecocokan parsial typo.
        $products = [];
        
        if (strlen($this->search) >= 2) {
            $products = Product::where('name', 'ilike', '%' . $this->search . '%')
                        ->orWhere('description', 'ilike', '%' . $this->search . '%')
                        ->with('variants')
                        ->limit(10) // Limit response untuk mereduksi latency (O(log N))
                        ->get();
        }

        return view('livewire.catalog-search', [
            'products' => $products
        ]);
    }
}
