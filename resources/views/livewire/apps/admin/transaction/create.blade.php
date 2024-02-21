<div>
    <form action="{{ route('app.transaction.store') }}" method="post">
        @csrf
        <div class="row align-items-center my-2">
            <div class="col-md-2">
                <label>Pilih Produk</label>
            </div>
            <div class="col-md-6">
                <select name="product_id" class="form-control @error('product_id') is-invalid @enderror" id="product_id">
                    <option value="">Pilih</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->product_name }} -
                            {{ number_format($product->product_price_sell, 0) }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success">Tambah</button>
            </div>
        </div>
    </form>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <table class="table table-striped table-hover w-100 mt-4">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">qty</th>
                <th scope="col">Harga/Qty</th>
                <th scope="col" style="width: 200px;">Total</th>
                <th scope="col" style="width: 10px;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ optional($transaction->product)->product_name }}</td>
                    <td>
                        <div class="d-inline-block">
                            <div class="input-group mb-3">
                                @if ($transaction->qty > 1)
                                    <div class="input-group-prepend">
                                        <span class="btn btn-outline-secondary"
                                            wire:click="kurangQty({{ $transaction->id }})" id="button-addon1">-</span>
                                    </div>
                                @endif
                                <input type="text" class="form-control" value="{{ $transaction->qty }}" readonly>
                                <div class="input-group-prepend">
                                    <span class="btn btn-outline-secondary"
                                        wire:click="tambahQty({{ $transaction->id }})" id="button-addon2">+</span>
                                </div>
                            </div>

                        </div>
                    </td>
                    <td>Rp. {{ $transaction->total }}</td>
                    <td>Rp. {{ $transaction->product->product_price_sell * $transaction->qty }}</td>
                    <td>
                        @php
                            $button = '';
                            $button .= form_delete("formTransaction$transaction->id", \route('app.transaction.destroy', $transaction->id));
                        @endphp
                        {!! $button !!}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align:right;">Total Pembelian</td>
            <td>
                Rp {{ number_format($transactions->sum('total')) }}
            </td>
            <tr>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="text-align:right;">Pembayaran</td>
                <td style="text-align:right;">
                    <input type="number" wire:model="pembayaran"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '0');" min="1"
                        value="{{ $pembayaran ?? 0 }}" class="form-control">
                </td>
            </tr>
            <tr>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="border:none;"></td>
                <td style="text-align:right;">Kembalian</td>
                <td style="text-align:left;">
                    Rp {{ number_format((int) $pembayaran - $transactions->sum('total'), 0) }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="mt-3">
        <button type="button" wire:click="simpan" class="btn btn-success">Simpan</button>
    </div>
</div>
