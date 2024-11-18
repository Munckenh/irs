<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "irs";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT username,password FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_hash = $row['password'];

        if (password_verify($password, $stored_hash)) {
            header("Location: admin/");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="./style.css" rel="stylesheet">
</head>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <div class="mb-md-5 mt-md-4 pb-5">
                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your username and password.</p>
                                <form action="" method="POST">
                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <input type="text" name="username" id="username" class="form-control form-control-lg" />
                                        <label class="form-label" for="username">Username</label>
                                    </div>
                                    <div data-mdb-input-init class="form-outline form-white mb-4">
                                        <input type="password" name="password" id="password" class="form-control form-control-lg" />
                                        <label class="form-label" for="password">Password</label>
                                    </div>
                                    <?php if ($error) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $error; ?>
                                        </div>
                                    <?php } ?>
                                    <button data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                                </form>
                            </div>
                            <div>
                                <p class="mb-0">Do you want to enter an event key? <a href="."
                                        class="text-white-50 fw-bold">Click Here</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>