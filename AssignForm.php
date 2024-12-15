<?php

$errors = [];
$successMessage = "";
$name = "";
$email = "";
$phone = "";
$password = "";
$dob = "";
$gender = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //name
    $name = trim($_POST['name']);
    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }

//dob
    $dob = trim($_POST['dob']);
    if (empty($dob)) {
        $errors['dob'] = "Date of Birth is required.";
    }

    // Phone number
    $phone = trim($_POST['phone']);
    if (empty($phone)) {
        $errors['phone'] = "Phone number is required.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors['phone'] = "Phone number must be 10 digits.";
    }

    // Email 
    $email = trim($_POST['email']);
    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    // Password
    $password = trim($_POST['password']);
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) > 8) {
        $errors['password'] = "Password must not be more than 8 characters.";
    }

    // Gender 
    $gender = trim($_POST['gender']);
    if (empty($gender)) {
        $errors['gender'] = "Gender is required.";
    }

    // Success 
    if (empty($errors)) {
        $successMessage = "Form submitted successfully!";
        // You can perform additional actions like saving to a database here.
        $name = $email = $phone = $password = $dob = $gender = ""; // Clear inputs after submission
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Form with PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1 { text-align: center; color: #333; }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            opacity: 0;
            animation: fadeIn 1s forwards;
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        .form-group { margin-bottom: 15px; }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input, select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        input:focus, select:focus {
            outline: none;
            border-color:rgb(50, 68, 147);
            box-shadow: 0 0 5px rgba(36, 105, 179, 0.5);
        }
        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .success {
            color: green;
            font-size: 1em;
            margin-top: 10px;
            text-align: center;
            opacity: 0;
            animation: successAnimation 1s forwards;
        }
        @keyframes successAnimation {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 1em;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .loading {
            display: none;
            text-align: center;
            margin-top: 10px;
        }
        .loading img {
            width: 30px;
        }
    </style>
</head>
<body>
    <h1>Interactive Form</h1>
    <div class="container">
        <!-- Form -->
        <form id="myForm" method="POST" action="">
            <div class="form-group">
                <label for="name">Name:</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    placeholder="Enter your name" 
                    value="<?php echo htmlspecialchars($name); ?>"
                    oninput="validateInput('name')"
                >
                <?php if (!empty($errors['name'])): ?>
                    <div class="error"><?php echo $errors['name']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="dob">Date of Birth:</label>
                <input 
                    type="date" 
                    id="dob" 
                    name="dob" 
                    value="<?php echo htmlspecialchars($dob); ?>"
                    oninput="validateInput('dob')"
                >
                <?php if (!empty($errors['dob'])): ?>
                    <div class="error"><?php echo $errors['dob']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input 
                    type="text" 
                    id="phone" 
                    name="phone" 
                    placeholder="Enter your phone number" 
                    value="<?php echo htmlspecialchars($phone); ?>"
                    oninput="validateInput('phone')"
                >
                <?php if (!empty($errors['phone'])): ?>
                    <div class="error"><?php echo $errors['phone']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select 
                    id="gender" 
                    name="gender" 
                    value="<?php echo htmlspecialchars($gender); ?>"
                    oninput="validateInput('gender')"
                >
                    <option value="">Select Gender</option>
                    <option value="male" <?php echo $gender == 'male' ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo $gender == 'female' ? 'selected' : ''; ?>>Female</option>
                    <option value="other" <?php echo $gender == 'other' ? 'selected' : ''; ?>>Other</option>
                </select>
                <?php if (!empty($errors['gender'])): ?>
                    <div class="error"><?php echo $errors['gender']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input 
                    type="text" 
                    id="email" 
                    name="email" 
                    placeholder="Enter your email" 
                    value="<?php echo htmlspecialchars($email); ?>"
                    oninput="validateInput('email')"
                >
                <?php if (!empty($errors['email'])): ?>
                    <div class="error"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Enter your password" 
                    value="<?php echo htmlspecialchars($password); ?>"
                    oninput="validateInput('password')"
                >
                <?php if (!empty($errors['password'])): ?>
                    <div class="error"><?php echo $errors['password']; ?></div>
                <?php endif; ?>
            </div>

            <button type="submit" id="submitButton">Submit</button>

            <div class="loading" id="loading">
                <img src="https://cdnjs.cloudflare.com/ajax/libs/loader.js/4.0.0/img/loader.svg" alt="Loading...">
            </div>
        </form>

        <!-- Success  -->
        <?php if (!empty($successMessage)): ?>
            <div class="success" id="successMessage"><?php echo $successMessage; ?></div>
        <?php endif; ?>
    </div>

    <script>
        
        function validateInput(inputId) {
            const inputElement = document.getElementById(inputId);
            const errorElement = inputElement.nextElementSibling;
            if (errorElement && errorElement.classList.contains('error')) {
                errorElement.style.display = 'none'; // Hide the error message on user input
            }
        }

        
        const form = document.getElementById('myForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault(); 
            document.getElementById('loading').style.display = 'block'; 

        
            setTimeout(function() {
                form.submit(); 
            }, 2000);
        });

        
        <?php if (!empty($successMessage)): ?>
            setTimeout(function() {
                
                document.getElementById('successMessage').style.display = 'none';
                
            
                document.getElementById('name').value = '';
                document.getElementById('dob').value = '';
                document.getElementById('phone').value = '';
                document.getElementById('gender').value = '';
                document.getElementById('email').value = '';
                document.getElementById('password').value = '';
            }, 5000); //5 sec
        <?php endif; ?>
    </script>
</body>
</html>

