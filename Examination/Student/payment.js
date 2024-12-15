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
        
        // Show the payhere.js popup, when "PayHere Pay" is clicked

        payhere.startPayment(payment);
      }
    }
  };
  X.open("GET", "server.php?id=" + id, true);
  X.send();
}
