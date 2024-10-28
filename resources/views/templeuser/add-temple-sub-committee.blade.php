@extends('templeuser.layouts.app')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
	<style>
		.task-card {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
    position: relative;
    transition: background-color 0.3s ease;
}
.task-card:hover {
    background-color: #f9f9f9;
}
.task-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.task-body {
    display: none;
    margin-top: 10px;
}
.task-expanded .task-body {
    display: block;
}
.task-options {
    display: flex;
    gap: 10px;
}
.subtask-list {
    margin-top: 10px;
    padding-left: 20px;
    list-style-type: none;
}
.subtask-item {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
}
.subtask-item input[type="text"] {
    flex: 1;
    margin-right: 5px;
}
</style>

	</style>

@endsection

    @section('content')

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content">
						<span class="main-content-title mg-b-0 mg-b-lg-1">Sub Committee Details</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Sub Committee Details</li>
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->
							@if(session()->has('success'))
							<div class="alert alert-success" id="Message">
								{{ session()->get('success') }}
							</div>
							@endif
						
							@if ($errors->has('danger'))
								<div class="alert alert-danger" id="Message">
									{{ $errors->first('danger') }}
								</div>
							@endif
							  <!-- Display validation errors -->
							@if ($errors->any())
							<div class="alert alert-danger" id="Message">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
							@endif
							<!-- row  -->
							<div class="row">
								<div class="col-12 col-sm-12">
									<div class="card">
										<div class="card-body pt-0 pt-4">
												
											<form method="POST" action="{{ route('templeuser.storesubcommittee') }}" enctype="multipart/form-data">
												@csrf
												<div class="row">
													<!-- Committee Name -->
													<div class="col-md-4">
														<div class="form-group">
															<label for="sub_committee_name">Name Of Committee <span style="color:red">*</span></label>
															<input type="text" class="form-control" id="sub_committee_name" name="sub_committee_name" value="">
														</div>
													</div>
											
													<!-- Select Members -->
													<div class="col-md-3">
														<div class="form-group">
															<label for="select_member">Select Member <span style="color:red">*</span></label>
															<select class="form-control select2" id="select_member" name="members[]" multiple="multiple" required>
																@foreach($committeeMembers as $member)
																	<option value="{{ $member->id }}">{{ $member->member_name }}</option>
																@endforeach
															</select>
														</div>
													</div>
											
													<!-- Add Another Member Button -->
													<div class="col-md-2 mt-4">
														<a class="btn ripple btn-success ms-2" data-bs-target="#popover" data-bs-toggle="modal" href="#"><i class="fas fa-plus"></i> Add Member</a>
													</div>
													<div class="col-md-3 ">
														<div class="form-group">
															<label for="creation_date">Date of Creation</label>
															<input type="date" class="form-control" id="creation_date" name="creation_date" value="{{ old('creation_date') }}">
														</div>
													</div>
											
													<!-- Description Field -->
													<div class="col-md-12 mt-3">
														<div class="form-group">
															<label for="description">Description</label>
															<textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter a description for the committee..."></textarea>
														</div>
													</div>
											
													<!-- Date of Creation Field -->
												
											
													<!-- Create Task Section -->
													<div class="col-md-12 mt-4">
														<h5>Create Task</h5>
														<div id="task-list" class="task-list">
															<!-- Task Card Template -->
														</div>
											
														<!-- Add Task Button -->
														<button type="button" class="btn btn-outline-primary mt-2" id="add-task"><i class="fas fa-plus"></i> Add Task</button>
													</div>
											
													<!-- Submit Button -->
													<div class="col-md-12 mt-4">
														<button type="submit" class="btn btn-primary">Submit</button>
													</div>
												</div>
											</form>
											
										</div>
									</div>
								
								</div>
							</div>
							<!-- /row closed -->

							<div class="modal fade" id="popover">
								<div class="modal-dialog modal-fullscreen-lg-down" role="document">
									<div class="modal-content  modal-content-demo">
										<div class="modal-header">
											<h6 class="modal-title">Add New Member</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
										</div>
										<div class="modal-body">
											<form method="POST" enctype="multipart/form-data" action="{{url('/templeuser/store-other-member')}}" id="committeeForm">
												@csrf
												@method('POST')
												<div class="card">
													<div class="col-md-6" style="display: none">
														<div class="form-group">
															<label for="committee_id">Committee ID <span style="color:red">*</span></label>
															<input type="text" class="form-control" id="committee_id" name="committee_id" 
																value="{{ old('committee_id', $committeedetails->committee_id ?? '') }}" readonly>
														</div>
														<div class="form-group">
															<label for="committee_creation_date">Committee Creation Date <span style="color:red">*</span></label>
															<input type="date" class="form-control" id="committee_creation_date" name="committee_creation_date" 
																value="{{ old('committee_creation_date', $committeedetails->committee_creation_date ?? '') }}" readonly>
														</div>
													</div>
													<div class="card-body pt-0">
														<div class="row">
															<!-- Member Name -->
															<div class="col-md-6">
																<div class="form-group">
																	<label for="member_name">Member Name <span style="color:red">*</span></label>
																	<input type="text" class="form-control" id="member_name" name="member_name" value="{{ old('member_name') }}" required>
																</div>
															</div>
															<!-- DOB -->
															<div class="col-md-6">
																<div class="form-group">
																	<label for="dob">DOB <span style="color:red">*</span></label>
																	<input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}" required>
																</div>
															</div>
														</div>
														<div class="row">
															<!-- Member Designation -->
															<div class="col-md-6">
																<div class="form-group">
																	<label for="member_designation">Profession <span style="color:red">*</span></label>
																	<input type="text" class="form-control" id="member_designation" name="member_designation" value="{{ old('member_designation') }}" required>
																</div>
															</div>
															<!-- Temple Designation -->
															<div class="col-md-6">
																<div class="form-group">
																	<label for="temple_designation">Temple Designation <span style="color:red">*</span></label>
																	<input type="text" class="form-control" id="temple_designation" name="temple_designation" value="{{ old('temple_designation') }}" required>
																</div>
															</div>
														</div>
														<div class="row">
															<!-- Contact Number -->
															<div class="col-md-4">
																<div class="form-group">
																	<label for="member_contact_no">Contact Number <span style="color:red">*</span></label>
																	<input type="text" class="form-control" id="member_contact_no" name="member_contact_no" value="{{ old('member_contact_no') }}" required pattern="\d{10}" title="Must be 10 digits">
																</div>
															</div>
															<!-- WhatsApp Number -->
															<div class="col-md-4">
																<div class="form-group">
																	<label for="whatsapp_number">WhatsApp Number <span style="color:red">*</span></label>
																	<input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number') }}" required pattern="\d{10}" title="Must be 10 digits">
																</div>
															</div>
															<!-- Email -->
															<div class="col-md-4">
																<div class="form-group">
																	<label for="email">Email Id</label>
																	<input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
																</div>
															</div>
														</div>
														<div class="row">
															<!-- About Member -->
															<div class="col-md-12">
																<div class="form-group">
																	<label for="about_member">About </label>
																	<textarea name="about_member" class="form-control" id="about_member" cols="30" rows="3">{{ old('about_member') }}</textarea>
																</div>
															</div>
														</div>
														<div class="row mt-2">
															<!-- Member Photo -->
															<div class="col-md-12">
																<div class="form-group">
																	<label for="member_photo">Member Photo <span style="color:red">*</span></label>
																	<input type="file" class="form-control" id="member_photo" name="member_photo" required>
																</div>
															</div>
														</div>
														<button type="submit" class="btn btn-primary mt-3">Submit</button>
													</form>
										</div>
										<div class="modal-footer">
											<button class="btn ripple btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
										</div>
									</div>
								</div>
							</div>

    @endsection

	@section('scripts')


	<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
	<script src="{{ asset('assets/js/select2.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
 {{-- sweet alert --}}
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <script>
document.addEventListener("DOMContentLoaded", function() {
    let taskIndex = 1;

    // Add New Task
    document.getElementById("add-task").addEventListener("click", function() {
        const taskList = document.getElementById("task-list");
        const taskCard = document.createElement("div");
        taskCard.classList.add("task-card", "task-expanded");

        taskCard.innerHTML = `
            <div class="task-header">
                <input type="text" name="tasks[${taskIndex}][name]" class="form-control border-0" placeholder="Task Name" required>
                <button type="button" class="btn btn-light btn-sm toggle-task"><i class="fas fa-chevron-up"></i></button>
            </div>
            <div class="task-body">
                <textarea name="tasks[${taskIndex}][description]" class="form-control mt-2" rows="2" placeholder="Describe the task here..."></textarea>

                <!-- Priority and Due Date -->
                <div class="task-options mt-2">
                    <select name="tasks[${taskIndex}][priority]" class="form-control">
                        <option value="" disabled selected>Priority</option>
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low">Low</option>
                    </select>
                    <input type="date" name="tasks[${taskIndex}][due_date]" class="form-control" placeholder="Due Date">
                </div>

                <!-- Subtask List -->
                <div class="subtask-list mt-3">
                    <h6>Subtasks</h6>
                    <ul id="subtask-list-${taskIndex}" class="subtask-list"></ul>
                    <button type="button" class="btn btn-outline-secondary btn-sm add-subtask" data-index="${taskIndex}"><i class="fas fa-plus"></i> Add Subtask</button>
                </div>

                <!-- Delete Task Button -->
                <button type="button" class="btn btn-danger btn-sm mt-3 remove-task"><i class="fas fa-trash-alt"></i> Delete Task</button>
            </div>
        `;

        taskList.appendChild(taskCard);
        taskIndex++;
    });

    // Toggle Task Body Visibility
    document.getElementById("task-list").addEventListener("click", function(e) {
        if (e.target.closest(".toggle-task")) {
            const taskCard = e.target.closest(".task-card");
            taskCard.classList.toggle("task-expanded");
            e.target.innerHTML = taskCard.classList.contains("task-expanded") ? '<i class="fas fa-chevron-up"></i>' : '<i class="fas fa-chevron-down"></i>';
        }

        // Remove Task
        if (e.target.closest(".remove-task")) {
            e.target.closest(".task-card").remove();
        }

        // Add Subtask
        if (e.target.closest(".add-subtask")) {
            const index = e.target.getAttribute("data-index");
            const subtaskList = document.getElementById(`subtask-list-${index}`);
            const subtaskItem = document.createElement("li");
            subtaskItem.classList.add("subtask-item");
            subtaskItem.innerHTML = `
                <input type="text" name="tasks[${index}][subtasks][]" class="form-control form-control-sm" placeholder="Subtask Name">
                <button type="button" class="btn btn-sm btn-light remove-subtask"><i class="fas fa-times"></i></button>
            `;
            subtaskList.appendChild(subtaskItem);
        }

        // Remove Subtask
        if (e.target.closest(".remove-subtask")) {
            e.target.closest(".subtask-item").remove();
        }
    });
});

 </script>

 <script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('committeeForm');
    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission
            
            // Create form data object
            const formData = new FormData(form);

            // AJAX request to submit the form
            fetch(form.action, {
                method: form.method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                // Check if response is JSON
                if (response.ok) {
                    return response.json();
                } else {
                    return response.text().then(text => { throw new Error(text); });
                }
            })
            .then(data => {
                if (data.success) {
                    $('#popover').modal('hide');
                    const memberDropdown = document.getElementById('select_member');
                    const newOption = new Option(data.member_name, data.member_id, false, false);
                    memberDropdown.add(newOption);
                    form.reset();
                    alert('Member added successfully!');
                } else {
                    alert('Failed to add member. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred: ' + error.message);
            });
        });
    }
});


 </script>
    @endsection
