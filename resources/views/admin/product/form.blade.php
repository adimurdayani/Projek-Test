<x-forms.input-grid col1="2" col2="6" label="Nama Produk" name="product_name"
    value="{{ $product->product_name ?? '' }}" placeholder="Masukan nama produk..."></x-forms.input-grid>

<x-forms.textarea-grid col1="2" col2="6" label="Deskripsi" name="product_description"
    placeholder="Masukan deskripsi." value="{{ $product->product_description ?? '' }}">
</x-forms.textarea-grid>

<x-forms.input-grid col1="2" col2="6" label="Stok" name="product_price_capital"
    value="{{ $product->product_price_capital ?? '' }}" type="number"
    placeholder="Masukan stok produk..."></x-forms.input-grid>

<x-forms.input-grid col1="2" col2="6" label="Harga" type="number" name="product_price_sell"
    value="{{ $product->product_price_sell ?? '' }}" placeholder="Masukan harga produk..."></x-forms.input-grid>
