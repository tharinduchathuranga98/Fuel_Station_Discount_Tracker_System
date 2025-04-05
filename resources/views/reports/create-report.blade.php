<!-- resources/views/reports/create-report.blade.php -->
<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="mt-5 mb-4 mt-lg-6 row justify-content-center">
                <div class="col-lg-9 col-12">
                    <div class="card card-body" id="profile">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-sm-auto col-10 my-auto">
                                <div class="h-100 text-center">
                                    <h4 class="mb-1 font-weight-bolder">Refueling Report Generator</h4>
                                    <p class="text-muted">Select a month to generate your refueling report</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-5 row justify-content-center">
                <div class="col-lg-9 col-12">
                    <div class="card" id="basic-info">
                        <div class="card-header">
                            <h5><i class="fas fa-calendar-alt me-2"></i>Select Reporting Period</h5>
                        </div>

                        <div class="card-body pt-4 pb-4">
                            <!-- Form to select month -->
                            <form action="{{ route('report-month') }}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <label for="month" class="form-label fw-bold">Select Month</label>
                                        <input type="month" id="month" name="month"
                                            class="form-control form-control-lg" value="{{ date('Y-m') }}" required>
                                        <div class="form-text">Choose the month and year for your report</div>
                                    </div>

                                    <div class="col-6">
                                        <label for="report_type" class="form-label fw-bold">Report Type</label>
                                        <select id="report_type" name="report_type" class="form-select form-select-lg">
                                            <option value="summary" selected>Summary Report</option>
                                            <option value="detailed">Detailed Report</option>
                                            {{-- <option value="cost">Cost Analysis</option> --}}
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-4 d-flex justify-content-between align-items-center">
                                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-file-alt me-2"></i>Generate Report
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-app.footer />
    </main>
</x-app-layout>
