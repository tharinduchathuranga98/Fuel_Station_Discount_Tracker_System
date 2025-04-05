<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <form action="{{ route('refueling-report') }}" method="POST">
                @csrf
                <div class="mt-5 mb-5 mt-lg-9 row justify-content-center">
                    <div class="col-lg-9 col-12">
                        <div class="card card-body" id="profile">
                            <div class="row z-index-2 justify-content-center align-items-center">
                                <div class="col-sm-auto col-8 my-auto">
                                    <div class="h-100">
                                        <h5 class="mb-1 font-weight-bolder">Generate Refueling Report</h5>
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
                    <div class="col-lg-9 col-12">
                        <div class="card" id="basic-info">
                            <div class="card-header">
                                <h5>Report Information</h5>
                            </div>
                            <div class="pt-0 card-body">
                                <div class="row">
                                    <!-- Month Input -->
                                    <div class="col-6">
                                        <label for="month">Select Month (for Monthly Report)</label>
                                        <input type="month" name="month" id="month" class="form-control" value="{{ request('month') }}" required>
                                        @error('month')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Owner Name Input -->
                                    <div class="col-6">
                                        <label for="owner_name">Owner Name</label>
                                        <input type="text" name="owner_name" id="owner_name" class="form-control" value="{{ request('owner_name') }}">
                                        @error('owner_name')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Company Name Input -->
                                    <div class="col-6">
                                        <label for="company_name">Company Name</label>
                                        <input type="text" name="company_name" id="company_name" class="form-control" value="{{ request('company_name') }}">
                                        @error('company_name')
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="mt-6 mb-0 btn btn-white btn-sm float-end">Generate Report</button>
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
    <script>
        $(document).ready(function() {
            // Initialize Select2 for the select dropdowns
            $('.select2').select2();
        });
    </script>
</x-app-layout>
