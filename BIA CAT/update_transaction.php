<?php
include('database_connection.php');
// Check if transaction_id is set
if(isset($_REQUEST['transaction_id'])) {
    $tid = $_REQUEST['transaction_id'];
    
    $stmt = $connection->prepare("SELECT * FROM transaction WHERE transaction_id = ?");
    $stmt->bind_param("i", $tid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['transaction_id'];
        $y = $row['transaction_type'];
        $s = $row['amount'];
        $z = $row['transaction_date'];
        $w = $row['account_id'];
                                           
    } else {
        echo "Transaction not found.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Update transaction</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update transaction form -->
    <h2><u>Update Form of Transaction</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">


        
        <label for="transaction_type">Transaction type:</label>
        <input type="text" name="ttype" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="amount">Amount:</label>
        <input type="number" name="tam" value="<?php echo isset($s) ? $s : ''; ?>">
        <br><br>

        <label for="transaction_date">Transaction date:</label>
        <input type="date" name="tdate" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

        <label for="account_id">Account id:</label>
        <input type="number" name="taid" value="<?php echo isset($w) ? $w : ''; ?>">
        <br><br>


        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
include('database_connection.php');
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $transaction_type = $_POST['ttype'];
    $amount = $_POST['tam'];
    $transaction_date = $_POST['tdate'];
    $account_id = $_POST['taid'];
    
    // Update the transaction in the database
    $stmt = $connection->prepare("UPDATE transaction SET transaction_type=?, amount=?, transaction_date=?, account_id=? WHERE transaction_id=?");
    $stmt->bind_param("sssss", $transaction_type, $amount, $transaction_date, $account_id, $tid);
    $stmt->execute();
    
    // Redirect to transaction.php
    header('Location: transaction.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
