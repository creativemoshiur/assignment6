--Task1
    SELECT Customers.name AS customer_name, COUNT(Orders.order_id) AS total_orders
    FROM Customers
    LEFT JOIN Orders ON Customers.customer_id = Orders.customer_id
    GROUP BY Customers.customer_id, Customers.name
    ORDER BY total_orders DESC;

 --Task2  
  SELECT OI.order_id, P.name AS product_name, OI.quantity, (OI.quantity * OI.unit_price) AS total_amount FROM Order_Items OI JOIN Products P ON OI.product_id = P.product_id ORDER BY OI.order_id ASC;

 --Task3
    SELECT Categories.name AS category_name, SUM(Order_Items.quantity * Order_Items.unit_price) AS total_revenue
    FROM Categories
    LEFT JOIN Products ON Categories.category_id = Products.category_id
    LEFT JOIN Order_Items ON Products.product_id = Order_Items.product_id
    GROUP BY Categories.category_id, Categories.name
    ORDER BY total_revenue DESC;

 --Task4
     SELECT Customers.name AS customer_name, SUM(Order_Items.quantity * Order_Items.unit_price) AS total_purchase_amount
    FROM Customers
    LEFT JOIN Orders ON Customers.customer_id = Orders.customer_id
    LEFT JOIN Order_Items ON Orders.order_id = Order_Items.order_id
    GROUP BY Customers.customer_id, Customers.name
    ORDER BY total_purchase_amount DESC
    LIMIT 5;    