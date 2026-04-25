<div>
    <div class="mb-8">
        <h2 class="text-4xl font-black text-headline uppercase tracking-tighter" style="-webkit-text-stroke: 1px #272343;">PENCAIRAN AFILIASI</h2>
        <p class="text-xl font-bold text-paragraph">Stasiun persetujuan aliran dana (Payouts).</p>
    </div>

    <div class="bg-secondary border-4 border-stroke p-6 shadow-[8px_8px_0px_0px_rgba(39,35,67,1)] overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-headline text-background">
                    <th class="p-4 border-4 border-stroke font-black uppercase">ID</th>
                    <th class="p-4 border-4 border-stroke font-black uppercase">Afiliator</th>
                    <th class="p-4 border-4 border-stroke font-black uppercase text-right">Nominal (Rp)</th>
                    <th class="p-4 border-4 border-stroke font-black uppercase">Detail Bank / Dompet</th>
                    <th class="p-4 border-4 border-stroke font-black uppercase text-center">Status</th>
                    <th class="p-4 border-4 border-stroke font-black uppercase text-center">Aksi (Manual Transfer)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payouts as $payout)
                    <tr class="bg-background hover:bg-tertiary transition-colors group">
                        <td class="p-4 border-4 border-stroke font-bold">#WD-{{ str_pad($payout->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="p-4 border-4 border-stroke">
                            <p class="font-black uppercase">{{ $payout->user->name }}</p>
                            <p class="text-xs font-bold">{{ $payout->user->email }}</p>
                        </td>
                        <td class="p-4 border-4 border-stroke font-black text-right text-button-fomo" style="-webkit-text-stroke: 1px #272343;">
                            {{ number_format($payout->amount, 0, ',', '.') }}
                        </td>
                        <td class="p-4 border-4 border-stroke font-bold text-sm max-w-[250px]">
                            {{ $payout->bank_details }}
                        </td>
                        <td class="p-4 border-4 border-stroke text-center">
                            @php
                                $statusColor = match($payout->status) {
                                    'PENDING' => 'bg-button-fomo text-headline',
                                    'APPROVED' => 'bg-green-400 text-headline',
                                    'REJECTED' => 'bg-red-500 text-background',
                                    default => 'bg-background text-headline'
                                };
                            @endphp
                            <span class="{{ $statusColor }} font-black px-3 py-1 border-2 border-stroke uppercase text-xs shadow-[2px_2px_0px_0px_#272343]">
                                {{ $payout->status }}
                            </span>
                        </td>
                        <td class="p-4 border-4 border-stroke text-center">
                            @if($payout->status === 'PENDING')
                                <div class="flex justify-center gap-2">
                                    <button wire:click="approve({{ $payout->id }})" wire:confirm="Pastikan Anda sudah mentransfer Rp {{ number_format($payout->amount, 0, ',', '.') }} ke rekening pengguna sebelum menyetujui. Lanjutkan?" class="bg-green-400 text-headline p-2 border-2 border-stroke hover:bg-headline hover:text-green-400 transition-colors" title="Setujui & Tandai Lunas">
                                        <x-heroicon-o-check class="w-5 h-5" />
                                    </button>
                                    <button wire:click="reject({{ $payout->id }})" wire:confirm="Tolak penarikan dan kembalikan saldo ke dompet pengguna?" class="bg-red-500 text-background p-2 border-2 border-stroke hover:bg-headline transition-colors" title="Tolak">
                                        <x-heroicon-o-x-mark class="w-5 h-5" />
                                    </button>
                                </div>
                            @else
                                <span class="text-xs font-bold opacity-50 uppercase">Terkunci</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 border-4 border-stroke text-center font-bold text-xl opacity-50">Tidak ada antrean penarikan dana.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
