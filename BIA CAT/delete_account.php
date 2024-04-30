<?php
include('database_connection.php');

// Function to show delete confirmation modal
function showDeleteConfirmation($accid) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($accid)">Confirm</button>
            <button onclick="returnToAccount()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(accid) {
        window.location.href = '?account_id=' + accid + '&confirm=yes';
    }
    function returnToCustomers() {
        window.location.href = 'account.php';
    }
    </script>
HTML;
}

// Check if account_id is set
if(isset($_REQUEST['account_id'])) {
    $accid = $_REQUEST['account_id'];
    
    // Check for confirmation response
    if(isset($_REQUEST['confirm']) && $_REQUEST['confirm'] == 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM account WHERE account_id=?");
        $stmt->bind_param("i", $accid);
        if($stmt->execute()) {
            echo "<script>alert('Record deleted successfully.'); window.location.href = 'account.php';</script>";
        } else {
            echo "<script>alert('Error deleting data: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        // Show confirmation dialog
        showDeleteConfirmation($accid);
    }
} else {
    echo "<script>alert('account_id is not set.'); window.location.href = 'account.php';</script>";
}

$connection->close();
?>
