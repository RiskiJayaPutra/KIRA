<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.admin')]
#[Title('Tambah Produk - Admin')]
class Create extends Component
{
    public $name = '';
    public $slug = '';
    public $description = '';
    public $is_blindbox = false;
    public $image_url = '';

    public $variants = [];

    public function mount()
    {
        $this->addVariant();
    }

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function addVariant()
    {
        $this->variants[] = [
            'variant_name' => '',
            'price' => 0,
            'stock' => 0,
            'drop_rate' => null,
            'image_url' => '',
        ];
    }

    public function removeVariant($index)
    {
        if (count($this->variants) > 1) {
            unset($this->variants[$index]);
            $this->variants = array_values($this->variants);
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug|max:255',
            'description' => 'required|string',
            'is_blindbox' => 'boolean',
            'image_url' => 'nullable|url',
            'variants' => 'required|array|min:1',
            'variants.*.variant_name' => 'required|string|max:255',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.drop_rate' => 'nullable|numeric|min:0|max:100',
            'variants.*.image_url' => 'nullable|url',
        ]);

        DB::transaction(function () {
            $product = Product::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'is_blindbox' => $this->is_blindbox,
                'image_url' => $this->image_url,
            ]);

            foreach ($this->variants as $variant) {
                $product->variants()->create([
                    'variant_name' => $variant['variant_name'],
                    'price' => $variant['price'],
                    'stock' => $variant['stock'],
                    'drop_rate' => $this->is_blindbox ? $variant['drop_rate'] : null,
                    'image_url' => $variant['image_url'],
                ]);
            }
        });

        session()->flash('success', 'Produk berhasil dicetak ke pangkalan data.');
        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        return view('livewire.admin.products.create');
    }
}
