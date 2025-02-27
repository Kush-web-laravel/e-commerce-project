<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firebase Phone Authentication</title>

    <!-- jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Google reCAPTCHA v3 -->
<script src="https://www.google.com/recaptcha/api.js?render=6Lc9ruAqAAAAAIf-jfBAwShZ_muRcozEgRnWtFXA"></script>


    <!-- CSRF Token for Laravel -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>

    <h2>Login with Phone Number</h2>

    <form id="otp-form">
    <label>Phone Number:</label>
    <input type="text" id="number" class="form-control" placeholder="+91 9876543210"><br>

    <button type="button" class="btn btn-success" id="sendCode">Send Code</button>
    
    <div id="sentSuccess" style="color:green; display:none;"></div>
    <div id="error" style="color:red; display:none;"></div>
</form>

<!-- OTP Verification -->
<div id="otp-section" style="display:none;">
    <label>Enter OTP:</label>
    <input type="text" id="otp" class="form-control"><br>
    <button type="button" class="btn btn-primary" id="verifyOTP">Verify OTP</button>
</div>

<script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-auth-compat.js"></script>
    <script>
        // Firebase configuration (use the same config as in your live project)
        var firebaseConfig = {
            apiKey: "AIzaSyDQaxvshnYcXgQ8KYy3Zk7EAetFAOZQrzo",
            authDomain: "recaptcha-d4f01.firebaseapp.com",
            projectId: "recaptcha-d4f01",
            storageBucket: "recaptcha-d4f01.firebasestorage.app",
            messagingSenderId: "1000666075321",
            appId: "1:1000666075321:web:61732e65604721cddf4b68",
            measurementId: "G-82T0RJ76HH"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        $(document).ready(function () {
        $('#sendCode').click(function () {
            var number = $("#number").val();

            if (number === "") {
                alert("Please enter a phone number.");
                return;
            }

            // Execute Google reCAPTCHA v3
            grecaptcha.ready(function () {
                grecaptcha.execute('6Lc9ruAqAAAAAIf-jfBAwShZ_muRcozEgRnWtFXA', { action: 'submit' })
                    .then(function (token) {
                        SendCode(number, token);
                    });
            });
        });
    });

    function SendCode(number, recaptchaToken) {
        // Firebase Phone Authentication with Recaptcha Token
        var appVerifier = new firebase.auth.RecaptchaVerifier('sendCode', {
            size: "invisible"
        });

        firebase.auth().signInWithPhoneNumber(number, appVerifier)
            .then(function (confirmationResult) {
                window.confirmationResult = confirmationResult;

                $("#sentSuccess").text("OTP sent successfully!").show();
                $("#otp-section").show();
            })
            .catch(function (error) {
                $("#error").text(error.message).show();
            });
    }

    $('#verifyOTP').click(function () {
        var code = $("#otp").val();

        if (code === "") {
            alert("Please enter the OTP.");
            return;
        }

        confirmationResult.confirm(code)
            .then(function (result) {
                var user = result.user;
                $("#sentSuccess").text("Phone number verified! ✅").show();
            })
            .catch(function (error) {
                $("#error").text("Invalid OTP! ❌").show();
            });
    });
    </script>

</body>
</html>
