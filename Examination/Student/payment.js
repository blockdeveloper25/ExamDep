function buynow(id) {
  var X = new XMLHttpRequest();
  X.onreadystatechange = function () {
    if (X.readyState == 4) {
      var text = X.responseText;

      if (text == 3) {
        window.location = "index.php";
        alert("Invalid User");
      } else {
        var j = JSON.parse(text);
        // Payment completed. It can be a successful failure.
        payhere.onCompleted = function onCompleted() {
          // Note: validate the payment and show success or failure page to the customer
          console.log("Sujair");
          alert("Payment completed successfully");
          
        };

        // Payment window closed
        payhere.onDismissed = function onDismissed() {
          // Note: Prompt user to pay again or show an error page
          alert("Payment dismissed");
        };

        // Error occurred
        payhere.onError = function onError(error) {
          // Note: show an error page
          alert("Invalid Details");
        };

        // Put the payment variables here
        var payment = {
          sandbox: true,
          merchant_id: "1228461", // Replace your Merchant ID
          return_url:
            "http://localhost/SABARAEXAMDEP/Examination/Student/payment.php", // Important
          cancel_url:
            "http://localhost/SABARAEXAMDEP/Examination/Student/payment.php", // Important
          notify_url:
            "http://localhost/SABARAEXAMDEP/Examination/Student/payment.php",
          order_id: "ItemNo12345",
          items: j.pn,
          amount: j.pp,
          currency: "LKR",
          hash: j.hash, // *Replace with generated hash retrieved from backend
          first_name: j.un,
          last_name: "Perera",
          batch: j.btc,
          email: "",
          phone: j.um,
          address: "No.1, Galle Road",
          city: "Colombo",
          country: "Sri Lanka",
          delivery_address: "No. 46, Galle road, Kalutara South",
          delivery_city: "Kalutara",
          delivery_country: "Sri Lanka",
          custom_1: "",
          custom_2: "",
        };

        // Show the payhere.js popup, when "PayHere Pay" is clicked

        payhere.startPayment(payment);
      }
    }
  };
  X.open("GET", "server.php?id=" + id, true);
  X.send();
}
