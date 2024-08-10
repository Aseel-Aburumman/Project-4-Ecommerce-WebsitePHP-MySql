<?php
require 'connection.php';


$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];
    echo $email;
    echo 'hi';
    $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $success = true;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .AS_popup {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .AS_popup-content {
            background-color: #fefefe;
            margin: 7% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            text-align: center;
            border-radius: 10px;
        }

        .AS_close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .AS_close-btn:hover,
        .AS_close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .AS_popup-body img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .AS_popup-body h2 {
            color: #1E90FF;
            margin-bottom: 20px;

        }

        .AS_popup-body p {
            color: #0055a7;
            margin-bottom: 20px;
        }

        .AS_done-btn {
            background-color: #1E90FF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .AS_done-btn:hover {
            background-color: #104E8B;
        }
    </style>
</head>

<body>
    <footer>
        <div class="container">
            <div class="row align-items-center newsletter-area">
                <div class="col-lg-5">
                    <div class="newsletter-area-text">
                        <h4 class="text-white">Subscribe to get notification.</h4>
                        <p>
                            Receive our weekly newsletter.
                            For dietary content, fashion insider and the best offers.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="newsletter-area-button">
                        <form id="newsletter-form" method="POST">
                            <div class="form">
                                <input type="email" name="email" id="mail" placeholder="Enter your email address" class="form-control" required>
                                <button type="submit" class="btn bg-secondary border text-capitalize">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright d-flex justify-content-between align-items-center">
                        <div class="copyright-text order-2 order-lg-1">
                            <p>&copy; 2024. All rights reserved. </p>
                        </div>
                        <div class="copyright-links order-1 order-lg-2">
                            <a href="soon.php" class="ml-0"><i class="fab fa-facebook-f"></i></a>
                            <a href="soon.php"><i class="fab fa-twitter"></i></a>
                            <a href="soon.php"><i class="fab fa-youtube"></i></a>
                            <a href="soon.php"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Popup Modal -->
    <div id="thankyouModal" class="AS_popup">
        <div class="AS_popup-content">
            <span class="AS_close-btn">&times;</span>
            <div class="AS_popup-body">
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/newsletter-4828216-4019450.png" alt="Paper Airplane" class="AS_popup-image" />
                <h2>Thank You!</h2>
                <p>
                    We appreciate your interest.
                    <br />Your subscription has been confirmed, and you will now receive
                    the latest fashion tips, sales, and exclusive coupons directly
                    in your inbox. Stay tuned and get ready to level up your looks!
                </p>
                <button class="AS_done-btn">Done</button>
            </div>
        </div>
    </div>

    <script>
        var modal = document.getElementById("thankyouModal");
        var closeBtn = document.getElementsByClassName("AS_close-btn")[0];
        var doneBtn = document.getElementsByClassName("AS_done-btn")[0];

        document.getElementById("newsletter-form").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/Project-4-Ecommerce-WebsitePHP-MySql/api/newsletter_submit.php", true);
            // true: Indicates that the request should be asynchronous, 
            // the code will continue to run while the request is being processed.

            xhr.onload = function() {
                if (xhr.status === 200) {
                    if (xhr.responseText === "success") {
                        modal.style.display = "block"; // Show the popup if successful
                    } else {
                        alert(xhr.responseText); // Display error message
                    }
                } else {
                    alert("An error occurred during the request.");
                }
            };

            xhr.send(formData); // Send the form data via AJAX
        });

        closeBtn.onclick = function() {
            modal.style.display = "none";
        }

        doneBtn.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>

</html>