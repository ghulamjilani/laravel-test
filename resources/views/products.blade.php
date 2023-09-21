<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Products</title>

    <style>
    .purchase-button {
        background-color: #007bff;
        color: #fff;
        border-radius: 5px;
        border: none;
        padding: 10px 20px;
    }

    .purchase-button:hover {
        background-color: #007bffa1
    }
    </style>

</head>

<body>
    <div class="container">
        <h1>Product List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>description</th>
                    <th>price</th>
                    <th>category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @foreach($products as $key => $value)
                <tr>
                    <td>{{ $value->title }}</td>
                    <td>{{ $value->description }}</td>
                    <td>{{ $value->price }}</td>
                    <td>{{ $value->category->name }}</td>
                    <td hidden>{{ $value->id }}</td>
                    <td><button class="purchase-button" type="button">Purchase</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Product Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="modal-details">
                    <!-- Details will be displayed here dynamically -->
                </div>
            </div>
        </div>
    </div>

    <script>
        var csrfToken = "{{ csrf_token() }}";

    document.addEventListener("DOMContentLoaded", () => {
        const tableBody = document.getElementById("table-body");
        const modal = document.getElementById("myModal");
        const modalDetails = document.getElementById("modal-details");

        // Add a click event listener to each "Purchase" button
        const purchaseButtons = document.querySelectorAll(".purchase-button");
        purchaseButtons.forEach((button) => {
            button.addEventListener("click", () => {
                // Fetch additional details from another API or use your own logic
                // Replace the following lines with your data fetching and modal content setup logic
                const productName = button.closest("tr").querySelector("td:first-child")
                    .textContent;
                const productDescription = button.closest("tr").querySelector("td:nth-child(2)")
                    .textContent;
                const productId = button.closest("tr").querySelector("td:nth-child(5)")
                    .textContent;
                const _token = csrfToken;
                // Construct the request body
                const requestBody = JSON.stringify({ productName, productDescription, productId, _token});

                var variableValue = "example_value";

                // Create the URL with the variable value
                var newUrl = "https://example.com/destination?request=" + variableValue;

                // Redirect to the new URL
                window.location.href = window.location.href = "{{ route('checkout') }}";
                fetch("{{ route('checkout') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json", // Change to match your API's content type
                    },
                    body: requestBody,
                })
                .then(response => response.json())
                .then(response => {
                    if (response.code == 200) {
                        alert("Login successful!");
                        window.location.href = "{{ route('products.list') }}";
                    } else {
                        console.log(data);
                        alert("Login failed. Please check your credentials.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again later."); // Handle other errors
                });

                // Example: Set the modal content with the product details
                // modalDetails.innerHTML = `
                //     <h2>Title: ${productName}</h2>
                //     <p>Description: ${productDescription}</p>
                //     <br>
                //     <form class="auth-purchase-form mt-2" action="{{ route('session') }}" method="POST" id="purchase-form">
                //         @csrf
                //         <label for="delivery_address">Delivery Address:</label>
                //         <input type="text" class="form-control" id="delivery_address" name="delivery_address" placeholder="Delivery Address" tabindex="1" autofocus required " />
                //         <br>
                //         <label for="delivery_contact_no">Delivery ContactNo:</label>
                //         <input type="text" class="form-control" id="delivery_contact_no" name="delivery_contact_no" placeholder="03001234567" tabindex="1" autofocus required />
                //         <br>
                //         <label for="purchase_quantity">Purchase Quantity:</label>
                //         <input type="text" class="form-control" id="purchase_quantity" name="purchase_quantity" placeholder="03001234567" tabindex="1" autofocus value="1" required/>
                //         <br>
                //         <input type="text" class="form-control" id="order_type" name="order_type" autofocus value="Stripe" hidden/>
                //         <input type="text" class="form-control" id="product_id" name="product_id" autofocus value="${productId}" hidden/>
                //         <br>
                //         <input clas="purchase-button" type="submit" value="Purchase">
                //     <form>
                // `;

                // Display the modal
                // $(modal).modal("show");
            });
        });


        // Close the modal when the close button or outside modal is clicked
        const closeButton = document.querySelector(".close");
        modal.addEventListener("click", (event) => {
            if (event.target === modal || event.target === closeButton) {
                $(modal).modal("hide");
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
            const purchaseForm = document.getElementById("purchase-form");

            purchaseForm.addEventListener("submit", function(event) {
                event.preventDefault(); // Prevent the default form submission

                const formElement = document.getElementById("purchase-form");
                const formData = new FormData(formElement);

                // Serialize form data into a query string
                const serializedData = new URLSearchParams(formData).toString();
                alert("response");

                // Make an API request to your server
                fetch("{{ route('order.store') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded", // Change to match your API's content type
                        },
                        body: serializedData,
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (response.code == 200) {
                            alert("response.message");
                        } else {
                            alert("Purchase failed. Please try.");
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert(
                        "An error occurred. Please try again later."); // Handle other errors
                    });
            });
        });
    </script>
</body>

</html>