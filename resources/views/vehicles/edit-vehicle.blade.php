<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <form action="{{ route('vehicles.update', $vehicle->number_plate) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mt-5 mb-5 mt-lg-9 row justify-content-center">
                    <div class="col-lg-9 col-12">
                        <div class="card card-body" id="profile">
                            <div class="row z-index-2 justify-content-center align-items-center">
                                <div class="col-sm-auto col-8 my-auto">
                                    <div class="h-100">
                                        <h5 class="mb-1 font-weight-bolder">
                                            Editing Vehicle: {{ $vehicle->number_plate }}
                                        </h5>
                                        <p class="mb-0 font-weight-bold text-sm">
                                            Owner: {{ $vehicle->owner_name }}
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
                                <h5>Vehicle Information</h5>
                            </div>
                            <div class="pt-0 card-body">

                                <div class="row">
                                    <div class="col-6">
                                        <label for="number_plate">Number Plate</label>
                                        <input type="text" name="number_plate" id="number_plate"
                                            value="{{ old('number_plate', $vehicle->number_plate) }}" class="form-control" readonly>
                                        @error('number_plate')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-6">
                                        <label for="owner_name">Owner Name</label>
                                        <input type="text" name="owner_name" id="owner_name"
                                            value="{{ old('owner_name', $vehicle->owner_name) }}" class="form-control" required>
                                        @error('owner_name')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Fuel Type Dropdown -->
                                    <div class="col-6">
                                        <label for="fuel_type">Fuel Type</label>
                                        <select name="fuel_type" id="fuel_type" class="form-control select2">
                                            <option value="" disabled>Select Fuel Type</option>
                                            @foreach($fuelTypes as $code => $name)
                                                <option value="{{ $code }}" {{ old('fuel_type', $vehicle->fuel_type) == $code ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('fuel_type')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Category Dropdown -->
                                    <div class="col-6" id="category-container">
                                        <label for="category">Category</label>
                                        <select name="category" id="category" class="form-control select2">
                                            <option value="" disabled>Select Category</option>
                                            @foreach($categories as $code => $name)
                                                <option value="{{ $code }}" {{ old('category', $vehicle->category) == $code ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Owner Phone Input -->
                                    <div class="col-6">
                                        <label for="owner_phone">Contact Number</label>
                                        <input type="text" name="owner_phone" id="owner_phone"
                                            value="{{ old('owner_phone', substr($vehicle->owner_phone, 2)) }}"
                                            class="form-control" maxlength="9"
                                            pattern="[0-9]{9}" title="Enter exactly 9 digits">
                                        <span class="d-block mt-1" style="font-size: 0.875rem; color: #6c757d;">
                                            Enter 9 digits (without 94)
                                        </span>
                                        @error('owner_phone')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-6">
                                        <label for="created_at">Created At</label>
                                        <input type="text" name="created_at" id="created_at"
                                               value="{{ old('created_at', $vehicle->created_at) }}"
                                               class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="mt-3 row">
                                    <div class="col text-center">
                                        <label>Vehicle QR Code</label>
                                        <br>
                                        <img src="{{ route('vehicles.qr', $vehicle->id) }}"
                                             alt="QR Code" class="img-fluid w-25">
                                        <br>
                                        <a href="{{ route('vehicles.qr', $vehicle->id) }}"
                                           download="QR_{{ $vehicle->number_plate }}.png"
                                           class="mt-2 btn btn-primary btn-sm">
                                            Download QR Code
                                        </a>
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
                    window.location.href = "{{ route('vehicle-management') }}";
                });
            });
        @endif
    </script>

    <script>
        $(document).ready(function() {
        // Initialize select2 for both dropdowns on page load
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });

        // Handle fuel type change to dynamically update categories
        $('#fuel_type').change(function() {
            let fuelTypeCode = $(this).val();
            let categoryDropdown = $('#category');
            let categoryContainer = $('#category-container');

            // If no fuel type is selected, hide category dropdown
            if (!fuelTypeCode) {
                categoryContainer.hide();
                return;
            }

            // Show the category dropdown if a fuel type is selected
            categoryContainer.show();

            // Trigger AJAX to fetch categories based on selected fuel type
            $.ajax({
                url: '{{ route("getCategoriesByFuelType") }}',
                type: 'GET',
                data: { fuel_type_code: fuelTypeCode },
                success: function(response) {
                    console.log("Categories received:", response); // Debugging line

                    // Clear the category dropdown and add the default option
                    categoryDropdown.empty().append('<option value="" disabled>Select Category</option>');

                    // Loop through the response object and populate the category dropdown
                    $.each(response, function(code, name) {
                        categoryDropdown.append(`<option value="${code}" ${code == "{{ old('category') }}" ? 'selected' : ''}>${name}</option>`);
                    });

                    // Destroy the select2 instance before re-initializing
                    categoryDropdown.select2('destroy');

                    // Re-initialize select2 after updating the dropdown
                    categoryDropdown.select2({
                        placeholder: "Select Category",
                        allowClear: true
                    });

                    // Trigger 'change' event on the dropdown to update the selection
                    categoryDropdown.trigger('change');
                },
                error: function(xhr) {
                    console.error("Error fetching categories:", xhr.responseText);
                }
            });
        });

        // Trigger AJAX immediately if fuel type is already selected (on page load)
        let selectedFuelType = $('#fuel_type').val();
        if (selectedFuelType) {
            $('#fuel_type').change(); // Trigger change event to populate the category dropdown
        }
    });

    $(document).ready(function() {
        // Hide select2 containers initially
        setTimeout(function() {
            $('#fuel_type').next('.select2-container').hide();
            $('#category').next('.select2-container').hide();
        }, 500); // Adjust the delay time if needed

        // Hide select2 container for fuel type when the dropdown is opening or closing
        $('#fuel_type').on('select2:opening', function() {
            $(this).next('.select2-container').hide();
        });

        $('#fuel_type').on('select2:closing', function() {
            $(this).next('.select2-container').hide();
        });

        // Similarly hide the select2 container for category
        $('#category').on('select2:opening', function() {
            $(this).next('.select2-container').hide();
        });

        $('#category').on('select2:closing', function() {
            $(this).next('.select2-container').hide();
        });

        // Prevent category select2 from reappearing after changing fuel type
        $('#fuel_type').on('change', function() {
            // Ensure category select2 container stays hidden when fuel type changes
            $('#category').next('.select2-container').hide();
        });

        // Optionally, you can add this for the category field too, to handle its reappearance in case of other interactions
        $('#category').on('change', function() {
            $(this).next('.select2-container').hide();
        });
    });
    </script>

</x-app-layout>
