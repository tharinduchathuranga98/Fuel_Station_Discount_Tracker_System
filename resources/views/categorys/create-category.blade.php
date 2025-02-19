<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <form action="{{ route('category.store') }}" method="POST" id="categoryForm">
                @csrf
                <div class="mt-5 mb-5 mt-lg-9 row justify-content-center">
                    <div class="col-lg-9 col-12">
                        <div class="card card-body" id="profile">
                            <div class="row z-index-2 justify-content-center align-items-center">
                                <div class="col-sm-auto col-8 my-auto">
                                    <div class="h-100">
                                        <h5 class="mb-1 font-weight-bolder">
                                            Add New Category
                                        </h5>
                                        <p class="mb-0 font-weight-bold text-sm">

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                <div class="row justify-content-center">
                    <div class="col-lg-9 col-12">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert" id="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success" role="alert" id="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-5 row justify-content-center">
                    <div class="col-lg-9 col-12 ">
                        <div class="card" id="basic-info">
                            <div class="card-header">
                                <h5>Category Information</h5>
                            </div>
                            <div class="pt-0 card-body">

                                <div class="row">
                                    <div class="col-6">
                                        <label for="name">Category Name</label>
                                        <input type="text" name="name" id="name"
                                             class="form-control" required>
                                        @error('name')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-6">
                                        <label for="discount_price">Discount Price</label>
                                        <input type="text" name="discount_price" id="discount_price"
                                             class="form-control" required>
                                        @error('discount_price')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Fuel Type Dropdown -->
                                    <div class="col-6">
                                        <label for="fuel_type_code">Fuel Type</label>
                                        <select name="fuel_type_code" id="fuel_type_code" class="form-control select2">
                                            <option value="" disabled>Select Fuel Type</option>
                                            @foreach($fuelTypes as $code => $name)
                                                <option value="{{ $code }}" {{ old('fuel_type_code') == $code ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('fuel_type_code')
                                            <span class="text-danger text-sm" style="display: inline-block; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 8px 12px; border-radius: 5px; font-size: 0.875rem; margin-top: 5px;">
                                                <i class="fa fa-exclamation-circle" style="margin-right: 5px;"></i> {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="mt-6 mb-0 btn btn-white btn-sm float-end">
                                    Register
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div id="errorModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div id="errorMessage"></div>
                </div>
            </div>
        </div>
        <x-app.footer />
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 CDN -->
    {{-- <script>
        @if (session('success'))
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                }).then(function() {
                    // Redirect only after the user clicks 'OK' on the SweetAlert
                    window.location.href = "{{ route('vehicle-management') }}";
                });
            });
        @endif
    </script> --}}

<script>
            $(document).ready(function() {
            $('#categoryForm').submit(function(e) {
                e.preventDefault(); // Prevent normal form submission

                var formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    url: $(this).attr('action'), // Form action URL
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Show success message
                        Swal.fire({
                            title: 'Success!',
                            text: 'Category registered successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // window.location.href = '/vehicles'; // Redirect after success
                            window.location.href = "{{ route('category-management') }}";

                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 400) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';

                            for (var field in errors) {
                                errorMessage += `• ${errors[field].join('<br>')}<br>`;
                            }

                            // Show error message using SweetAlert2
                            Swal.fire({
                                title: 'Validation Error!',
                                html: errorMessage, // Use HTML to format multiple errors
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
</script>

</x-app-layout>
