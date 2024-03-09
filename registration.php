<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/index.css">

</head>
<body>

    <!-- Navigation bar -->
    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="aboutme.html">About</a></li>
            <li><a href="resume.html">Resume</a></li>
            <li><a href="faq.html">FAQ</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="feedbacks.php">Feedbacks</a></li>
        </ul>
    </nav>
        <div class="feedbacks-container">
            <div class="transparent-box">
                <div class="container">
                    <form action="process_registration.php" method="post">
                        <h2>Registration</h2>
                        <h3>Full Name</h3>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name" required>
                        </div>
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter First Name" required>
                        </div>

                        <h3>Address</h3>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select class="form-control" id="country" name="country" required>
                                <option selected>Choose...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="state">State/Province</label>
                            <select class="form-control" id="state" name="state" required>
                                <option selected>Choose...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">City/Municipality</label>
                            <select class="form-control" id="city" name="city" required>
                                <option selected>Choose...</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="lotBlk">Lot/Block</label>
                            <input type="text" class="form-control" id="lotBlk" name="lotBlk" placeholder="Enter Lot/Block" required>
                        </div>
                        <div class="form-group">
                            <label for="street">Street</label>
                            <input type="text" class="form-control" id="street" name="street" placeholder="Enter Street" required>
                        </div>
                        <div class="form-group">
                            <label for="phaseSubdivision">Phase/Subdivision</label>
                            <input type="text" class="form-control" id="phaseSubdivision" name="phaseSubdivision" placeholder="Enter Phase/Subdivision" required>
                        </div>
                        <div class="form-group">
                            <label for="barangay">Barangay</label>
                            <input type="text" class="form-control" id="barangay" name="barangay" placeholder="Enter Barangay" required>
                        </div>
                        <div class="form-group">
                            <label for="contactNumber">Contact Number</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="phoneCode" readonly>
                                <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="Enter Contact Number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="repeatPassword">Repeat Password</label>
                            <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" placeholder="Repeat Password">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                        
                    </form>
                    
                    <?php

                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }

                    ?>

                </div>
            </div>
        </div>

    <footer>
    <p>© 2024 Kozer. All rights reserved.</p>
    </footer>


<script>

let data = [];

document.addEventListener('DOMContentLoaded', function() {
    fetch('https://raw.githubusercontent.com/dr5hn/countries-states-cities-database/master/countries%2Bstates%2Bcities.json')
        .then(response => response.json())
        .then(jsonData => {
            data = jsonData;
            const countries = data.map(country => country.name);
            populateDropdown('country', countries);
        })
        .catch(error => console.error('Error fetching countries:', error));
});

function populateDropdown(dropdownId, data) {
    const dropdown = document.getElementById(dropdownId);
    dropdown.innerHTML = '';
    data.forEach(item => {
        const option = document.createElement('option');
        option.value = item;
        option.text = item;
        dropdown.add(option);
    });
}

document.getElementById('country').addEventListener('change', function() {
    const selectedCountry = this.value;
    const countryData = data.find(country => country.name === selectedCountry);
    if (countryData && countryData.states) {
        const states = countryData.states.map(state => state.name);
        populateDropdown('state', states);
    }
    const phoneCode = countryData ? countryData.phone_code : '';
    document.getElementById('phoneCode').value = phoneCode;
});

document.getElementById('state').addEventListener('change', function() {
    const selectedState = this.value;
    const countryData = data.find(country => country.name === document.getElementById('country').value);
    if (countryData) {
        const stateData = countryData.states.find(state => state.name === selectedState);
        if (stateData && stateData.cities) {
            const cities = stateData.cities.map(city => city.name);
            populateDropdown('city', cities);
        } else {
            console.log('No cities found for state:', selectedState);
        }
    } else {
        console.log('Country data not found for state:', selectedState);
    }
});

</script>

</body>
</html>
