<?php
session_start();
if (!isset($_SESSION['user_id'], $_SESSION['membership'])) {
    header("Location: index.html");
    exit();
}

$membership = $_SESSION['membership'];
$userId = $_SESSION['user_id'];
?>

<h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

<?php if ($membership === 'pro'): ?>
    <p>Please complete your Pro membership payment below:</p>
    
    <div id="paypal-container-7K53UQWSY98QE"></div>
    
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID&components=hosted-buttons&enable-funding=venmo&currency=USD"></script>
    
    <script>
      paypal.HostedButtons({
        hostedButtonId: "7K53UQWSY98QE",
        onApprove: function(data) {
          // Optional: let your server know this order was approved
          fetch('/paypal_success.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              user_id: "<?php echo $userId; ?>",
              order_id: data.orderID
            })
          });
        }
      }).render("#paypal-container-7K53UQWSY98QE");
    </script>
<?php else: ?>
    <p>Thank you for signing up for the free membership!</p>
<?php endif; ?>
