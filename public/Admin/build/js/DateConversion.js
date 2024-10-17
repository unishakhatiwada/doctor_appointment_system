window.onload = function() {

  // Get the current Nepali date in BS and format it as 'YYYY-MM-DD'
  var currentBsDate = NepaliFunctions.GetCurrentBsDate();
  currentBsDate = NepaliFunctions.ConvertDateFormat(currentBsDate, 'YYYY-MM-DD');

  // Initialize the Nepali Date Picker for the BS field
  $('#date_of_birth_bs').nepaliDatePicker({
    ndpYear: true,
    ndpMonth: true,
    ndpYearCount: 20,
    dateFormat: "YYYY-MM-DD",
    disableAfter: currentBsDate,
    onChange: function() {
      // Convert BS to AD when the date changes
      var bsDate = $('#date_of_birth_bs').val();
      if (bsDate) {
        var adDate = NepaliFunctions.BS2AD(bsDate);
        $('#date_of_birth_ad').val(adDate);
      }
    }
  });

  // If there's an existing BS date (when editing), populate the AD field on load
  var existingBsDate = $('#date_of_birth_bs').val();
  if (existingBsDate) {
    var adDate = NepaliFunctions.BS2AD(existingBsDate);
    $('#date_of_birth_ad').val(adDate);  // Set the converted AD date in the hidden field
  }
};
