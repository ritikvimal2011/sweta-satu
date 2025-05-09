document.getElementById("bookNowBtn").onclick = function(e) {
    const amount = this.dataset.amount; // in INR
    const workerId = this.dataset.workerId;

    fetch("check_login.php") // check session
        .then(res => res.json())
        .then(data => {
            if (!data.loggedIn) {
                alert("Please log in first.");
                window.location.href = "login.html";
                return;
            }

            var options = {
                "key": "YOUR_RAZORPAY_KEY", 
                "amount": amount * 100, // in paise
                "currency": "INR",
                "name": "Sewa Setu",
                "description": "Booking Payment",
                "handler": function (response) {
                    // Success: Call PHP to save booking
                    fetch("save_booking.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/json" },
                        body: JSON.stringify({
                            razorpay_payment_id: response.razorpay_payment_id,
                            worker_id: workerId,
                            amount: amount
                        })
                    }).then(res => res.json()).then(result => {
                        alert("Booking successful!");
                    });
                },
                "prefill": {
                    "name": data.name,
                    "email": data.email
                },
                "theme": {
                    "color": "#3399cc"
                }
            };
            var rzp = new Razorpay(options);
            rzp.open();
        });
};