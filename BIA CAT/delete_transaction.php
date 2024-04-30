<?php
include('database_connection.php');

// Function to show delete confirmation modal
function showDeleteConfirmation($tid) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($tid)">Confirm</button>
            <button onclick="returnToTransaction()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(tid) {
        window.location.href = '?transaction_id=' + tid + '&confirm=yes';
    }
    function returnToTransaction() {
        window.location.href = 'transaction.php';
    }
    </script>
HTML;
}

// Check if transaction_id is set
if(isset($_REQUEST['transaction_id'])) {
    $tid = $_REQUEST['transaction_id'];
    
    // Check for confirmation response
    if(isset($_REQUEST['confirm']) && $_REQUEST['confirm'] == 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM transaction WHERE transaction_id=?");
        $stmt->bind_param("i", $tid);
        if($stmt->execute()) {
            echo "<script>alert('Record deleted successfully.'); window.location.href = 'transaction.php';</script>";
        } else {
            echo "<script>alert('Error deleting data: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        // Show confirmation dialog
        showDeleteConfirmation($tid);
    }
} else {
    echo "<script>alert('transaction_id is not set.'); window.location.href = 'transaction.php';</script>";
}

$connection->close();
?>
