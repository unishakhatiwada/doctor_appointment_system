// Define the initializeNepaliDatePicker globally by attaching it to the window object
window.initializeNepaliDatePicker = function(bsSelector, adSelector) {
  var currentBsDate = NepaliFunctions.GetCurrentBsDate();
  currentBsDate = NepaliFunctions.ConvertDateFormat(currentBsDate, 'YYYY-MM-DD');

  $(bsSelector).each(function() {
    var $bsInput = $(this);
    var $adInput = $(adSelector);

    $bsInput.nepaliDatePicker({
      ndpYear: true,
      ndpMonth: true,
      ndpYearCount: 20,
      dateFormat: "YYYY-MM-DD",
      disableAfter: currentBsDate,
      onChange: function() {
        var bsDate = $bsInput.val();
        if (bsDate) {
          var adDate = NepaliFunctions.BS2AD(bsDate);
          $adInput.val(adDate);  // Update the hidden AD field
        }
      }
    });

    // If editing, populate the BS input from existing AD date
    var existingBsDate = $bsInput.val();
    if (existingBsDate) {
      var adDate = NepaliFunctions.BS2AD(existingBsDate);
      $adInput.val(adDate);  // Set the converted AD date in the hidden field
    }
  });
};

// Inside window.onload to handle the initial date picker setups
window.onload = function() {
  // Initialize the Date Picker for the Doctor's Date of Birth
  initializeNepaliDatePicker('#date_of_birth_bs', '#date_of_birth_ad');

  // Initialize for Education Joining Date and Graduation Date
  initializeNepaliDatePicker('.education-joining-date-bs', '.education-joining-date-ad');
  initializeNepaliDatePicker('.education-graduation-date-bs', '.education-graduation-date-ad');

  // Initialize for Experience Start Date and End Date
  initializeNepaliDatePicker('.experience-start-date-bs', '.experience-start-date-ad');
  initializeNepaliDatePicker('.experience-end-date-bs', '.experience-end-date-ad');
};
