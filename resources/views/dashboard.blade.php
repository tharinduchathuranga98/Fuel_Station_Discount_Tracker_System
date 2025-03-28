<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-md-flex align-items-center mb-3 mx-2">
                        <div class="mb-md-0 mb-3">
                            <h3 class="font-weight-bold mb-0">Hello, </h3>
                            <p class="mb-0">Apps you might like!</p>
                        </div>

                    </div>
                </div>
            </div>
            <hr class="my-0">


            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-body text-start p-3 w-100">
                            <div
                                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M4.5 3.75a3 3 0 00-3 3v.75h21v-.75a3 3 0 00-3-3h-15z" />
                                    <path fill-rule="evenodd"
                                        d="M22.5 9.75h-21v7.5a3 3 0 003 3h15a3 3 0 003-3v-7.5zm-18 3.75a.75.75 0 01.75-.75h6a.75.75 0 010 1.5h-6a.75.75 0 01-.75-.75zm.75 2.25a.75.75 0 000 1.5h3a.75.75 0 000-1.5h-3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="w-100">
                                        <p class="text-sm text-secondary mb-1">Total Sale</p>
                                        <h4 id="total-sale" class="mb-2 font-weight-bold">0.00</h4>
                                        <div class="d-flex align-items-center">
                                            <span class="text-sm text-success font-weight-bolder"id="date">
                                                date
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-body text-start p-3 w-100">
                            <div
                                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M7.5 5.25a3 3 0 013-3h3a3 3 0 013 3v.205c.933.085 1.857.197 2.774.334 1.454.218 2.476 1.483 2.476 2.917v3.033c0 1.211-.734 2.352-1.936 2.752A24.726 24.726 0 0112 15.75c-2.73 0-5.357-.442-7.814-1.259-1.202-.4-1.936-1.541-1.936-2.752V8.706c0-1.434 1.022-2.7 2.476-2.917A48.814 48.814 0 017.5 5.455V5.25zm7.5 0v.09a49.488 49.488 0 00-6 0v-.09a1.5 1.5 0 011.5-1.5h3a1.5 1.5 0 011.5 1.5zm-3 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M3 18.4v-2.796a4.3 4.3 0 00.713.31A26.226 26.226 0 0012 17.25c2.892 0 5.68-.468 8.287-1.335.252-.084.49-.189.713-.311V18.4c0 1.452-1.047 2.728-2.523 2.923-2.12.282-4.282.427-6.477.427a49.19 49.19 0 01-6.477-.427C4.047 21.128 3 19.852 3 18.4z" />
                                </svg>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="w-100">
                                        <p class="text-sm text-secondary mb-1">Discounts Given</p>
                                        <h4 id="total-discount" class="mb-2 font-weight-bold">$0.00</h4>
                                        <div class="d-flex align-items-center">
                                            <span class="text-sm text-success font-weight-bolder"id="date1">
                                                date
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="fuel-types-container">
                    <!-- Fuel Type Cards will be inserted here dynamically -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-xs border">
                        <div class="card-header pb-0">
                            <div class="d-sm-flex align-items-center mb-3">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Monthly Sale</h6>
                                    <p class="text-sm mb-sm-0 mb-2">Here you have Monthly Sales.</p>
                                </div>
                                <div class="ms-auto d-flex">
                                    <button type="button" class="btn btn-sm btn-white mb-0 me-2">
                                        View report
                                    </button>
                                </div>
                            </div>
                            <div class="d-sm-flex align-items-center">
                                <h3 class="mb-0 font-weight-semibold" id="total-sale1"></h3>

                            </div>
                            <div class="d-sm-flex align-items-center">
                                <p class="text-sm text-secondary mb-1">Discount</p>
                            </div>
                            <div class="d-sm-flex align-items-center">
                                <h5 class="mb-2 font-weight-bold" id="total-discount1"></h5>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="chart mt-n6">
                                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-app.footer />
        </div>
    </main>

