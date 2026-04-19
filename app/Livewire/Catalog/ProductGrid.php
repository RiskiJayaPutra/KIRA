<?php

namespace App\Livewire\Catalog;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Katalog Produk - Kira.com')]
class ProductGrid extends Component
{
    use WithPagination;

    public $search = '';
    public $category = 'all'; // all, blindbox, figure
    public $sort = 'newest'; // newest, price_low, price_high

    // Reset pagination when filters change
    public function updatedSearch() { $this->resetPage(); }
    public function updatedCategory() { $this->resetPage(); }
    public function updatedSort() { $this->resetPage(); }

    public function render()
    {
        $query = Product::with(['variants']);

        // 1. Filter Category
        if ($this->category === 'blindbox') {
            $query->where('is_blindbox', true);
        } elseif ($this->category === 'figure') {
            $query->where('is_blindbox', false);
        }

        // 2. Filter Search
        if (!empty($this->search)) {
            $query->where('name', 'ilike', '%' . $this->search . '%')
                  ->orWhere('description', 'ilike', '%' . $this->search . '%');
        }

        // 3. Sorting
        if ($this->sort === 'newest') {
            $query->orderBy('release_date', 'desc');
        } elseif ($this->sort === 'price_low' || $this->sort === 'price_high') {
            // Need to join variants to sort by base price
            // Using a subquery to get the minimum price of variants for each product
            $direction = $this->sort === 'price_low' ? 'asc' : 'desc';
            
            $query->select('products.*')
                  ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                  ->groupBy('products.id')
                  ->orderByRaw("MIN(product_variants.price) $direction");
        }

        $products = $query->paginate(9);

        return view('livewire.catalog.product-grid', [
            'products' => $products
        ]);
    }
}
