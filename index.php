<!DOCTYPE html>
<html>
<head>
    <title>Simple Electricity Consumption Calculator</title>
</head>
<body>
    <?php
    // Dictionary of appliances, their power ratings in watts, and quantity
    $appliances = array(
        'Light bulb' => array('power' => 60, 'quantity' => 1),
        'Refrigerator' => array('power' => 150, 'quantity' => 1),
        'Television' => array('power' => 100, 'quantity' => 1),
        'Laptop' => array('power' => 50, 'quantity' => 1),
        // Add more appliances and their power ratings if needed
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $totalUsage = 0;
        foreach ($appliances as $appliance => $data) {
            if (isset($_POST[$appliance.'_quantity'], $_POST[$appliance.'_hours'])) {
                $quantity = (float)$_POST[$appliance.'_quantity'];
                $hoursPerDay = (float)$_POST[$appliance.'_hours'];
                $totalUsage += $data['power'] * $quantity * $hoursPerDay;
            }
        }
        $dailyUsage = $totalUsage / 1000; // Convert to kilowatt-hours (kWh)
        $monthlyUsage = $dailyUsage * 30; // Assuming an average of 30 days per month
    }
    ?>

    <h1><?php echo isset($dailyUsage) ? "Your Power Consumption" : "Simple Electricity Consumption Calculator"; ?></h1>

    <?php if (!isset($dailyUsage)) { ?>
        <p>Please input the quantity and number of hours each appliance is used daily.</p>
    <?php } ?>

    <form method="post">
        <table>
            <tr>
                <th>Appliance</th>
                <th>Power Rating (Watts)</th>
                <th>Quantity</th>
                <th>Daily Usage (hours)</th>
            </tr>
            <?php
            if (!isset($dailyUsage)) {
                foreach ($appliances as $appliance => $data) {
                    echo "<tr>";
                    echo "<td>{$appliance}</td>";
                    echo "<td>{$data['power']}</td>";
                    echo "<td><input type='number' name='{$appliance}_quantity' value='1'></td>";
                    echo "<td><input type='number' name='{$appliance}_hours' value='0'></td>";
                    echo "</tr>";
                }
                echo "<tr><td colspan='4'><input type='submit' value='Calculate'></td></tr>";
            } else {
                echo "<tr><td colspan='4'><strong>Estimated Electricity Usage</strong></td></tr>";
                echo "<tr><td>Daily</td><td>{$dailyUsage} kWh</td></tr>";
                echo "<tr><td>Monthly</td><td>{$monthlyUsage} kWh</td></tr>";
            }
            ?>
        </table>
    </form>
</body>
</html>
