<?php 
include('../user/assets/config/dbconn.php');
include('../user/assets/inc/header.php');
include('../user/assets/inc/sidebar.php');
include('../user/assets/inc/navbar.php');
?> 

<!-- Data info -->
<div class="data-card">
    <div class="card">
        <div class="card-header">
            <h4>Business List</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div id="displayBusinessDataTable">
                        <!-- Business data will be displayed here -->
                    </div>
                </div>
            </div>
            <div id="registrationForm" style="display:none;">
                <!-- Registration form will be dynamically generated here -->
            </div>
        </div>
    </div>
</div>

<?php 
include('../user/assets/inc/footer.php');
?> 

<script>
$(document).ready(function() {
    displayBusinessData(); // Initial load for business data
    setInterval(displayBusinessData, 60000); // Refresh every 60 seconds
});

// Function to fetch business data
function displayBusinessData() {
    $.ajax({
        url: "fetch_business_data.php", // Fetch updated business data
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            let displayHTML = `<table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Business Name</th>
                        <th>Business Address</th>
                        <th>Business Type</th>
                        <th>Period of Date</th>
                        <th>Date of Application</th>
                        <th>Document Status</th> <!-- New Document Status Column -->
                        <th>Permit Expiration</th> <!-- New Permit Expiration Column -->
                        <th>Display Status</th> <!-- New Permit Expiration Column -->
                        <th>Actions</th> <!-- New Actions Column -->
                    </tr>
                </thead>
                <tbody>`;

                data.forEach(business => {
                    displayHTML += `<tr>
                        <td>${business.email}</td>
                        <td>${business.business_name}</td>
                        <td>${business.business_address}</td>
                        <td>${business.business_type}</td>
                        <td>${business.period_date || 'N/A'}</td> <!-- Handle null or empty values -->
                        <td>${business.date_application}</td>
                        <td>${business.document_status || 'Pending'}</td> <!-- Default to 'Pending' if undefined -->
                        <td>${business.permit_expiration || 'N/A'}</td> <!-- Display permit expiration or 'N/A' -->
                        <td>${business.display_status}</td> <!-- Display the calculated status -->
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="actionMenu${business.id}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class='bx bx-dots-vertical-rounded'></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="actionMenu${business.id}">
                                    <a class="dropdown-item" href="view_business.php?id=${business.id}">View</a>
                                    <a class="dropdown-item" href="document_view.php?id=${business.id}">Renew</a>
                                    <a class="dropdown-item" href="document_view.php?id=${business.id}">Document View</a>
                                </div>
                            </div>
                        </td>
                    </tr>`;
                });


            displayHTML += `</tbody></table>`;
            $('#displayBusinessDataTable').html(displayHTML);
        },
        complete: function() {
            setTimeout(displayBusinessData, 60000); // Refresh every 60 seconds
        }
    });
}


// Function to show registration form (if you still need it)
function showRegistrationForm() {
    const formHTML = `
        <h4>Register New Business</h4>
        <form id="newBusinessForm">
            <input type="text" name="lname" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="text" name="business_name" placeholder="Business Name" required>
            <input type="text" name="com_address" placeholder="Commercial Address" required>
            <input type="text" name="date_application" placeholder="Date of Application" required>
            <input type="text" name="period_date" placeholder="Period of Date" required>
            <button type="submit">Submit</button>
        </form>
    `;
    $('#registrationForm').html(formHTML).show();
}

// Event listener for the registration form submission
$(document).on('submit', '#newBusinessForm', function(e) {
    e.preventDefault();
    $.ajax({
        url: 'user_registration_list_displaydata.php', // Your script to process registration
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            alert('Registration successful!');
            displayBusinessData(); // Refresh business list
            $('#registrationForm').hide(); // Hide form after submission
        },
        error: function() {
            alert('Error registering business');
        }
    });
});

// Function to renew business
function renewBusiness(id, element) {
    // Confirm renewal action
    if (confirm('Are you sure you want to renew this business?')) {
        $.ajax({
            url: 'user_renewal_list_displaydata.php', // Your script to process renewal
            type: 'POST',
            data: { id: id },
            success: function(response) {
                alert('Business renewed successfully!');
                displayBusinessData(); // Refresh business list
            },
            error: function() {
                alert('Error renewing business');
            }
        });
    }
}

// Implement functions to edit and save updates if needed
function toggleEdit(id, element) {
    // Toggle edit functionality here
}

function saveUpdate(id, element) {
    // Save update functionality here
}
</script>

</body>
</html> 
