@extends('templeuser.layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sumoselect/sumoselect.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
@endsection

@section('content')
    <!-- breadcrumb -->

    <!-- row  -->
    <div class="row">
        <div class="col-12 col-sm-12 mt-4">
            <div class="card">
                <div class="card-body pt-0 pt-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    @if (session()->has('success'))
                        <div class="alert alert-success" id="Message">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    @if ($errors->has('danger'))
                        <div class="alert alert-danger" id="Message">
                            {{ $errors->first('danger') }}
                        </div>
                    @endif
                    <form id="hundiCollectionForm" method="POST" action="{{ route('templeuser.savehundicollection') }}">
                        @csrf
                        <div style="background-color: #FFBD5A; padding: 20px; text-align: center;">
                            <!-- Aligning and changing the font style of the H1 tag -->
                            <h1 style="font-family: 'Georgia', serif; font-weight: bold; color: #333;">HUNDI COLLECTION</h1>
                            <!-- Showing today's date and live time -->
                            <p style="font-size: 18px; font-family: 'Courier New', monospace; font-weight: bold;"
                                id="currentDateTime"></p>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="hundi_name">
                                        Hundi Name <span style="color:red">*</span>
                                    </label>
                                    <div class="d-flex align-items-center">
                                        <!-- Hundi Name Select Field -->
                                        <select class="form-control me-2" id="hundi_name" name="hundi_name" required>
                                            <option value="">Select Hundi Name</option>
                                            @foreach ($hundi_names as $hundi)
                                                <option value="{{ $hundi->hundi_name }}">{{ $hundi->hundi_name }}</option>
                                            @endforeach
                                        </select>
                                
                                        <!-- Button to open modal -->
                                        <a class="btn ripple btn-success ms-2" data-bs-target="#popover" data-bs-toggle="modal" href="#">+</a>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="hundi_open_date">Hundi Open Date <span style="color:red">*</span></label>
                                    <input type="date" class="form-control" id="hundi_open_date" name="hundi_open_date"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="present_member">Present Member</label>
                                    <select multiple="multiple" class="testselect2" name="present_member[]">
                                        @foreach ($member_details as $member)
                                            <option value="{{ $member->id }}">{{ $member->member_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="opened_by">Opened By <span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="opened_by" name="opened_by" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <h3 style="font-family: 'Arial', sans-serif; font-weight: bold; color: #333;">CASH TRAY</h3>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">

                                <table class="table table-bordered">

                                    <tbody>
                                        <!-- First Row: Cash Types -->
                                        <tr style="background-color: #4EC2F0;">
                                            <th style="width: 120px;font-weight: bold;font-size: 14px">Cash Type</th>
                                            <td style="font-size: 16px">₹1</td>
                                            <td style="font-size: 16px">₹2</td>
                                            <td style="font-size: 16px">₹5</td>
                                            <td style="font-size: 16px">₹10</td>
                                            <td style="font-size: 16px">₹20</td>
                                            <td style="font-size: 16px">₹50</td>
                                            <td style="font-size: 16px">₹100</td>
                                            <td style="font-size: 16px">₹200</td>
                                            <td style="font-size: 16px">₹500</td>
                                            <td style="font-size: 16px">₹1000</td>
                                        </tr>

                                        <!-- Second Row: Input fields for No of Cash -->
                                        <tr>
                                            <th style="width: 120px;font-weight: bold;font-size: 14px">No of Cash</th>
                                            <td><input type="text" class="form-control" name="cash_1" placeholder="0"
                                                    oninput="validateNumberInput(this)"></td>
                                            <td><input type="text" class="form-control" name="cash_2" placeholder="0"
                                                    oninput="validateNumberInput(this)"></td>
                                            <td><input type="text" class="form-control" name="cash_5" placeholder="0"
                                                    oninput="validateNumberInput(this)"></td>
                                            <td><input type="text" class="form-control" name="cash_10" placeholder="0"
                                                    oninput="validateNumberInput(this)"></td>
                                            <td><input type="text" class="form-control" name="cash_20" placeholder="0"
                                                    oninput="validateNumberInput(this)"></td>
                                            <td><input type="text" class="form-control" name="cash_50"
                                                    placeholder="0" oninput="validateNumberInput(this)"></td>
                                            <td><input type="text" class="form-control" name="cash_100"
                                                    placeholder="0" oninput="validateNumberInput(this)"></td>
                                            <td><input type="text" class="form-control" name="cash_200"
                                                    placeholder="0" oninput="validateNumberInput(this)"></td>
                                            <td><input type="text" class="form-control" name="cash_500"
                                                    placeholder="0" oninput="validateNumberInput(this)"></td>
                                            <td><input type="text" class="form-control" name="cash_1000"
                                                    placeholder="0" oninput="validateNumberInput(this)"></td>
                                        </tr>

                                        <!-- Third Row: Input fields for Total -->
                                        <tr>
                                            <th style="width: 120px;font-weight: bold;font-size: 14px">Total</th>
                                            <td><input type="text" class="form-control" name="total_1"
                                                    placeholder="0" readonly></td>
                                            <td><input type="text" class="form-control" name="total_2"
                                                    placeholder="0" readonly></td>
                                            <td><input type="text" class="form-control" name="total_5"
                                                    placeholder="0" readonly></td>
                                            <td><input type="text" class="form-control" name="total_10"
                                                    placeholder="0" readonly></td>
                                            <td><input type="text" class="form-control" name="total_20"
                                                    placeholder="0" readonly></td>
                                            <td><input type="text" class="form-control" name="total_50"
                                                    placeholder="0" readonly></td>
                                            <td><input type="text" class="form-control" name="total_100"
                                                    placeholder="0" readonly></td>
                                            <td><input type="text" class="form-control" name="total_200"
                                                    placeholder="0" readonly></td>
                                            <td><input type="text" class="form-control" name="total_500"
                                                    placeholder="0" readonly></td>
                                            <td><input type="text" class="form-control" name="total_1000"
                                                    placeholder="0" readonly></td>
                                        </tr>

                                        <!-- Grand Total -->
                                        <tr>
                                            <th style="width: 120px;font-weight: bold;font-size: 14px">Grand Total</th>
                                            <th colspan="10"><input style="font-size: 20px;font-weight: bold"
                                                    type="text" class="form-control" name="grand_total"
                                                    placeholder="0" readonly></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Adding space above the button -->
                        <div class="mt-4 col-md-12 text-center">
                            <button type="button" id="submitButton" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="popover">
        <div class="modal-dialog modal-fullscreen-lg-down" role="document">
            <div class="modal-content  modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add New Hundi</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('templeuser.savehundi') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="hundi_name">Hundi Name <span style="color:red">*</span></label>
                                    <input type="text" class="form-control" id="hundi_name" name="hundi_name"
                                        placeholder="Enter Hundi Name" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description"> Description</label>
                            <textarea name="description" class="form-control" id="description" placeholder="Enter Description"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /row closed -->
@endsection

@section('scripts')
    <!--Internal  Form-elements js-->
    <script src="{{ asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <script src="{{ asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

    {{-- sweet alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Function to validate and allow only numeric input
        function validateNumberInput(input) {
            input.value = input.value.replace(/[^0-9]/g, ''); // Replace any non-numeric character
        }
    </script>

    <script>
        function calculateTotal() {
            let cashTypes = [1, 2, 5, 10, 20, 50, 100, 200, 500, 1000];
            let grandTotal = 0;

            cashTypes.forEach((value, index) => {
                // Get the input field for number of cash
                let cashInput = document.querySelector(`input[name="cash_${value}"]`);
                let cashAmount = parseInt(cashInput.value) || 0;

                // Calculate the total based on cash type and number of cash
                let totalAmount = cashAmount * value;

                // Update the total field for that denomination
                let totalInput = document.querySelector(`input[name="total_${value}"]`);
                totalInput.value = totalAmount;

                // Add to the grand total
                grandTotal += totalAmount;
            });

            // Update the grand total field
            document.querySelector('input[name="grand_total"]').value = grandTotal;
        }

        // Validate input to ensure only numbers are allowed
        function validateNumberInput(input) {
            input.value = input.value.replace(/[^0-9]/g, ''); // Only allow numbers
            calculateTotal(); // Trigger calculation whenever input changes
        }
    </script>
    <script>
        // Function to get the current date and time
        function updateDateTime() {
            const now = new Date();
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const formattedDate = now.toLocaleDateString('en-US', options);
            const formattedTime = now.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true
            });

            // Update the content of the 'currentDateTime' element
            document.getElementById('currentDateTime').textContent = formattedDate + ' ' + formattedTime;
        }

        // Update the time every second
        setInterval(updateDateTime, 1000);

        // Initial call to display the time immediately on page load
        updateDateTime();
    </script>
    {{-- message hide --}}
    <script>
        setTimeout(function() {
            document.getElementById('Message').style.display = 'none';
        }, 3000);
        setTimeout(function() {
            document.getElementById('Messages').style.display = 'none';
        }, 3000);
    </script>

    {{-- sweet alert --}}
    <script>
        document.getElementById('submitButton').addEventListener('click', function(e) {
            // Prevent the default form submission
            e.preventDefault();

            // SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: "Please review the details before submitting!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'Reverify'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Disable form inputs to prevent further editing
                    document.querySelectorAll('#hundiCollectionForm input').forEach(input => {
                        input.setAttribute('readonly', 'readonly');
                    });

                    // SweetAlert Success Message before submission
                    Swal.fire(
                        'Submitting...',
                        'Your form is being submitted!',
                        'success'
                    ).then(() => {
                        // Manually submit the form
                        document.getElementById('hundiCollectionForm').submit();
                    });

                } else {
                    // SweetAlert message for reverify action
                    Swal.fire(
                        'Recheck!',
                        'You can review the form before submitting.',
                        'info'
                    );
                }
            });
        });
    </script>
@endsection
