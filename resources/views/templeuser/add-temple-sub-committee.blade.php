@extends('templeuser.layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">

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
												
											<form method="POST" action="{{route('templeuser.storesubcommittee')}}" enctype="multipart/form-data">
												@csrf
												@method('POST')
												<div class="row">
													<div class="form-group" style="display: none">
														<label for="committee_id">Committee ID <span style="color:red">*</span></label>
														<input type="text" class="form-control" id="committee_id" name="committee_id" 
															value="{{ old('committee_id', $committeedetails->committee_id ?? '') }}" readonly>
													</div>
													<div class="col-md-4">
														<div class="form-group">
															<label for="committee_name">Name Of Committee <span style="color:red">*</span></label>
															<input type="text" class="form-control" id="sub_committee_name" name="sub_committee_name" value="">
														</div>
													</div>
													<div class="col-md-5">
														<div class="form-group">
															<label for="select_member">Select Member <span style="color:red">*</span></label>
															<select class="form-control select2" id="select_member" name="members[]" multiple="multiple" required>
																@foreach($committeeMembers as $member)
																	<option value="{{ $member->id }}">{{ $member->member_name }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="col-md-3 mt-4">
														<a class="btn ripple btn-success ms-2" data-bs-target="#popover" data-bs-toggle="modal" href="#">Add Another Member</a>
													</div>
												</div>
												<button type="submit" class="btn btn-primary">Submit</button>
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
											<form method="POST" enctype="multipart/form-data" action="{{route('templeuser.storeothermember')}}" id="committeeForm">
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
    @endsection
