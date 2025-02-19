<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg d-flex flex-column">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5 flex-grow-1">
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Members list</h6>
                                    <p class="text-sm">See information about all members</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2" onclick="window.location.href='{{ route('vehicles.create') }}'">
                                        <span class="btn-inner--icon">
                                            <!-- Icon goes here if needed -->
                                        </span>
                                        <span class="btn-inner--text">Add Vehicle</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                                <div class="w-sm-30 ms-auto" style="height: 38px; padding: 0; margin: 0;">
                                    <!-- Form with Search Input and Button -->
                                    <form method="GET" action="{{ route('vehicle-management') }}" class="d-flex w-100">
                                        <!-- Icon with proper vertical alignment -->
                                        <span class="d-flex align-items-center" style="height: 38px; margin-right: 5px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                                            </svg>
                                        </span>

                                        <!-- Search Input -->
                                        <input type="text" name="search" class="form-control" placeholder="Search by number plate or owner" value="{{ request('search') }}" style="height: 38px; border-radius: 20px; padding: 5px 10px;">

                                        <!-- Search Button -->
                                        <a href="javascript:void(0)" onclick="this.closest('form').submit();" class="btn btn-warning btn-sm" style="height: 38px; display: flex; align-items: center; justify-content: center; border-radius: 20px; padding: 0 10px;">
                                            Search
                                        </a>
                                    </form>
                                    <!-- End of Form -->
                                </div>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">#</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Number Plate</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Owner Name</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Fuel Type</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Created at</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($vehicles as $vehicle)
                                            <tr>
                                                <td class="text-center text-xs font-weight-bold">{{ $vehicles->firstItem() + $loop->index }}</td>
                                                <td class="text-center text-xs font-weight-bold">{{ $vehicle->number_plate }}</td>
                                                <td class="text-xs font-weight-bold">{{ $vehicle->owner_name }}</td>
                                                <td class="text-center text-xs font-weight-bold">{{ $vehicle->fuelType->name ?? 'N/A' }}</td>
                                                <td class="text-center text-xs font-weight-bold">{{ $vehicle->created_at->format('Y-m-d') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('vehicles.edit', $vehicle->number_plate) }}" class="btn btn-warning btn-sm" style="margin: 0;">Edit</a>
                                                    <a href="{{ route('vehicles.qr', $vehicle->id) }}"
                                                        download="QR_{{ $vehicle->number_plate }}.png"
                                                        class="btn btn-primary btn-sm" style="margin: 0;">
                                                         Download QR Code
                                                     </a>
                                                    <form action="{{ route('vehicles.destroy', $vehicle->number_plate) }}" method="POST" style="display:inline;" id="delete-form-{{ $vehicle->number_plate }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $vehicle->number_plate }}')" style="margin: 0;">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-xs font-weight-bold">No vehicles found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if ($vehicles->hasPages())
                                <div class="border-top py-3 px-3 d-flex align-items-center">
                                    <p class="font-weight-semibold mb-0 text-dark text-sm">
                                        Page {{ $vehicles->currentPage() }} of {{ $vehicles->lastPage() }}
                                    </p>
                                    <div class="ms-auto">
                                        @if ($vehicles->onFirstPage())
                                            <button class="btn btn-sm btn-white mb-0" disabled>Previous</button>
                                        @else
                                            <a href="{{ $vehicles->previousPageUrl() }}&search={{ request('search') }}" class="btn btn-sm btn-white mb-0">Previous</a>
                                        @endif

                                        @if ($vehicles->hasMorePages())
                                            <a href="{{ $vehicles->nextPageUrl() }}&search={{ request('search') }}" class="btn btn-sm btn-white mb-0">Next</a>
                                        @else
                                            <button class="btn btn-sm btn-white mb-0" disabled>Next</button>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-app.footer />
    </main>
</x-app-layout>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(vehicleNumberPlate) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This vehicle will be permanently deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + vehicleNumberPlate).submit();
            }
        });
    }
</script>
