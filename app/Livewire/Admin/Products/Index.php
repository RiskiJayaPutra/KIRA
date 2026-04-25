<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.admin')]
#[Title('Manajemen Katalog - Admin')]
class Index extends Component
{
    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }

    public function render()
    {
        $products = Product::withCount('variants')->latest()->get();
        
        return view('livewire.admin.products.index', [
            'products' => $products
        ]);
    }
}
