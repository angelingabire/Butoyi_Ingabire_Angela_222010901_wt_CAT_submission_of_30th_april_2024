<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Our Products</title>
  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: white;
      background-color: pink;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: purple;
    }
    /* Unvisited link */
    a:link {
      color: brown; /* Changed to lowercase */
    }
    /* Hover effect */
    a:hover {
      background-color: white;
    }

    /* Active link */
    a:active {
      background-color: red;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }
    /* Extend margin left for search button */
    input.form-control {
      margin-left: 1200px; /* Adjust this value as needed */

      padding: 8px;
     
    }
    section{
    padding:71px;
    border-bottom: 1px solid #ddd;
    }
    footer{
    text-align: center;
    padding: 15px;
    background-color:darkgray;
    }

  </style>
   <!-- JavaScript validation and content load for insert data-->
        <script>
            function confirmInsert() {
                return confirm('Are you sure you want to insert this record?');
            }
        </script>
  </head>

  <header>

<body bgcolor="#707070">
  <form class="d-flex" role="search" action="search.php">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
    <img src="./images/bank-vector-icon.jpg" width="90" height="60" alt="Logo">
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./home.html">HOME</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./account.php">ACCOUNT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./branch.php">BRANCH</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./customer.php">CUSTOMER</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./employee.php">EMPLOYEE</a>
  </li>
<li style="display: inline; margin-right: 10px;"><a href="./transaction.php">TRANSACTION</a>
  </li>
    
    <li class="dropdown" style="display: inline; margin-right: 10px;">
      <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
        <a href="logout.php">Logout</a>
      </div>
    </li><br><br>
    
    
    
  </ul>

</header>
<section>

    <h1><u> Account Form </u></h1>
    <form method="post" onsubmit="return confirmInsert();">
            
        <label for="Account Id">Account Id:</label>
        <input type="number" id="accid" name="accid"><br><br>

        <label for="Account Number">Account Number:</label>
        <input type="number" id="accnum" name="accnum" required><br><br>

        <label for="Account type">Account type:</label>
        <input type="text" id="acctyp" name="acctyp" required><br><br>

        <label for="Balance amount">Balance amount:</label>
        <input type="number" id="bal" name="bal" required><br><br>

        <label for="Customer id">Customer id:</label>
        <input type="number" id="acccid" name="acccid" required><br><br>


        <input type="submit" name="add" value="Insert">
      

    </form>


<?php
// Connection details
include('database_connection.php');


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO Account(account_id, account_number,account_type, balance_amount, customer_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $account_id, $account_number, $account_type, $balance_amount,$customer_id);
    // Set parameters and execute
    $account_id = $_POST['accid'];
    $account_number = $_POST['accnum'];
    $account_type = $_POST['acctyp'];
    $balance_amount = $_POST['bal'];
    $customer_id= $_POST['acccid'];
   
    if ($stmt->execute() == TRUE) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$connection->close();
?>

<?php
// Connection details
include('database_connection.php');

// SQL query to fetch data from the Product table
$sql = "SELECT * FROM account";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of Account</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <center><h2>Table of Accounts</h2></center>
    <table border="5">
        <tr>
            <th>Account Id</th>
            <th>Account Number</th>
            <th>Balance amount</th>
            <th>Account type</th>
            <th>Account Id</th>
            <th>Delete</th>
            <th>Update</th> 
            
        </tr>
        <?php
        // Define connection parameters
        include('database_connection.php');


        // Prepare SQL query to retrieve all products
        $sql = "SELECT * FROM account";
        $result = $connection->query($sql);

        // Check if there are any products
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                $accid = $row['account_id']; // Fetch the account_id
                echo "<tr>
                    <td>" . $row['account_id'] . "</td>
                    <td>" . $row['account_number'] . "</td>
                    <td>" . $row['account_type'] . "</td>
                    <td>" . $row['balance_amount'] . "</td>
                    <td>" . $row['customer_id'] . "</td>
                    <td><a style='padding:4px' href='delete_account.php?account_id=$accid'>Delete</a></td> 
                    <td><a style='padding:4px' href='update_account.php?account_id=$accid'>Update</a></td> 
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        // Close the database connection
        $connection->close();
        ?>
    </table>
</body>

    </section>


  
<footer>
  <center> 
    <b><h2>UR CBE BIT &copy, 2024 &reg, Designer by: @Angela BUTOYI INGABIRE</h2></b>
  </center>
</footer>
</body>
</html>