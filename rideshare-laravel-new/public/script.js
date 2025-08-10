// Wait for the document to be ready
$(document).ready(function() {
    // Get CSRF token from server
    $.get('get_csrf_token.php', function(response) {
        $('#csrf_token').val(response.token);
    });

    // Add an event listener to the "Find a Ride" button
    $('#findRideBtn').click(function() {
        // Redirect the user to the search page
        window.location.href = "search.html";
    });

    // Add event listener for login form submission
    $("#loginForm").on("submit", function (event) {
        event.preventDefault();

        var email = $("#email").val();
        var password = $("#password").val();

        if (email && password) {
            $.ajax({
                type: "POST",
                url: "login_process.php",
                data: {
                    email: email,
                    password: password,
                    csrf_token: $('#csrf_token').val()
                },
                success: function (response) {
                    if (response === "success") {
                        // Redirect to the index page or any other appropriate page
                        window.location.href = "index.html";
                    } else {
                        // Show an error message
                        alert("Invalid email or password.");
                    }
                }
            });
        } else {
            alert("Please fill in both email and password fields.");
        }
    });
});

function checkUserLoggedIn() {
    // You can implement your own logic here to check if the user is logged in
    // For example, you can check if a user session or a cookie exists
    // In this example, we use a simple check on localStorage
    if (!localStorage.getItem("loggedIn")) {
      window.location.href = "login.html";
    }
}
