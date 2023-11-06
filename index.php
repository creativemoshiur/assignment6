<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fictional_business";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$query_task1 = "
    SELECT Customers.name AS customer_name, COUNT(Orders.order_id) AS total_orders
    FROM Customers
    LEFT JOIN Orders ON Customers.customer_id = Orders.customer_id
    GROUP BY Customers.customer_id, Customers.name
    ORDER BY total_orders DESC;
";

$result_task1 = $conn->query($query_task1);


$query_task2 = "
SELECT OI.order_id, P.name AS product_name, OI.quantity, (OI.quantity * OI.unit_price) AS total_amount FROM Order_Items OI JOIN Products P ON OI.product_id = P.product_id ORDER BY OI.order_id ASC; 
";

$result_task2 = $conn->query($query_task2);


$query_task3 = "
    SELECT Categories.name AS category_name, SUM(Order_Items.quantity * Order_Items.unit_price) AS total_revenue
    FROM Categories
    LEFT JOIN Products ON Categories.category_id = Products.category_id
    LEFT JOIN Order_Items ON Products.product_id = Order_Items.product_id
    GROUP BY Categories.category_id, Categories.name
    ORDER BY total_revenue DESC;
";

$result_task3 = $conn->query($query_task3);


$query_task4 = "
    SELECT Customers.name AS customer_name, SUM(Order_Items.quantity * Order_Items.unit_price) AS total_purchase_amount
    FROM Customers
    LEFT JOIN Orders ON Customers.customer_id = Orders.customer_id
    LEFT JOIN Order_Items ON Orders.order_id = Order_Items.order_id
    GROUP BY Customers.customer_id, Customers.name
    ORDER BY total_purchase_amount DESC
    LIMIT 5;
";

$result_task4 = $conn->query($query_task4);

// Close the database connection when done
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>SQL Query Results</title>
</head>
<body>
    <h2>Task 1: Customer Information with Total Orders</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Total Orders</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_task1->fetch_assoc()) { ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $row['customer_name'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $row['total_orders'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2>Task 2: Product Information for Order Items</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Order Id</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_task2->fetch_assoc()) { ?>
                <tr>
                <td class="px-6 py-4 whitespace-nowrap"><?= $row['order_id'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $row['product_name'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $row['quantity'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $row['total_amount'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2>Task 3: Total Revenue by Product Category</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Category Name</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_task3->fetch_assoc()) { ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $row['category_name'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $row['total_revenue'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2>Task 4: Top 5 Customers by Total Purchase Amount</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Total Purchase Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result_task4->fetch_assoc()) { ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $row['customer_name'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap"><?= $row['total_purchase_amount'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>