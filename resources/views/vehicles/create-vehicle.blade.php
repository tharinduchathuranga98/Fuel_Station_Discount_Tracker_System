<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <form action="{{ route('vehicles.store') }}" method="POST" id="vehicleForm">
                @csrf
                <div class="mt-5 mb-5 mt-lg-9 row justify-content-center">
                    <div class="col-lg-9 col-12">
                        <div class="card card-body" id="profile">
                            <div class="row z-index-2 justify-content-center align-items-center">
                                <div class="col-sm-auto col-8 my-auto">
                                    <div class="h-100">
                                        <h5 class="mb-1 font-weight-bolder">
                                            Add New Customer
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
                                <h5>Vehicle Information</h5>
                            </div>
                            <div class="pt-0 card-body">

                                <div class="row">
                                    <div class="col-6">
                                        <label for="number_plate">Number Plate</label>
                                        <input type="text" name="number_plate" id="number_plate"
                                             class="form-control" required>
                                        @error('number_plate')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-6">
                                        <label for="owner_name">Owner Name</label>
                                        <input type="text" name="owner_name" id="owner_name"
                                             class="form-control" required>
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
                                                <option value="{{ $code }}" {{ old('fuel_type') == $code ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('fuel_type')
                                            <span class="text-danger text-sm" style="display: inline-block; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 8px 12px; border-radius: 5px; font-size: 0.875rem; margin-top: 5px;">
                                                <i class="fa fa-exclamation-circle" style="margin-right: 5px;"></i> {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Category Dropdown -->
                                    <div class="col-6" id="category-container">
                                        <label for="category">Category</label>
                                        <select name="category" id="category" class="form-control select2">
                                            <option value="" disabled>Select Category</option>
                                            @foreach($categories as $code => $name)
                                                <option value="{{ $code }}" {{ old('category') == $code ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                            <span class="text-danger text-sm" style="display: inline-block; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 8px 12px; border-radius: 5px; font-size: 0.875rem; margin-top: 5px;">
                                                <i class="fa fa-exclamation-circle" style="margin-right: 5px;"></i> {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="row">
                                    <!-- Owner Phone Input -->
                                    <div class="col-6">
                                        <label for="owner_phone">Contact Number</label>
                                        <input type="text" name="owner_phone" id="owner_phone"

                                            class="form-control" maxlength="9"
                                            pattern="[0-9]{9}" title="Enter exactly 9 digits">

                                        <span style="display: inline-block; background-color: #e2e3e5; color: #383d41; border: 1px solid #c6c8ca; padding: 8px 12px; border-radius: 5px; font-size: 0.875rem; margin-top: 5px; width: fit-content;">
                                            Enter 9 digits (without 94)
                                        </span>

                                        @error('owner_phone')
                                            <span class="text-danger text-sm" style="display: inline-block; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 8px 12px; border-radius: 5px; font-size: 0.875rem; margin-top: 5px;">
                                                <i class="fa fa-exclamation-circle" style="margin-right: 5px;"></i> {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" name="company_name" id="company_name"

                                            class="form-control"
                                            >



                                        @error('owner_phone')
                                            <span class="text-danger text-sm" style="display: inline-block; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 8px 12px; border-radius: 5px; font-size: 0.875rem; margin-top: 5px;">
                                                <i class="fa fa-exclamation-circle" style="margin-right: 5px;"></i> {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row">
                                    <!-- Owner Phone Input -->
                                    <div class="col-6">
                                        <label for="status">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="credit">Credit User</option>
                                            <option value="debit">Debit User</option>
                                        </select>
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
            $('#vehicleForm').submit(function(e) {
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
                            text: 'Vehicle registered successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // window.location.href = '/vehicles'; // Redirect after success
                            window.location.href = "{{ route('vehicle-management') }}";

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
