<h3>Express Checkout</h3>
<?php $invnum = rand(0000000, 9999999); ?>
<ul>
    <li><a href="ec.php?type=single&amt=10.00&invoice=<?php echo $invnum; ?>">Single Transaction for $10</a></li>
    <li><a href="ec.php?type=monthly&amt=15.00&payments=10&invoice=<?php echo $invnum; ?>">Monthly Recurring of $15/mo</a></li>
    <li><a href="ec.php?type=biweekly&amt=5.00&payments=10&invoice=<?php echo $invnum; ?>">Bi-weekly Recurring of $5</a></li>
</ul>

