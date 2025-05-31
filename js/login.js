$(document).ready(function () {
    $('#loginBtn').click(function (e) {
        e.preventDefault();

        let data = {
            email: $('#email').val(),
            password: $('#password').val()
        };

        $.ajax({
            url: 'php/login.php',
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    localStorage.setItem('userToken', response.token);
                    window.location.href = 'profile.html';
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Login error:", error);
                alert("Login failed due to a server error.");
            }
        });
    });
});
