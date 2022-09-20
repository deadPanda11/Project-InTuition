<?php
  $name = $_POST['name'];
  $gender = $_POST['gender'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if (!empty($name) && !empty($gender) && !empty($email) && !empty($password))
  {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "dkfdsfgk";

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error())
    {
      die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    }
    else
    {
      $SELECT = "SELECT email From t1 Where email = ? Limit 1";

      $INSERT= "INSERT Into t1 (name, gender, email, password) values (?, ?, ? , ?)";

      $stmt = $conn->prepare($SELECT);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $stmt->bind_result($email);
      $stmt->store_result();
      $rnum = $stmt->num_rows;

      if($rnum==0)
      {
        $stmt->close();

        $stmt = $conn->prepare($INSERT);
        $stmt->bind_param("ssss", $name, $gender, $email, $password);
        $stmt->execute();
        echo "New record inserted!";

      }
      else {
        echo "Email in use :(";
      }
      $stmt->close();
      $conn->close();
    }
  }
  else
  {
    echo "All fields are required.";
    die();
  }