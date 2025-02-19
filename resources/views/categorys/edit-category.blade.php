<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <form action="{{ route('category.update', $category->code) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mt-5 mb-5 mt-lg-9 row justify-content-center">
                    <div class="col-lg-9 col-12">
                        <div class="card card-body" id="profile">
                            <div class="row z-index-2 justify-content-center align-items-center">
                                <div class="col-sm-auto col-8 my-auto">
                                    <div class="h-100">
                                        <h5 class="mb-1 font-weight-bolder">
                                            Editing Category Code: {{ $category->code }}
                                        </h5>
                                        <p class="mb-0 font-weight-bold text-sm">
                                            Category: {{ $category->name}}
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
                                        <label for="code">Category Code</label>
                                        <input type="text" name="code" id="code"
                                            value="{{ old('code', $category->code) }}" class="form-control" readonly>
                                        @error('code')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-6">
                                        <label for="name">Category Name</label>
                                        <input type="text" name="name" id="name"
                                            value="{{ old('name', $category->name) }}" class="form-control" required>
                                        @error('name')
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
                                                <option value="{{ $code }}" {{ old('fuel_type_code', $category->fuel_type_code) == $code ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('fuel_type_code')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <div class="col-6">
                                        <label for="discount_price">Discount Price</label>
                                        <input type="text" name="discount_price" id="discount_price"
                                            value="{{ old('discount_price', $category->discount_price) }}" class="form-control" required>
                                        @error('discount_price')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>




                                <button type="submit" class="mt-6 mb-0 btn btn-white btn-sm float-end">
                                    Save changes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <x-app.footer />
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 CDN -->
    <script>
        @if (session('success'))
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                }).then(function() {
                    window.location.href = "{{ route('category-management') }}";
                });
            });
        @endif
    </script>



</x-app-layout>
