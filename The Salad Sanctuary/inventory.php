<?php
session_start();

// Logout functionality
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php"); // redirect to admin.php
    exit;
}

$conn = new mysqli("localhost", "root", "Bbmwkkil7", "salad_sanctuary");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM inventory WHERE id=$id");
}

if (isset($_POST['save_item'])) {
    $salad = $_POST['salad_name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $conn->query("INSERT INTO inventory (salad_name, price, quantity) VALUES ('$salad', '$price', '$quantity')");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard - Salad's Sanctuary</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background: transparent !important;
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
    }

    .video-background {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: -2;
    }

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.3);
      z-index: -1;
    }

    .dashboard-container {
      width: 90%;
      max-width: 1000px;
      margin: 50px auto;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
      padding: 30px;
      position: relative;
      z-index: 1;
      backdrop-filter: blur(6px);
    }

    h1 {
      text-align: center;
      color: #ffffffff;
      font-family: 'Satisfy', cursive;
      margin-bottom: 10px;
    }

    h2 {
      text-align: center;
      color: #2e7d32;
      font-weight: 600;
      margin-top: 20px;
    }

    .search-bar {
      width: 80%;
      margin: 10px auto 25px;
      padding: 10px 20px;
      border-radius: 30px;
      border: none;
      outline: none;
      display: block;
      font-size: 1rem;
      background: linear-gradient(to right, #8bc34a, #4caf50);
      color: #b5b5b5ff;
      font-weight: 600;
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 25px;
      background-color: white;
      border-radius: 10px;
      overflow: hidden;
    }

    th {
      background: #4caf50;
      color: white;
      padding: 12px;
      text-align: left;
    }

    td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
    }

    .input-row {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 20px;
      flex-wrap: wrap;
    }

    .input-row input {
      padding: 8px 12px;
      border-radius: 20px;
      border: 2px solid #4caf50;
      outline: none;
      width: 150px;
      font-size: 0.95rem;
    }

    .input-row button {
      background: #4caf50;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 20px;
      cursor: pointer;
      transition: 0.3s;
    }

    .input-row button:hover {
      background: #43a047;
    }

    .action-btn {
      background: #4caf50;
      color: white;
      border: none;
      padding: 5px 12px;
      border-radius: 20px;
      cursor: pointer;
      transition: 0.3s;
      margin-right: 5px;
    }

    .action-btn:hover {
      background: #388e3c;
    }

    .remove-btn {
      background: #e53935;
    }

    .remove-btn:hover {
      background: #c62828;
    }

    .logout-btn {
      display: block;
      background: #e53935;
      color: white;
      border: none;
      padding: 10px 25px;
      border-radius: 25px;
      margin: 30px auto 0;
      cursor: pointer;
      font-size: 1rem;
      text-decoration: none;
      text-align: center;
    }

    .logout-btn:hover {
      background: #c62828;
    }
  </style>
</head>
<body>

  <video autoplay muted loop class="video-background">
    <source src="salad.mp4" type="video/mp4">
    Your browser does not support the video tag.
  </video>

  <div class="overlay"></div>

  <div class="dashboard-container">
    <h1>Admin Dashboard 🍃</h1>

    <h2>Inventory</h2>
    <input type="text" id="inventorySearch" class="search-bar" placeholder="Search Inventory..." onkeyup="searchInventory()">

    <table id="inventoryTable">
      <thead>
        <tr>
          <th>Salad Name</th>
          <th>Price (₱)</th>
          <th>Quantity</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $result = $conn->query("SELECT * FROM inventory");
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['salad_name']}</td>
                      <td>{$row['price']}</td>
                      <td>{$row['quantity']}</td>
                      <td>
                        <button class='action-btn'>Edit</button>
                        <a href='?delete={$row['id']}'><button class='action-btn remove-btn'>Remove</button></a>
                      </td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='4'>No items in inventory</td></tr>";
          }
        ?>
      </tbody>
    </table>

    <div class="input-row">
      <form method="POST">
        <input type="text" name="salad_name" placeholder="Salad Name" required>
        <input type="number" name="price" placeholder="Price (₱)" required>
        <input type="number" name="quantity" placeholder="Quantity" required>
        <button type="submit" name="save_item">Save Salad</button>
      </form>
    </div>

    <h2>Record of Orders</h2>
    <input type="text" id="ordersSearch" class="search-bar" placeholder="Search Orders..." onkeyup="searchOrders()">

    <table id="ordersTable">
      <thead>
        <tr>
          <th>Name</th>
          <th>Address</th>
          <th>Phone</th>
          <th>Email</th>
          <th>Order</th>
          <th>Payment Method</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $orders = $conn->query("SELECT * FROM record_of_orders");
          if ($orders->num_rows > 0) {
            while ($row = $orders->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['customer_name']}</td>
                      <td>{$row['address']}</td>
                      <td>{$row['phone']}</td>
                      <td>{$row['email']}</td>
                      <td>{$row['order_details']}</td>
                      <td>{$row['payment_method']}</td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='6'>No orders yet</td></tr>";
          }
          $conn->close();
        ?>
      </tbody>
    </table>

    <a href="?logout=1" class="logout-btn">LOGOUT</a>
  </div>

  <script>
    function searchInventory() {
      const input = document.getElementById("inventorySearch").value.toLowerCase();
      document.querySelectorAll("#inventoryTable tbody tr").forEach(row => {
        const name = row.cells[0].innerText.toLowerCase();
        row.style.display = name.includes(input) ? "" : "none";
      });
    }

    function searchOrders() {
      const input = document.getElementById("ordersSearch").value.toLowerCase();
      document.querySelectorAll("#ordersTable tbody tr").forEach(row => {
        const name = row.cells[0].innerText.toLowerCase();
        row.style.display = name.includes(input) ? "" : "none";
      });
    }
  </script>
</body>
</html>
