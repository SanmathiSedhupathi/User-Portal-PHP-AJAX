$(document).ready(function () {
    let token = localStorage.getItem('userToken');
    if (!token) {
        window.location.href = 'index.html';
        return;
    }

    // Disable future dates in the DOB input
    let today = new Date().toISOString().split('T')[0];
    $('#dob').attr('max', today);

    // Fetch user data
    $.ajax({
        url: 'php/getProfile.php',
        type: 'POST',
        data: JSON.stringify({ token: token }),
        contentType: 'application/json',
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                $('#username').val(response.data.username);
                $('#email').val(response.data.email);
                $('#age').val(response.data.age);
                $('#dob').val(response.data.dob);
                $('#contact').val(response.data.contact);
            } else {
                alert(response.message);
                window.location.href = 'index.html';
            }
        },
        error: function () {
            alert("Failed to load profile data.");
        }
    });

    // Validation function
    function validateProfile(age, dob, contact) {
        // Validate age: number between 1 and 120
        if (!age || isNaN(age) || age < 1 || age > 120) {
            alert("Please enter a valid age between 1 and 120.");
            return false;
        }

        // Validate dob: valid date and not future date
        let dobDate = new Date(dob);
        let now = new Date();
        if (!dob || isNaN(dobDate.getTime())) {
            alert("Please enter a valid date of birth.");
            return false;
        }
        if (dobDate > now) {
            alert("Date of birth cannot be in the future.");
            return false;
        }

        // Validate contact: simple phone validation (digits only, length 10-15)
        let phoneRegex = /^\d{10,15}$/;
        if (!contact || !phoneRegex.test(contact)) {
            alert("Please enter a valid contact number (10 to 15 digits).");
            return false;
        }

        return true;
    }

    // Update profile button click handler
    $('#updateBtn').click(function (e) {
        e.preventDefault();

        let age = $('#age').val().trim();
        let dob = $('#dob').val().trim();
        let contact = $('#contact').val().trim();

        if (!validateProfile(age, dob, contact)) {
            return; // Stop update if validation fails
        }

        let data = {
            token: token,
            age: age,
            dob: dob,
            contact: contact
        };

        $.ajax({
            url: 'php/updateProfile.php',
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            dataType: 'json',
            success: function (response) {
                alert(response.message);
            },
            error: function () {
                alert("Update failed.");
            }
        });
    });

    // Logout button handler
    $('#logoutBtn').click(function () {
        localStorage.clear();
        window.location.href = 'index.html';
    });
});
