window.onload = function() {
  var bsInput = document.getElementById("dob_bs");
  var adInput = document.getElementById("dob_ad");
  var bsError = document.getElementById("bsError");
  //var submitBtn = document.getElementById("submitBtn");

  // Initialize Nepali Datepicker on the BS input
  bsInput.nepaliDatePicker();

  // Event listener for BS input field to convert to AD
  bsInput.addEventListener('change', function () {
    var bsDate = bsInput.value;

    // Basic validation: Check if BS date is filled
    if (!bsDate) {
      bsError.style.display = 'inline';
      adInput.value = ''; // Clear AD field
      return;
    } else {
      bsError.style.display = 'none'; // Hide error if date is valid
    }

    // Convert BS date to AD using NepaliFunctions
    var adDateObj = NepaliFunctions.BS2AD(bsDate);

    if (adDateObj) {
      // Format the AD date and display it in the AD input field
      var adDate = `${adDateObj.year}-${('0' + adDateObj.month).slice(-2)}-${('0' + adDateObj.day).slice(-2)}`;
      adInput.value = adDate;
    } else {
      adInput.value = ''; // Clear AD field if conversion fails
      bsError.style.display = 'inline';
    }
  });

  // Submit button to validate the form
  // submitBtn.addEventListener('click', function (e) {
  //   e.preventDefault(); // Prevent actual form submission for now
  //   var bsDate = bsInput.value;
  //   if (!bsDate) {
  //     bsError.style.display = 'inline';
  //   } else {
  //     alert("Form submitted successfully with DOB in BS and AD.");
  //   }
  // });
};
