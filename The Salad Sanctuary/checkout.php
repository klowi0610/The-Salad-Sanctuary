<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout - The Salad Sanctuary</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Satisfy&display=swap">
<style>
    body { font-family: 'Montserrat', sans-serif; background: url('new co bg.jpg') center center fixed; background-size: 150%; margin:0; padding:0; color:#333;}
    h1 { font-family: 'Satisfy', cursive; color: #4CAF50; text-align:center; margin-top:50px; font-size:5em; text-shadow:2px 2px 4px #000;}
    form { max-width:600px; margin:0 auto; padding:20px; background-color: rgba(255,255,255,0.9); border-radius:10px; box-shadow:0 0 20px rgba(0,0,0,0.2);}
    label { font-size:1.1rem; color:#4CAF50; }
    input[type="text"], input[type="email"], textarea { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:5px; box-sizing:border-box; }
    textarea { resize:none; height:150px; }
    input[type="radio"] { display:none; }
    button[type="submit"] { background-color:#4caf50; color:#fff; border:none; padding:15px 60px; font-size:24px; margin-top:20px; cursor:pointer; border-radius:30px; font-family:'Satisfy', cursive; width:100%; }
    button[type="submit"]:hover { background-color:#f30c0ce6; }
    .hidden { display:none; }

    /* Circle button style for payment options */
    .circle-option {
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #4CAF50;
        border-radius: 50%;
        width: 80px;
        height: 80px;
        margin-right: 15px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
        flex-direction: column;
        font-size: 0.9rem;
        color: #4CAF50;
    }

    .circle-option img {
        width: 40px;
        margin-bottom: 5px;
    }

    input[type="radio"]:checked + .circle-option {
        background-color: #4CAF50;
        color: white;
    }

    .payment-options-wrapper {
        display: flex;
        gap: 10px;
        margin: 10px 0;
    }

</style>
</head>
<body>

<h1>Checkout</h1>
<form id="checkoutForm" method="POST" action="process.php">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="address">Delivery Address:</label>
    <input type="text" id="address" name="address" required>

    <label for="phone">Phone Number:</label>
    <input type="text" id="phone" name="phone" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="orders">Orders:</label>
    <textarea id="orders" name="orders" readonly></textarea>

    <fieldset>
        <legend>Payment Method: </legend>
        <div class="payment-options-wrapper">
            <div class="payment-option">
                <input type="radio" id="cod" name="payment" value="COD" onclick="togglePaymentInputs()">
                <label for="cod" class="circle-option"><img src="cod_logo.png" alt="COD"><span>COD</span></label>
            </div>
            <div class="payment-option">
                <input type="radio" id="gcash" name="payment" value="GCash" onclick="togglePaymentInputs()">
                <label for="gcash" class="circle-option"><img src="gcash_logo.png" alt="GCash"><span>GCash</span></label>
            </div>
            <div class="payment-option">
                <input type="radio" id="bank" name="payment" value="Bank" onclick="togglePaymentInputs()">
                <label for="bank" class="circle-option"><img src="card.png" alt="Bank"><span>Bank</span></label>
            </div>
        </div>
    </fieldset>

    <div id="gcash-details" class="hidden">
        <label for="gcash-number">GCash Number:</label>
        <input type="text" id="gcash-number" name="gcash-number">
    </div>

    <div id="bank-details" class="hidden">
        <label for="card-number">Card Number:</label>
        <input type="text" id="card-number" name="card-number">
        <label for="cardholder-name">Cardholder Name:</label>
        <input type="text" id="cardholder-name" name="cardholder-name">
    </div>

    <button type="submit">Place Order</button>
</form>

<script>
    // Load basket from localStorage and show in textarea
    const basketItems = JSON.parse(localStorage.getItem("basketItems")) || [];
    const ordersTextarea = document.getElementById("orders");

    if (basketItems.length > 0) {
        let ordersText = "";
        basketItems.forEach(item => {
            ordersText += `${item.name} - Quantity: ${item.quantity}\n`;
        });
        ordersTextarea.value = ordersText;
    } else {
        ordersTextarea.value = "No items in your basket.";
    }

    // Toggle payment method fields
    function togglePaymentInputs() {
        const codSelected = document.getElementById('cod').checked;
        const gcashSelected = document.getElementById('gcash').checked;
        const bankSelected = document.getElementById('bank').checked;

        document.getElementById('gcash-details').style.display = gcashSelected ? 'block' : 'none';
        document.getElementById('bank-details').style.display = bankSelected ? 'block' : 'none';
    }

    // Ensure a payment method is selected before submitting
    document.getElementById('checkoutForm').addEventListener('submit', function(e){
        const paymentOptions = document.getElementsByName('payment');
        let selected = false;
        paymentOptions.forEach(opt => { if(opt.checked) selected = true; });
        if(!selected){
            e.preventDefault();
            alert("Please select a payment method.");
        }
    });
</script>
</body>
</html>
