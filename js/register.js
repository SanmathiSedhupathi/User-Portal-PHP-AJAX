$(document).ready(function () {
    $('#registerBtn').click(function (e) {
        e.preventDefault();

        let data = {
            username: $('#username').val(),
            email: $('#email').val(),
            password: $('#password').val()
        };

        $.ajax({
            url: 'php/register.php',
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                alert(response.message);
                if (response.success) {
                    window.location.href = 'index.html'; // or login.html
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Something went wrong.");
            }
        });
    });
});
