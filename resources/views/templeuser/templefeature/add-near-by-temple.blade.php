<div class="col-md-4">
    <div class="form-group">
        <label for="state">State</label>
        <select class="form-control" id="state" name="state">
            <option value="">Select State</option>
        </select>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="district">District</label>
        <input type="text" class="form-control" id="district" name="district" placeholder="Enter district">
    </div>
</div>
  <!-- Load JavaScript -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Fetch and Populate Country Dropdown
        fetch("{{ route('get.countries') }}")
            .then(response => response.json())
            .then(data => {
                let countryDropdown = document.getElementById("country");
                countryDropdown.innerHTML = '<option value="">Select Country</option>'; 
                data.forEach(country => {
                    let option = document.createElement("option");
                    option.value = country.id; // Use country ID
                    option.textContent = country.name;
                    countryDropdown.appendChild(option);
                });
            })
            .catch(error => console.error("Error fetching countries:", error));
    
        // Fetch and Populate State Dropdown based on Selected Country
        document.getElementById("country").addEventListener("change", function () {
            let countryId = this.value;
            let stateDropdown = document.getElementById("state");
            stateDropdown.innerHTML = '<option value="">Select State</option>'; // Reset
    
            if (countryId) {
                fetch(`{{ url('/get-states') }}/${countryId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(state => {
                            let option = document.createElement("option");
                            option.value = state.id;
                            option.textContent = state.name;
                            stateDropdown.appendChild(option);
                        });
                    })
                    .catch(error => console.error("Error fetching states:", error));
            }
        });
    });
    </script>