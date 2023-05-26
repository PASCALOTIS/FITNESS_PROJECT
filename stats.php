<!DOCTYPE html>
<html>
<head>
  <title>Fitness Tracker - Update Profile</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f2f2f2;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    h1 {
      text-align: center;
      color: #3b73ef;
      margin-bottom: 30px;
    }

    form {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 10px;
    }

    input[type="text"],
    input[type="number"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 10px;
    }

    input[type="submit"] {
      display: inline-block;
      background-color: #3bdc23;
      color: #fff;
      border: none;
      border-radius: 3px;
      padding: 10px 15px;
      text-decoration: none;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Update Profile</h1>
    <?php
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    // Database Configuration
    $hostname = "localhost"; // Replace with your database hostname
    $username = "root";      // Replace with your database username
    $password = "";          // Replace with your database password
    $database = "fitness tracker";   // Replace with your database name

    // Create a connection to the database
    $conn = mysqli_connect($hostname, $username, $password, $database);

    // Check the connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve user's profile from the database
    $username = $_SESSION['username'];
    $query = "SELECT * FROM update_profile WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    // Check if query execution was successful
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Check if the user has any profile data
    if (mysqli_num_rows($result) > 0) {
        // Fetch the profile data
        $row = mysqli_fetch_assoc($result);

        // Extract the profile data
        $weight = $row['weight'];
        $height = $row['height'];
        $goal = $row['goal'];
        $name = $row['name'];

        // Display the profile data
        echo "Weight: $weight<br>";
        echo "Height: $height<br>";
        echo "Goal: $goal<br>";
        echo "Name: $name<br>";

        // Display a form to update the profile
        echo '
        <form action="profile.php" method="POST">
          <label for="weight">Weight</label>
          <input type="number" id="weight" name="weight" value="'.$weight.'" required>
          <label for="height">Height</label>
          <input type="number" id="height" name="height" value="'.$height.'" required>
          <label for="goal">Goal</label>
          <input type="text" id="goal" name="goal" value="'.$goal.'" required>
          <label for="name">Name</label>
          <input type="text" id="name" name="name" value="'.$name.'" required>
          <input type="submit" value="Update Profile">
        </form>';
    } else {
        echo "No profile data available.";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
    <br>
    <a href="profile.php">View Profile</a>
  </div>
</body>
</html>