</x-app-layout>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
        function updateData() {
            $.ajax({
                url: "/refueling/daily-report", // Your Laravel API route
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.report) {
                        // Update the total sale value (with Rs currency symbol)
                        let totalSales = parseFloat(response.report.total_sales).toFixed(
                        2); // Ensure two decimal places
                        $("#total-sale").text(`Rs ${totalSales}`);

                        // Update the total discount value (with Rs currency symbol)
                        let totalDiscount = parseFloat(response.report.total_discount || 0).toFixed(
                            2);
                        $("#total-discount").text(`Rs ${totalDiscount}`);

                        // Update the date (assuming the date is already in a string format like "2025-03-28")
                        let date = response.report.date ||
                        "No date available"; // Handle case if date is missing
                        $("#date").text(date); // Display the date directly as text
                        $("#date1").text(date);
                    }
                    if (response.report && response.report.fuel_types) {
                        // Clear previous fuel type cards before inserting new ones
                        $('#fuel-types-container').empty();

                        // Iterate through each available fuel type
                        response.report.fuel_types.forEach(function(fuelType) {
                            // Ensure the data is a number and apply toFixed
                            let totalSales = parseFloat(fuelType.total_sales).toFixed(2);
                            let totalDiscount = parseFloat(fuelType.total_discount).toFixed(
                                2);
                            let totalLiters = parseFloat(fuelType.total_liters).toFixed(2);

                            // Only display if the fuel type data is available
                            if (!isNaN(totalSales) && !isNaN(totalDiscount) && !isNaN(
                                    totalLiters)) {
                                // Create a dynamic fuel type card
                                let fuelTypeCard = `
                            <div class="col-xl-3 col-sm-6 mb-xl-0">
                                <div class="card border shadow-xs mb-4">
                                    <div class="card-body text-start p-3 w-100">
                                        <div class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 00-3 3v4.318a3 3 0 00.879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 005.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.58a3 3 0 00-2.121-.879V2.25zM8.618 12.05l9.58 9.58c.586.585 1.532.4 1.818-.268 1.006-2.016 1.017-4.345-.062-6.367a7.502 7.502 0 00-5.276-3.23l-1.53 4.735c-.345 1.037-.77 1.249-1.81.674z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="w-100">
                                                    <p class="text-sm text-secondary mb-1">${fuelType.fuel_type} Sales</p>
                                                    <h4 class="mb-2 font-weight-bold">${totalSales} Rs</h4>
                                                    <p class="text-sm text-secondary mb-1">Discount</p>
                                                    <h5 class="mb-2 font-weight-bold">${totalDiscount} Rs</h5>
                                                    <div class="d-flex align-items-center">
                                                        <span class="text-sm text-success font-weight-bolder">
                                                            Total Liters: ${totalLiters} L
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;

                                // Insert the dynamically created card into the container
                                $('#fuel-types-container').append(fuelTypeCard);
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching fuel types:", error);
                }
            });
        }

        // Initial data fetch
        updateData();

        // Update data every 10 seconds
        setInterval(updateData, 10000); // Adjust time as needed (10000ms = 10 seconds)
    });

    $(document).ready(function() {
        function updateData() {
            $.ajax({
                url: "/refueling/monthly-report", // Your Laravel API route
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.report) {
                        // Update the total sale value (with Rs currency symbol)
                        let totalSales = parseFloat(response.report.total_sales).toFixed(
                        2); // Ensure two decimal places
                        $("#total-sale1").text(`Rs ${totalSales}`);

                        // Update the total discount value (with Rs currency symbol)
                        let totalDiscount = parseFloat(response.report.total_discount || 0).toFixed(
                            2);
                        $("#total-discount1").text(`Rs ${totalDiscount}`);

                    }

                },
                error: function(xhr, status, error) {
                    console.error("Error fetching fuel types:", error);
                }
            });
        }

        // Initial data fetch
        updateData();

        // Update data every 10 seconds
        setInterval(updateData, 10000); // Adjust time as needed (10000ms = 10 seconds)
    });
</script>
