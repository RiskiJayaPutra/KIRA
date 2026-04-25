<?php

namespace App\Livewire\Catalog;

use Livewire\Component;
use App\Models\ProductReview;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class ProductReviews extends Component
{
    public $productId;
    public $rating = 5;
    public $comment = '';
    public $hasReviewed = false;

    public function mount($productId)
    {
        $this->productId = $productId;
        
        if (Auth::check()) {
            $this->hasReviewed = ProductReview::where('product_id', $this->productId)
                                              ->where('user_id', Auth::id())
                                              ->exists();
        }
    }

    public function setRating($value)
    {
        $this->rating = $value;
    }

    public function saveReview()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ], [
            'rating.required' => 'Rating bintang wajib diisi.',
            'comment.max' => 'Komentar terlalu panjang. Maksimal 1000 karakter.'
        ]);

        if ($this->hasReviewed) {
            return;
        }

        // Cek apakah user pernah membeli produk ini
        $isVerifiedBuyer = OrderItem::whereHas('order', function ($query) {
                                        $query->where('user_id', Auth::id())
                                              ->where('status', '!=', 'PENDING'); // Minimal sudah bayar
                                    })
                                    ->whereHas('variant', function ($query) {
                                        $query->where('product_id', $this->productId);
                                    })
                                    ->exists();

        ProductReview::create([
            'product_id' => $this->productId,
            'user_id' => Auth::id(),
            'rating' => $this->rating,
            'comment' => $this->comment,
            'is_verified_buyer' => $isVerifiedBuyer,
        ]);

        $this->hasReviewed = true;
        $this->comment = '';
        $this->rating = 5;
        
        // Memaksa render ulang
        $this->dispatch('review-added');
    }

    public function render()
    {
        $reviews = ProductReview::with('user')
                                ->where('product_id', $this->productId)
                                ->latest()
                                ->get();
                                
        $averageRating = $reviews->count() > 0 ? round($reviews->avg('rating'), 1) : 0;

        return view('livewire.catalog.product-reviews', [
            'reviews' => $reviews,
            'averageRating' => $averageRating
        ]);
    }
}
