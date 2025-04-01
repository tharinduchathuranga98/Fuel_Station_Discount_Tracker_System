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
                                    <h6 class="font-weight-semibold text-lg mb-0">Refueling Record list</h6>
                                    <p class="text-sm">See information about all Refueling Records</p>
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
                                    <form method="GET" action="{{ route('refueling-management') }}" class="d-flex w-100">
                                        <!-- Icon with proper vertical alignment -->
                                        <span class="d-flex align-items-center" style="height: 38px; margin-right: 5px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                                            </svg>
                                        </span>

                                        <!-- Search Input -->
                                        <input type="text" name="search" class="form-control" placeholder="Search by number plate" value="{{ request('search') }}" style="height: 38px; border-radius: 20px; padding: 5px 10px;">

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
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Liters</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Fuel Type</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Price</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Discount</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Refueled at</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($refuelingRecords as $refuelingRecord)
                                            <tr>

                                                <td class="text-center text-xs font-weight-bold">{{ $refuelingRecords->firstItem() + $loop->index }}</td>
                                                <td class="text-center">{{ $refuelingRecord->number_plate }}</td>
                                                <td class="ps-2">{{ $refuelingRecord->liters }}</td>
                                                <td class="text-center">{{ $refuelingRecord->fuel_type_name }}</td>
                                                <td class="text-center">{{ $refuelingRecord->total_price }}</td>
                                                <td class="text-center">{{ $refuelingRecord->total_discount }}</td>
                                                <td class="text-center">{{ \Carbon\Carbon::parse($refuelingRecord->refueled_at)->format('d M, Y H:i') }}</td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-xs font-weight-bold">No refueling records found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if ($refuelingRecords->hasPages())
                                <div class="border-top py-3 px-3 d-flex align-items-center">
                                    <p class="font-weight-semibold mb-0 text-dark text-sm">
                                        Page {{ $refuelingRecords->currentPage() }} of {{ $refuelingRecords->lastPage() }}
                                    </p>
                                    <div class="ms-auto">
                                        @if ($refuelingRecords->onFirstPage())
                                            <button class="btn btn-sm btn-white mb-0" disabled>Previous</button>
                                        @else
                                            <a href="{{ $refuelingRecords->previousPageUrl() }}&search={{ request('search') }}" class="btn btn-sm btn-white mb-0">Previous</a>
                                        @endif

                                        @if ($refuelingRecords->hasMorePages())
                                            <a href="{{ $refuelingRecords->nextPageUrl() }}&search={{ request('search') }}" class="btn btn-sm btn-white mb-0">Next</a>
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
