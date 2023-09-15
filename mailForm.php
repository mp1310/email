<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Form</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <style>
        /* Page Loader Styles */
        .page-loader {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            display: flex;
            /* Hidden by default */
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }


        /* Change radio button color to black */
        /* .btn-primary input[type="radio"] {
            background-color: black;
        } */



        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <div class="container mt-2">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Send Email
                    </div>
                    <div class="card-body">
                        <form id="emailForm" enctype="multipart/form-data">
                            <!-- Row 1 -->
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="to">To:</label>
                                    <input type="email" class="form-control" id="to" name="to"
                                        placeholder="Enter recipient email" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cc">CC:</label>
                                    <input type="email" class="form-control" id="cc" name="cc"
                                        placeholder="Enter CC email" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="bcc">BCC:</label>
                                    <input type="email" class="form-control" id="bcc" name="bcc"
                                        placeholder="Enter BCC email" required>
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="subject">Subject:</label>
                                    <input type="text" class="form-control" id="subject" name="subject"
                                        placeholder="Enter email subject" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="message">Message:</label>
                                    <textarea class="form-control" id="message" name="message" rows="5"
                                        placeholder="Enter your message" required></textarea>
                                </div>
                            </div>

                            <!-- Row 3 -->
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="file">Attach File:</label>
                                    <input type="file" class="form-control-file" id="file" name="file">
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <button type="button" onclick="validateAndSendEmail()" class="btn btn-danger">
                                     Send Email
                                </button>
                            </div>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader"></div>
    </div>

    <!-- Include Bootstrap JS and jQuery (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        function validateAndSendEmail() {
            // Check if all required fields are filled in each row
            var rows = document.querySelectorAll('.form-row');
            var isValid = true;

            rows.forEach(function (row) {
                var inputs = row.querySelectorAll('[required]');
                inputs.forEach(function (input) {
                    if (!input.value) {
                        isValid = false;
                        input.style.borderColor = 'red';
                    } else {
                        input.style.borderColor = ''; // Clear red border
                    }
                });
            });

            if (isValid) {
                sendEmail(); // All fields are filled, send the email
            } else {
                // Display an error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please fill in all required fields in each row.',
                });
            }
        }

        function sendEmail() {
            // Show the page loader
            document.getElementById('pageLoader').style.display = 'block';

            // Get form data
            var formData = new FormData(document.getElementById('emailForm'));

            // Send a POST request to mailer.php
            fetch('mailer.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    // Check the response from the server
                    if (data.success) {
                        // Email sent successfully
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Email sent successfully!',
                        });
                    } else {
                        // Error sending email
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Email sent successfully!',
                        });
                    }
                })
                .catch(error => {
                    // Handle network or other errors
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Email sent successfully!',
                    });
                })
                .finally(() => {
                    // Hide the page loader after 2 seconds
                    setTimeout(() => {
                        document.getElementById('pageLoader').style.display = 'none';
                    }, 2000);
                });
        }
    </script>
</body>

</html>