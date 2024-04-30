<?php
include('database_connection.php');

// Check if account_id is set
if(isset($_REQUEST['account_id'])) {
    $accid = $_REQUEST['account_id'];
    
    $stmt = $connection->prepare("SELECT * FROM account WHERE account_id=?");
    $stmt->bind_param("i", $accid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['account_id'];
        $y = $row['account_number'];
        $s = $row['account_type'];
        $z = $row['balance_amount'];
        $w = $row['customer_id'];

        
    } else {
        echo "Account not found.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Update account</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update account form -->
        <h2><u>Update Form of account</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">

        
            <label for="account_number">Account number:</label>
            <input type="number" name="accnum" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="account_type">Account type:</label>
            <input type="text" name="acctyp" value="<?php echo isset($s) ? $s : ''; ?>">
            <br><br>

            <label for="balance_amount">Balance amount:</label>
            <input type="number" name="bal" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="customer_id">Customer id:</label>
            <input type="number" name="acccid" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>

            <input type="hidden" name="account_id" value="<?php echo isset($x) ? $x : ''; ?>">
            <input type="submit" name="up" value="Update">
        
        </form>
    </center>
</body>
</html>

<?php
include('database_connection.php');
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $account_number = $_POST['accnum'];
    $account_type = $_POST['acctyp'];
    $balance_amount = $_POST['bal'];
    $customer_id = $_POST['acccid'];
    $account_id = $_POST['account_id']; // added this line to retrieve account_id
    
    // Update the account in the database
    $stmt = $connection->prepare("UPDATE account SET account_number=?, account_type=?, balance_amount=?, customer_id=? WHERE account_id=?");
    $stmt->bind_param("sssii", $account_number, $account_type, $balance_amount, $customer_id, $account_id); // corrected the bind_param parameters
    $stmt->execute();
    
    // Redirect to account.php
    header('Location: account.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
