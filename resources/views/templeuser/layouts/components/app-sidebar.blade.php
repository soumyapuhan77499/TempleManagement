				<!-- main-sidebar -->
				<div class="sticky">
					<aside class="app-sidebar">
						<div class="main-sidebar-header active">
							<a class="header-logo active" href="{{url('index')}}">
								<img src="{{asset('assets/img/brand/logo.png')}}" class="main-logo  desktop-logo" alt="logo">
								<img src="{{asset('assets/img/brand/logo-white.png')}}" class="main-logo  desktop-dark" alt="logo">
								<img src="{{asset('assets/img/brand/favicon.png')}}" class="main-logo  mobile-logo" alt="logo">
								<img src="{{asset('assets/img/brand/favicon-white.png')}}" class="main-logo  mobile-dark" alt="logo">
							</a>
						</div>
						<div class="main-sidemenu">
							<div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
							<ul class="side-menu">
								<li class="side-item side-item-category">Main</li>
								<li class="slide">
									<a class="side-menu__item" data-bs-toggle="slide" href="{{route('templedashboard')}}"><svg xmlns="http://www.w3.org/2000/svg"  class="side-menu__icon" width="24" height="24" viewBox="0 0 24 24"><path d="M3 13h1v7c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2v-7h1a1 1 0 0 0 .707-1.707l-9-9a.999.999 0 0 0-1.414 0l-9 9A1 1 0 0 0 3 13zm7 7v-5h4v5h-4zm2-15.586 6 6V15l.001 5H16v-5c0-1.103-.897-2-2-2h-4c-1.103 0-2 .897-2 2v5H6v-9.586l6-6z"/></svg><span class="side-menu__label">Dashboard</span></a>
								</li>

								<li class="slide">
									<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="{{asset('assets/img/brand/info.png')}}" style="height: 20px;width: 20px" alt="logo"><span class="side-menu__label" style="margin-left: 10px">Temple About</span><i class="angle fe fe-chevron-right"></i></a>
									<ul class="slide-menu">
										{{-- <li class="side-menu__label1"><a href="javascript:void(0);"></a></li> --}}
										<li><a class="slide-item" href="{{route('templeuser.templeAbout')}}">About</a></li>
										<li><a class="slide-item" href="{{route('templeuser.photos')}}">Photos/Videos</a></li>
										<li><a class="slide-item" href="{{route('templeuser.socialmedia')}}">Social Media</a></li>
									
										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">News</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item" href="{{route('templenews.addNews')}}">Add News</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templenews.manageNews')}}">Manage News</a></li>
												
											</ul>
										</li>

										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Inside Temples</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item"  href="{{ route('templeuser.addinsidetemple') }}">Add Temples</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templeuser.manageinsidetemple')}}">Manage Temples</a></li>
												
											</ul>
										</li>

									</ul>
								</li>
								
								<li class="slide">
									<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="{{asset('assets/img/brand/management.png')}}" style="height: 20px;width: 20px" alt="logo"><span class="side-menu__label" style="margin-left: 10px">Temple Manage</span><i class="angle fe fe-chevron-right"></i></a>
									<ul class="slide-menu">
										
										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Trust</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item" href="{{route('templeuser.addtrustmember')}}">Add Trust Member</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templeuser.managetrustmember')}}">Manage Trust Member</a></li>
												
											</ul>
										</li>

										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Committee</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item"  href="{{route('templeuser.addnewcommittee')}}">Create New Committee</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templeuser.addcommitteemember')}}">Add Committee Member</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templeuser.mngcommitteehierarchy')}}">Hierarchy Manage</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templeuser.managecommitteemember')}}">Manage Committee Member</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templeuser.addsubcommittee')}}">Add Sub Committee</a></li>

												
											</ul>
										</li>

									</ul>
								</li>

								<li class="slide">
									<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="{{asset('assets/img/brand/hands.png')}}" style="height: 20px;width: 20px" alt="logo"><span class="side-menu__label" style="margin-left: 10px">Temple Ritual</span><i class="angle fe fe-chevron-right"></i></a>
									<ul class="slide-menu">
										
										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Ritual</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item" href="{{route('templeuser.add-dailyritual')}}">Add Daily Ritual</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templeuser.manage-dailyritual')}}">Manage Daily Ritual</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templeuser.add-yearlyritual')}}">Add Yearly Ritual</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templeuser.manage-yearlyritual')}}">Manage Yearly Ritual</a></li>
											</ul>
										</li>

										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Festivals</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item"  href="{{route('templefestival.addFestival')}}">Add Festival</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templefestival.managefestivals')}}">Manage Festivals</a></li>

											</ul>
										</li>

										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Niti</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item"  href="{{ route('templeuser.add-niti') }}">Add Niti</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templeuser.add-seba')}}">Add Seba</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templeuser.add-sebayat')}}">Add Sebayat</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templeuser.add-deity')}}">Add Deity</a></li>
											</ul>
										</li>
										
										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Panji</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item"  href="{{ route('templeuser.addPanji') }}">Add Panji</a></li>
											</ul>
										</li>
										
									</ul>
								</li>
								
								<li class="slide">
									<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="{{asset('assets/img/brand/pray.png')}}" style="height: 20px;width: 20px" alt="logo"><span class="side-menu__label" style="margin-left: 10px">Temple Darshan</span><i class="angle fe fe-chevron-right"></i></a>
									<ul class="slide-menu">
										<li><a class="slide-item" href="http://onlineq.mandirparikrama.com/" target="_blank">Darshan Booking For Differently Abled</a></li>
										<li><a class="slide-item" href="{{route('add-templedarshan')}}">Add Darshan</a></li>
										<li><a class="slide-item" href="{{route('manage-templedarshan')}}">Manage Darshan</a></li>
									</ul>
								</li>

								<li class="slide">
									<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="{{asset('assets/img/brand/booking.png')}}" style="height: 20px;width: 20px" alt="logo"><span class="side-menu__label" style="margin-left: 10px">Temple Booking</span><i class="angle fe fe-chevron-right"></i></a>
									<ul class="slide-menu">
										
										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Pooja</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item" href="{{route('templepooja.pooja')}}">Add Pooja Booking</a></li>
												<li><a class="sub-side-menu__item"  href="{{route('templepooja.managepooja')}}">Manage Pooja Booking</a></li>
											</ul>
										</li>

										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Mandap</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item" href="{{route('templemandap.mandap')}}">Add Mandap</a></li>
												<li><a class="sub-side-menu__item"  href="{{route('templemandap.managemandap')}}">Manage Mandap</a></li>
																	
											</ul>
										</li>
										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Prasad</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item" href="{{route('templeprasad.prasad')}}">Add Prasad Details</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templeprasad.manageprasad')}}">Manage Prasad</a></li>
																	
											</ul>
										</li>
										

									</ul>
								</li>

								<li class="slide">
									<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="{{asset('assets/img/brand/accounts.png')}}" style="height: 20px;width: 20px" alt="logo"><span class="side-menu__label" style="margin-left: 10px">Temple Finance</span><i class="angle fe fe-chevron-right"></i></a>
									<ul class="slide-menu">
										
										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Bank</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item" href="{{route('templeuser.bankdetails')}}">Add Bank</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templeuser.managebank')}}">Manage Bank</a></li>
																	
											</ul>
										</li>

										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Donations</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item" href="{{route('templedonation.donation')}}">Add Donations</a></li>
												<li><a class="sub-side-menu__item"  href="{{route('templedonation.manage')}}">Manage Donations</a></li>
																	
											</ul>
										</li>
										<li><a class="slide-item" href="#">Manage Income</a></li>
										
										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Expenditure</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item"  href="{{ route('templeuser.addexpenditure') }}">Add Expenditure</a></li>
												<li><a class="sub-side-menu__item"  href="{{route('templeuser.manageexpenditure')}}">Manage Expenditure</a></li>
																	
											</ul>
										</li>

										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Hundi</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item" href="{{route('templeuser.managehundi')}}">Manage Hundi</a></li>
												<li><a class="sub-side-menu__item" href="{{ route('templeuser.addhundicollection') }}">Add Hundi Collection</a></li>
												<li><a class="sub-side-menu__item" href="{{ route('templeuser.reportHundicollection') }}">Hundi Collection Reports</a></li>

																	
											</ul>
										</li>
									

									</ul>
								</li>

								<li class="slide">
									<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="{{asset('assets/img/brand/settings.png')}}" style="height: 20px;width: 20px" alt="logo"><span class="side-menu__label" style="margin-left: 10px">Temple Setting</span><i class="angle fe fe-chevron-right"></i></a>
									<ul class="slide-menu">
										
										<li class="sub-slide">
											<a class="slide-item" data-bs-toggle="sub-slide" href="javascript:void(0);"><span class="sub-side-menu__label">Banners</span><i class="sub-angle fe fe-chevron-down me-4"></i></a>
											<ul class="sub-slide-menu">
												<li><a class="sub-side-menu__item" href="{{route('templebanner.banner')}}">Add Banner</a></li>
												<li><a class="sub-side-menu__item" href="{{route('templebanner.managebanner')}}">Manage Banners</a></li>
																	
											</ul>
										</li>
										
									</ul>
								</li>
								

								<li class="slide">
									<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="{{asset('assets/img/brand/inventory.png')}}" style="height: 20px;width: 20px" alt="logo"><span class="side-menu__label" style="margin-left: 10px">Temple Inventory</span><i class="angle fe fe-chevron-right"></i></a>
									<ul class="slide-menu">
										
										<li><a class="slide-item" href="{{route('templeinventory.mnginventorycategory')}}">Manage Inventory Category</a></li>
										<li><a class="slide-item" href="{{route('templeinventory.inventory')}}">Add Inventory</a></li>
										<li><a class="slide-item" href="{{route('templeinventory.manageinventory')}}">Manage Inventory</a></li>


										
									</ul>
								</li>
								<li class="slide">
									<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="{{asset('assets/img/brand/vendor.png')}}" style="height: 20px;width: 20px" alt="logo"><span class="side-menu__label" style="margin-left: 10px">Temple Vendors</span><i class="angle fe fe-chevron-right"></i></a>
									<ul class="slide-menu">
										<li><a class="slide-item" href="{{route('templeuser.addvendor')}}">Add Vendors</a></li>
										<li><a class="slide-item" href="{{route('templeuser.managevendor')}}">Manage Vendors</a></li>

									</ul>
								</li>
								<li class="slide">
									<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="{{asset('assets/img/brand/cyber-security.png')}}" style="height: 20px;width: 20px" alt="logo"><span class="side-menu__label" style="margin-left: 10px">Temple Security</span><i class="angle fe fe-chevron-right"></i></a>
									{{-- <ul class="slide-menu">
										<li><a class="slide-item" href="{{route('templeuser.addvendor')}}">Add Vendors</a></li>
										<li><a class="slide-item" href="{{route('templeuser.managevendor')}}">Manage Vendors</a></li>

									</ul> --}}
								</li>
								<li class="slide">
									<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="{{asset('assets/img/brand/service.png')}}" style="height: 20px;width: 20px" alt="logo"><span class="side-menu__label" style="margin-left: 10px">Temple Public Seba</span><i class="angle fe fe-chevron-right"></i></a>
									<ul class="slide-menu">
										<li><a class="slide-item" href="{{route('templeuser.manageitems')}}">Manage Items</a></li>
										<li><a class="slide-item" href="{{route('templeuser.managebesha')}}">Manage Besha</a></li>
										<li><a class="slide-item" href="{{route('templeuser.showbesha')}}">Show Besha</a></li>
									</ul>
								</li>
								
								<li class="slide">
									<a class="side-menu__item" href="{{route('templedevotees.managedevotees')}}"><img src="{{asset('assets/img/brand/man.png')}}" style="height: 20px;width: 20px" alt="logo"><span class="side-menu__label" style="margin-left: 10px">Temple Devotees</span></a>
								</li>

								<li class="slide">
									<a class="side-menu__item" href="https://peoplecount.mandirparikrama.com/dashboard" target="_blank"><img src="{{asset('assets/img/brand/counting.png')}}" style="height: 20px;width: 20px" alt="logo"><span class="side-menu__label" style="margin-left: 10px">Temple Devotee Count</span></a>
								</li>


								<li class="slide">
									<a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0);"><img src="{{asset('assets/img/brand/service.png')}}" style="height: 20px;width: 20px" alt="logo"><span class="side-menu__label" style="margin-left: 10px">Temple Feature</span><i class="angle fe fe-chevron-right"></i></a>
									<ul class="slide-menu">
										<li><a class="slide-item" href="{{route('manageparking')}}">Manage Parking</a></li>
										<li><a class="slide-item" href="{{route('manageMatha')}}">Manage Matha</a></li>
										<li><a class="slide-item" href="{{route('manageNijoga')}}">Manage Nijoga</a></li>
										<li><a class="slide-item" href="{{route('manageAccomodation')}}">Manage Accomodation</a></li>
										<li><a class="slide-item" href="{{route('manageNearByTemple')}}">Manage Near BY Temple</a></li>
										<li><a class="slide-item" href="{{route('manageCommute')}}">Manage Commute</a></li>
										<li><a class="slide-item" href="{{route('manageEmergency')}}">Manage Emergency</a></li>
									</ul>
								</li>
								
								
							</ul>

							
							<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
						</div>
					</aside>
				</div>
				<!-- main-sidebar -->
