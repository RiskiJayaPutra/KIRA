<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.admin')]
#[Title('Edit Produk - Admin')]
class Edit extends Component
{
    public Product $product;
    
    public $name = '';
    public $slug = '';
    public $description = '';
    public $is_blindbox = false;
    public $image_url = '';

    public $variants = [];

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->is_blindbox = $product->is_blindbox;
        $this->image_url = $product->image_url;

        foreach ($product->variants as $v) {
            $this->variants[] = [
                'id' => $v->id,
                'variant_name' => $v->variant_name,
                'price' => $v->price,
                'stock' => $v->stock,
                'drop_rate' => $v->drop_rate,
                'image_url' => $v->image_url,
            ];
        }

        if (count($this->variants) == 0) {
            $this->addVariant();
        }
    }

    public function updatedName()
    {
        // Slug hanya berubah jika diedit manual, tapi kita bantu buat defaultnya
        // $this->slug = Str::slug($this->name); 
    }

    public function addVariant()
    {
        $this->variants[] = [
            'id' => null,
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
            // Jika punya ID (sudah ada di DB), biarkan di DB, tapi kita keluarkan dari UI
            // Untuk MVP, kita abaikan penghapusan permanen varian demi integritas pesanan
            unset($this->variants[$index]);
            $this->variants = array_values($this->variants);
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,'.$this->product->id,
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
            $this->product->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'is_blindbox' => $this->is_blindbox,
                'image_url' => $this->image_url,
            ]);

            // Track ID varian yang disubmit
            $submittedVariantIds = [];

            foreach ($this->variants as $variant) {
                if (isset($variant['id']) && $variant['id']) {
                    // Update varian yang ada
                    ProductVariant::where('id', $variant['id'])->update([
                        'variant_name' => $variant['variant_name'],
                        'price' => $variant['price'],
                        'stock' => $variant['stock'],
                        'drop_rate' => $this->is_blindbox ? $variant['drop_rate'] : null,
                        'image_url' => $variant['image_url'],
                    ]);
                    $submittedVariantIds[] = $variant['id'];
                } else {
                    // Buat varian baru
                    $newVariant = $this->product->variants()->create([
                        'variant_name' => $variant['variant_name'],
                        'price' => $variant['price'],
                        'stock' => $variant['stock'],
                        'drop_rate' => $this->is_blindbox ? $variant['drop_rate'] : null,
                        'image_url' => $variant['image_url'],
                    ]);
                    $submittedVariantIds[] = $newVariant->id;
                }
            }
            
            // Catatan: Varian yang dihilangkan dari form tidak akan dihapus dari DB (demi integritas data order)
            // Namun idealnya mereka diberi flag `is_active = false` di fase lanjutan.
        });

        session()->flash('success', 'Produk berhasil diperbarui.');
        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        return view('livewire.admin.products.edit');
    }
}
