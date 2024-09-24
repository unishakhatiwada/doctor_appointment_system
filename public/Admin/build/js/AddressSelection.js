document.addEventListener('DOMContentLoaded', function () {
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const municipalitySelect = document.getElementById('municipality');

    // Initial setup: Enable district and municipality if values are pre-selected
    if (provinceSelect.value !== "") {
        districtSelect.disabled = false;
    }

    if (districtSelect.value !== "") {
        municipalitySelect.disabled = false;
    }

    // When the province is changed, fetch the respective districts
    provinceSelect.addEventListener('change', function () {
        const provinceId = this.value;

        // Reset district and municipality dropdowns
        districtSelect.disabled = true;
        districtSelect.innerHTML = '<option value="">Select District</option>';
        municipalitySelect.disabled = true;
        municipalitySelect.innerHTML = '<option value="">Select Municipality</option>';

        if (provinceId) {
            fetch(`/districts/${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    districtSelect.disabled = false;
                    districtSelect.innerHTML = '<option value="">Select District</option>';
                    data.forEach(district => {
                        districtSelect.innerHTML += `<option value="${district.id}">${district.district_nepali_name}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching districts:', error));
        }
    });

    // When the district is changed, fetch the respective municipalities
    districtSelect.addEventListener('change', function () {
        const districtId = this.value;

        // Reset municipality dropdown
        municipalitySelect.disabled = true;
        municipalitySelect.innerHTML = '<option value="">Select Municipality</option>';

        if (districtId) {
            fetch(`/municipalities/${districtId}`)
                .then(response => response.json())
                .then(data => {
                    municipalitySelect.disabled = false;
                    municipalitySelect.innerHTML = '<option value="">Select Municipality</option>';
                    data.forEach(municipality => {
                        municipalitySelect.innerHTML += `<option value="${municipality.id}">${municipality.muni_name}</option>`;
                    });
                })
                .catch(error => console.error('Error fetching municipalities:', error));
        }
    });
});
