document.addEventListener('DOMContentLoaded', function () {
    const Transaction = {
        showProduct() {
            document.querySelector('#product_id').addEventListener('change', function (e) {
                var id = $(this).val();
                console.log(id);
            });
        }
    };

    // Panggil fungsi showProduct
    Transaction.showProduct();
});
