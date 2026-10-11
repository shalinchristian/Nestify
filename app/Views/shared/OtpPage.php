<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <link rel="icon" href="images/Nestify-Logo.png" type="image/x-icon">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #001f3d;
            color: #ffffff;
            padding: 20px;
        }

        .container {
            background: #002f5f;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 25px rgb(37, 32, 32);
            width: 380px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
        }

        p {
            font-size: 14px;
            color: #cccccc;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .success {
            color: green;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .otp-inputs {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .otp-inputs input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 20px;
            border: none;
            border-radius: 10px;
            background: #f4f4f4;
            outline: none;
            font-weight: bold;
        }

        button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            background: #4db8ff;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.3s;
        }

        button:hover {
            background: #3399e6;
        }

        .resend {
            margin-top: 15px;
            font-size: 14px;
        }

        .resend a {
            color: #aaaaaa;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        .resend a:hover {
            text-decoration: underline;
        }

        .disabled {
            pointer-events: none;
            color: gray;
        }

        @media (max-width: 480px) {
            .container {
                width: 100%;
                padding: 20px;
            }

            .otp-inputs input {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>OTP Verification</h2>
        <p>Enter the 4-digit code sent to your email.</p>

        <form id="otp-form" action="Otp_verify.php" method="POST">
            <div class="otp-inputs">
                <input type="text" name="otp1" maxlength="1" pattern="[0-9]" inputmode="numeric" required autofocus>
                <input type="text" name="otp2" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" name="otp3" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                <input type="text" name="otp4" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
            </div>
            <input type="hidden" name="otp" id="otp" />
            <!-- Display session messages between OTP input and verify button -->
            <?php
            if (isset($_SESSION['message'])) {
                echo '<p style="color: White; 
            margin-bottom: 0px; margin-top: 16px;">' . $_SESSION['message'] . '</p>';
                unset($_SESSION['message']); // Clear message after displaying it
            }
            ?>
            <button type="submit" id="verify-button">Verify</button>
        </form>

        <div class="resend">
            Didn't receive the code? <a href="resend_otp.php" id="resend-otp">Resend OTP</a>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.otp-inputs input');
        const otpHiddenField = document.getElementById('otp');
        const verifyButton = document.getElementById('verify-button');
        const resendOtpLink = document.getElementById('resend-otp');

        // Clear inputs on page load
        inputs.forEach(input => input.value = '');

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                const value = e.target.value.replace(/[^0-9]/g, ''); // Allow only numbers

                if (value) {
                    e.target.value = value;
                    if (index < inputs.length - 1) {
                        inputs[index + 1].focus(); // Move to next input
                    }
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    inputs[index - 1].focus(); // Move back on delete
                }
            });
        });

        document.getElementById('otp-form').addEventListener('submit', (e) => {
            const otp = Array.from(inputs).map(input => input.value).join('');

            if (otp.length !== 4) {
                alert("Please enter the complete OTP!");
                e.preventDefault();
                return;
            }

            otpHiddenField.value = otp; // Store OTP in hidden field
            verifyButton.disabled = true;
            verifyButton.textContent = 'Verifying...';
        });

        resendOtpLink.addEventListener('click', (e) => {
            e.preventDefault();
            resendOtpLink.classList.add('disabled');
            alert("OTP has been resent!");
            setTimeout(() => resendOtpLink.classList.remove('disabled'), 60000);
        });
    </script>
</body>

</html>