<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class WishlistPage extends Component
{
    public function removeWishlist($wishlistId)
    {
        Wishlist::where('id', $wishlistId)->where('user_id', Auth::id())->delete();
    }

    public function render()
    {
        $wishlists = Wishlist::with(['variant', 'variant.product'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('livewire.profile.wishlist-page', [
            'wishlists' => $wishlists
        ])->title('Wishlist - Kira.com');
    }
}
