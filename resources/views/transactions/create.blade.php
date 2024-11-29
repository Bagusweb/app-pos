 @extends('admin.admin')
 @section('content')
 <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Form Create Transactions</h3>
            </div>
            
<form id="transaction-form" action="{{ route('transaction.store') }}" method="POST">
{{ csrf_field() }}

                <div class="card-body">
                            <!-- Pemilihan Customer -->
            <div class="form-group">
            <label>Customer (Opsional)</label>
            <select name="customer_id" id="customer_id" class="form-control">
                <option value="">Pilih Customer</option>
                @foreach ($customers as $value)
                <option value="{{ $value->customer_id }}" data-member="{{ $value->member_status }}">
                    {{$value->customer_name}} | {{ ($value->member_status == 1) ? 'Member' : 'Non-member'}}
                </option>
                @endforeach
            </select>
        </.>

        <!-- Pemilihan Metode Pembayaran -->
        <div class="form-group">
            <label for="payment_method">Metode Pembayaran</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="">Pilih Metode Pembayaran</option>
                <option value="cash">Tunai</option>
                <option value="credit_card">Kartu Kredit</option>
                <option value="transfer">Transfer Bank</option>
            </select>
            <p class="text-danger">{{ $errors->first('payment_method') }}</p>
        </div>

        <!-- Pemilihan Produk -->
        <div class="form-group">
            <label for="product_id">Produk</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="">Pilih Produk</option>
                @foreach ($products as $product)
                <option value="{{ $product->product_id }}" data-price="{{ $product->price }}"
                    data-image="{{ ($product->photo) ? asset('storage/' . $product->photo) : "
                    https://via.placeholder.com/100" }}">
                    {{ $product->product_name }} - Rp. {{ number_format($product->price, 2) }}
                </option>
                @endforeach
            </select>
            <p class="text-danger">{{ $errors->first('product_id') }}</p>
            <button type="button" id="add-product" class="btn btn-primary mt-2">Tambah Item</button>
        </div>

        <!-- Tabel Produk yang Ditambahkan -->
        <table class="table table-striped table-hover mt-3" id="product-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data produk yang ditambahkan akan muncul di sini -->
            </tbody>
        </table>

        <div class="form-group">
            <label for="total_amount">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" readonly>
        </div>


        <div class="form-group">
            <label for="discount">Diskon (Rp)</label>
            <input type="number" name="discount" id="discount" class="form-control" value="0" readonly>
        </div>

        <div class="form-group" id="total_due_field">
            <label for="total_due">Total yang Harus Dibayar</label>
            <input type="number" name="total_due" id="total_due" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="payment">Pembayaran</label>
            <input type="number" name="payment" id="payment" class="form-control" required>
            <p class="text-danger">{{ $errors->first('payment') }}</p>
        </div>

        <div class="form-group">
            <label for="change">Kembalian</label>
            <input type="number" name="change" id="change" class="form-control" readonly>
        </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Simpan Transaksi</button>
                    <a href="{{ route('transaction.index') }}" class="btn btn-secondary">Batal</a>
                </div>
        </div>
    </div>
    </div>
 </div>
 @endsection

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            let productList = [];
            let discountPercent = 10; // Diskon 10% untuk member
            let isMember = false;
            
            // Cek apakah customer yang dipilih adalah member
            $('#customer_id').on('change', function () {
                const selectedCustomer = $(this).find('option:selected');
                isMember = selectedCustomer.data('member') == 1; // Cek apakah customer adalah member
            
                calculateTotal(); // Recalculate total after selecting customer
            });
            
            // Tambah item produk ke tabel
            $('#add-product').on('click', function () {
                const productId = $('#product_id').val();
                const productName = $('#product_id option:selected').text();
                const productPrice = parseFloat($('#product_id option:selected').data('price'));
                const productImage = $('#product_id option:selected').data('image');
                const productQty = 1; // Mengatur jumlah produk default 1
            
                if (productId) {
                    // Cek apakah produk sudah ada di dalam list
                    const existingProduct = productList.find(p => p.id == productId);
                    if (existingProduct) {
                        // Jika produk sudah ada, tambahkan kuantitas dan perbarui total
                        existingProduct.qty++;
                    } else {
                        // Jika produk baru, tambahkan ke list
                        productList.push({
                        id: productId,
                        name: productName,
                        price: productPrice,
                        qty: productQty,
                        image: productImage });
                    }
                    
                    // Perbarui tabel produk
                    updateProductTable();
                    calculateTotal();
                }
            });
            
            // Fungsi untuk memperbarui tabel produk
            function updateProductTable() {
                const tbody = $('#product-table tbody');
                tbody.empty(); // Hapus isi tabel sebelum diperbarui
            
                productList.forEach((product, index) => {
                    const total = product.price * product.qty;
                    const photoUrl = product.image ? product.image : 'https://via.placeholder.com/100';
                    tbody.append(`
                    <tr>
                        <td><img src="${photoUrl}" alt="${product.name}" style="width: 50px; height: auto;"></td>
                        <td>${product.name}</td>
                        <td>Rp. ${product.price.toFixed(2)}</td>
                        <td>
                            <button class="btn btn-sm btn-secondary decrease" data-id="${product.id}">-</button>
                            ${product.qty}
                            <button class="btn btn-sm btn-secondary increase" data-id="${product.id}">+</button>
                        </td>
                        <td>Rp. ${total.toFixed(2)}</td>
                        <td>
                            <button class="btn btn-danger btn-sm remove" data-id="${product.id}">Hapus</button>
                        </td>
                    </tr>
                    <input type="hidden" name="products[${index}][product_id]" value="${product.id}">
                    <input type="hidden" name="products[${index}][qty]" value="${product.qty}">
                    `);
                });
            }
            
            // Hitung total amount
            function calculateTotal() {
                const total = productList.reduce((sum, product) => sum + (product.price * product.qty), 0);
                $('#total_amount').val(total);
                
                // Hitung diskon jika customer adalah member
                let discount = isMember ? (total * discountPercent / 100) : 0;
                $('#discount').val(discount);
                
                const totalDue = total - discount;
                $('#total_due').val(totalDue);
                
                if (discount > 0) {
                    $('#total_due_field').show(); // Menampilkan field jika ada diskon
                } else {
                    $('#total_due_field').hide(); // Menyembunyikan field jika tidak ada diskon
                }
                
                calculateChange(); // Recalculate change after updating total
            }
            
            // Hitung kembalian
            $('#payment').on('input', calculateChange);
            
            function calculateChange() {
                const total = parseFloat($('#total_amount').val());
                const totalDue = parseFloat($('#total_due').val());
                const payment = parseFloat($('#payment').val());
                const discount = parseFloat($('#discount').val()) || 0;
                const totalAfterDiscount = total - discount;
                const change = payment - totalAfterDiscount;
                console.log(totalAfterDiscount);
                console.log(payment);
            
                $('#change').val(change < 0 ? 0 : change); 
            } 
            // Event untuk mengurangi dan menambah kuantitas produk // Event untuk menampilkan alert setelah selesai menginput pembayaran 
            $('#payment').on('blur', function() { 
                const total=parseFloat($('#total_amount').val()); 
                const discount=parseFloat($('#discount').val()) || 0; 
                const totalDue=total - discount; 
                const payment=parseFloat($('#payment').val()); // Tampilkan alert jika pembayaran kurang dari total yang harus dibayar 
                
                if (payment < totalDue) { 
                    alert("Pembayaran tidak boleh kurang dari total yang harus dibayar!"); 
                } 
            }); 
            
            $(document).on('click', '.increase' , function () { 
                const productId=$(this).data('id'); 
                const product=productList.find(p=> p.id == productId);
                
                if (product) {
                    product.qty++;
                    updateProductTable();
                    calculateTotal();
                }
            });
            
            $(document).on('click', '.decrease', function () {
                const productId = $(this).data('id');
                const product = productList.find(p => p.id == productId);
                if (product && product.qty > 1) {
                    product.qty--;
                    updateProductTable();
                    calculateTotal();
                }
            });
            
            function resetPaymentAndChange() {
                $('#payment').val(''); // Kosongkan input pembayaran
                $('#change').val(''); // Kosongkan input kembalian
            }
        
            // Event untuk menghapus produk dari tabel
            $(document).on('click', '.remove', function () {
                const productId = $(this).data('id');
                productList = productList.filter(p => p.id != productId);
                updateProductTable();
                calculateTotal();
                resetPaymentAndChange();
            });
        });
    </script>