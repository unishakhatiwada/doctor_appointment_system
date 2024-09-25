document.addEventListener('DOMContentLoaded', function () {
    // Permanent Address Select Elements
    const permanentProvinceSelect = document.getElementById('permanent_province');
    const permanentDistrictSelect = document.getElementById('permanent_district');
    const permanentMunicipalitySelect = document.getElementById('permanent_municipality');

    // Temporary Address Select Elements
    const temporaryProvinceSelect = document.getElementById('temporary_province');
    const temporaryDistrictSelect = document.getElementById('temporary_district');
    const temporaryMunicipalitySelect = document.getElementById('temporary_municipality');

    // Permanent Address Logic
    if (permanentProvinceSelect.value !== "") {
        permanentDistrictSelect.disabled = false;
    }

    if (permanentDistrictSelect.value !== "") {
        permanentMunicipalitySelect.disabled = false;
    }

    permanentProvinceSelect.addEventListener('change', function () {
        const provinceId = this.value;

        // Reset district and municipality dropdowns
        permanentDistrictSelect.disabled = true;
        permanentDistrictSelect.innerHTML = '<option value="">Select District</option>';
        permanentMunicipalitySelect.disabled = true;
        permanentMunicipalitySelect.innerHTML = '<option value="">Select Municipality</option>';

        if (provinceId) {
            fetch(`/districts/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    permanentDistrictSelect.disabled = false;
                    permanentDistrictSelect.innerHTML = '<option value="">Select District</option>';
                    data.forEach(district => {
                        permanentDistrictSelect.innerHTML += `<option value="${district.id}">${district.district_nepali_name}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching districts:', error));
        }
    });

    permanentDistrictSelect.addEventListener('change', function () {
        const districtId = this.value;

        // Reset municipality dropdown
        permanentMunicipalitySelect.disabled = true;
        permanentMunicipalitySelect.innerHTML = '<option value="">Select Municipality</option>';

        if (districtId) {
            fetch(`/municipalities/${districtId}`)
                .then(response => response.json())
                .then(data => {
                    permanentMunicipalitySelect.disabled = false;
                    permanentMunicipalitySelect.innerHTML = '<option value="">Select Municipality</option>';
                    data.forEach(municipality => {
                        permanentMunicipalitySelect.innerHTML += `<option value="${municipality.id}">${municipality.muni_name}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching municipalities:', error));
        }
    });

    // Temporary Address Logic
    if (temporaryProvinceSelect.value !== "") {
        temporaryDistrictSelect.disabled = false;
    }

    if (temporaryDistrictSelect.value !== "") {
        temporaryMunicipalitySelect.disabled = false;
    }

    temporaryProvinceSelect.addEventListener('change', function () {
        const provinceId = this.value;

        // Reset district and municipality dropdowns
        temporaryDistrictSelect.disabled = true;
        temporaryDistrictSelect.innerHTML = '<option value="">Select District</option>';
        temporaryMunicipalitySelect.disabled = true;
        temporaryMunicipalitySelect.innerHTML = '<option value="">Select Municipality</option>';

        if (provinceId) {
            fetch(`/districts/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    temporaryDistrictSelect.disabled = false;
                    temporaryDistrictSelect.innerHTML = '<option value="">Select District</option>';
                    data.forEach(district => {
                        temporaryDistrictSelect.innerHTML += `<option value="${district.id}">${district.district_nepali_name}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching districts:', error));
        }
    });

    temporaryDistrictSelect.addEventListener('change', function () {
        const districtId = this.value;

        // Reset municipality dropdown
        temporaryMunicipalitySelect.disabled = true;
        temporaryMunicipalitySelect.innerHTML = '<option value="">Select Municipality</option>';

        if (districtId) {
            fetch(`/municipalities/${districtId}`)
                .then(response => response.json())
                .then(data => {
                    temporaryMunicipalitySelect.disabled = false;
                    temporaryMunicipalitySelect.innerHTML = '<option value="">Select Municipality</option>';
                    data.forEach(municipality => {
                        temporaryMunicipalitySelect.innerHTML += `<option value="${municipality.id}">${municipality.muni_name}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching municipalities:', error));
        }
    });
});
