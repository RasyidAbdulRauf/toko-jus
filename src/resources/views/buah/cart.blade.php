@extends('buah.index')
@section('content')

<!-- Modal Search Start -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content rounded-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex align-items-center">
                <div class="input-group w-75 mx-auto d-flex">
                    <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                    <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Search End -->


<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Cart</h1>
</div>
<!-- Single Page Header End -->

{{-- alert success --}}
<div class="col-9">
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                $('.alert').fadeOut('fast');
            }, 3000); // 3 seconds
        </script>
    @endif
</div>

<!-- Cart Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="table-responsive">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Produk</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>
                    <th scope="col">Handle</th>
                  </tr>
                </thead>
                <tbody>
                    <div class="col-9">
                        @if(session('success-delete'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                            <script>
                                setTimeout(function() {
                                    $('.alert').fadeOut('fast');
                                }, 3000); // 3 seconds
                            </script>
                        @endif
                    </div>

                    @php $total = 0 @endphp
                    @if(session('cart'))
                        @foreach(session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                            <tr>
                                <th scope="row">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $details['image'] }}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{ $details['name'] }}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4">Rp. {{ $details['price'] }} </p>
                                </td>
                                <td>
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border" data-action="decrement">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm text-center border-0 quantity quantity-input" value="{{ $details['quantity'] }}" data-id="{{ $id }}" data-price="{{ $details['price'] }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border" data-action="increment">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 total-price" data-id="{{ $id }}">Rp. {{ number_format($details['price'] * $details['quantity'], 3)}}</p>
                                </td>
                                <td>
                                    <button class="btn btn-md rounded-circle bg-light border mt-4 delete-cart" data-id="{{ $id }}" class="action">
                                        <i class="fa fa-times text-danger delete-cart"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="mt-5">
            <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Coupon Code">
            <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Apply Coupon</button>
        </div>
        <div class="row g-4 justify-content-end">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Subtotal:</h5>
                            <p class="mb-0">$96.00</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0 me-4">Shipping</h5>
                            <div class="">
                                <p class="mb-0">Flat rate: $3.00</p>
                            </div>
                        </div>
                        <p class="mb-0 text-end">Shipping to Ukraine.</p>
                    </div>
                    <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                        <h5 class="mb-0 ps-4 me-4">Total</h5>
                        <p class="mb-0 pe-4">$99.00</p>
                    </div>
                    <button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button">Proceed Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart Page End -->
@endsection

@section('scripts')
<script type="text/javascript">
    $(".quantity").change(function() {
        var id = $(this).data("id"); // Ensure this matches the data attribute in the input element
        var quantity = $(this).val();
        $.ajax({
            type: "PATCH",
            url: "{{ route('update.cart') }}",
            data: {
                id: id,
                quantity: quantity,
                _token: '{{ csrf_token() }}' // Include CSRF token
            },
            success: function(response) {
                console.log(response.success); // Log success message
                location.reload(); // Consider dynamically updating the cart instead of reloading
            },
            error: function(response) {
                alert('Error updating cart'); // Handle error
            }
        });
    });

    $(".delete-cart").click(function() {
        var id = $(this).data("id");
            $.ajax({
                type: "DELETE",
                url: "/delete-cart/" + id, // Adjusted to concatenate the id dynamically
                data: {
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function() {
                    window.location.reload();
                },
                // error: function() {
                //     alert("Error deleting the product from cart.");
                // }
            });
    });

    // update total price
    document.addEventListener('DOMContentLoaded', function () {
        // Function to update the total price
        function updateTotalPrice(inputElement) {
            const productId = inputElement.dataset.id;
            const pricePerItem = parseFloat(inputElement.dataset.price);
            const quantity = parseInt(inputElement.value);
            const totalPriceElement = document.querySelector(`.total-price[data-id="${productId}"]`);
            const newTotalPrice = pricePerItem * quantity;
            totalPriceElement.innerText = `Rp. ${newTotalPrice.toFixed(3)}`;

            // Update cart count
            let totalQuantity = 0;
            document.querySelectorAll('.quantity-input').forEach(input => {
                totalQuantity += parseInt(input.value);
            });
            document.getElementById('cart-count').innerText = totalQuantity;
        }


        // Event listeners for plus and minus buttons
        document.querySelectorAll('.btn-plus, .btn-minus').forEach(button => {
            button.addEventListener('click', function () {
                const inputGroup = this.closest('.input-group');
                const quantityInput = inputGroup.querySelector('.quantity-input');
                let quantity = parseInt(quantityInput.value);
                if (this.classList.contains('btn-plus')) {
                    quantity+1;
                } else if (this.classList.contains('btn-minus') && quantity > 1) {
                    quantity-1;
                }
                quantityInput.value = quantity;
                updateTotalPrice(quantityInput);
            });
        });

        // Event listener for manual input changes
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', function () {
                updateTotalPrice(this);
            });
        });
    });


</script>
@endsection
