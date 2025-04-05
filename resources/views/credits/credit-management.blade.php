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
                                    <h6 class="font-weight-semibold text-lg mb-0">Credit List</h6>
                                    <p class="text-sm">See information about all Credit</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                                <div class="w-sm-30 ms-auto" style="height: 38px; padding: 0; margin: 0;">
                                    <!-- Search Form -->
                                    <form method="GET" action="" class="d-flex w-100">
                                        <span class="d-flex align-items-center" style="height: 38px; margin-right: 5px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                                            </svg>
                                        </span>
                                        <input type="text" name="search" class="form-control" placeholder="Search by number plate or owner" value="{{ request('search') }}" style="height: 38px; border-radius: 20px; padding: 5px 10px;">
                                        <a href="javascript:void(0)" onclick="this.closest('form').submit();" class="btn btn-warning btn-sm" style="height: 38px; display: flex; align-items: center; justify-content: center; border-radius: 20px; padding: 0 10px;">
                                            Search
                                        </a>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">#</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Number Plate</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Phone Number</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Owner Name</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Credit Amount</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($vehicles as $vehicle)
                                            <tr>
                                                <td class="text-center text-xs font-weight-bold">{{ $vehicles->firstItem() + $loop->index }}</td>
                                                <td class="text-center text-xs font-weight-bold">{{ $vehicle->number_plate }}</td>
                                                <td class="text-center text-xs font-weight-bold">{{ $vehicle->owner_phone }}</td>
                                                <td class="text-center text-xs font-weight-bold">{{ $vehicle->owner_name }}</td>
                                                <td class="text-center text-xs font-weight-bold">{{ number_format($vehicle->remaining_balance, 2) }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#payCreditModal"
                                                            data-vehicle-number="{{ $vehicle->number_plate }}"
                                                            data-owner-name="{{ $vehicle->owner_name }}"
                                                            data-remaining-balance="{{ $vehicle->remaining_balance }}"
                                                            style="margin: 0;">Pay Credit</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-xs font-weight-bold">No Credits found.</td>
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

    <!-- Modal for Pay Credit -->
    <div class="modal fade" id="payCreditModal" tabindex="-1" aria-labelledby="payCreditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="payCreditModalLabel">Pay Credit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="debitForm" action="{{ route('credits.pay') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="number_plate" id="vehicleNumberPlate">
                        <div class="mb-3">
                            <label for="vehicleNumberPlateLabel" class="form-label">Number Plate</label>
                            <input type="text" class="form-control" id="vehicleNumberPlateLabel" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="vehicleOwnerName" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" id="vehicleOwnerName" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="vehicleRemainingBalance" class="form-label">Remaining Balance</label>
                            <input type="text" class="form-control" id="vehicleRemainingBalance" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="debit_amount" class="form-label">Debit Amount</label>
                            <input type="number" class="form-control" id="debit_amount" name="debit_amount" required step="0.01">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveDebitButton">Save Debit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Trigger modal and populate number plate, owner name, and remaining balance
    var payCreditButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
    payCreditButtons.forEach(button => {
        button.addEventListener('click', function() {
            var vehicleNumber = this.getAttribute('data-vehicle-number');
            var ownerName = this.getAttribute('data-owner-name');
            var remainingBalance = this.getAttribute('data-remaining-balance');

            document.getElementById('vehicleNumberPlate').value = vehicleNumber;
            document.getElementById('vehicleNumberPlateLabel').value = vehicleNumber;
            document.getElementById('vehicleOwnerName').value = ownerName;
            document.getElementById('vehicleRemainingBalance').value = remainingBalance;
        });
    });

    // Add confirmation before submitting the form
    document.getElementById('debitForm').addEventListener('submit', function(e) {
        e.preventDefault();  // Prevent form submission

        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to record this debit transaction!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form
                this.submit();
            }
        });
    });
</script>
