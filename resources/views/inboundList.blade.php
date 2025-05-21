<!doctype html>
<html lang="en">
  <head>
  	<title>Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
		
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="SideBar/css/style.css">
  </head>
  <body>
		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn btn-primary">
	          <i class="fa fa-bars"></i>
	          <span class="sr-only">Toggle Menu</span>
	        </button>
        </div>
				<div class="p-4 pt-5">
		  		<h1><a href="index.html" class="logo">PT TTLC</a></h1>
	        <ul class="list-unstyled components mb-5">
	          <li class="active">
                  <a href="#">Profile</a>
	          </li>
	          
	          <li>
              <a href="#InboundSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Inbound</a>
              <ul class="collapse list-unstyled" id="InboundSubmenu">
                <li>
                    <a href="#">Inbound</a>
                </li>
                <li>
                    <a href="#">Inbound List</a>
                </li>
              </ul>
	          </li>
			  <li>
              <a href="#OutboundSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Outbound</a>
              <ul class="collapse list-unstyled" id="OutboundSubmenu">
                <li>
                    <a href="#">Outbound</a>
                </li>
                <li>
                    <a href="#">Outbound List</a>
                </li>
              </ul>
	          </li>
	          <li>
              <a href="#">List Stock</a>
	          </li>
	          <li>
              <a href="#">Logout</a>
	          </li>
	          <!-- <li>
              <a href="#">Contact</a>
	          </li> -->
	        </ul>

	        <!-- <div class="mb-5">
						<h3 class="h6">Subscribe for newsletter</h3>
						<form action="#" class="colorlib-subscribe-form">
	            <div class="form-group d-flex">
	            	<div class="icon"><span class="icon-paper-plane"></span></div>
	              <input type="text" class="form-control" placeholder="Enter Email Address">
	            </div>
	          </form>
					</div> -->

	        <div class="footer">
	        	<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
	        </div>

	      </div>
    	</nav>

        <!-- Page Content  -->
		@extends('layouts.app') {{-- atau sesuaikan layoutmu --}}

@section('content')
<div class="container">
    <h2>Data Barcode</h2>

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Waktu Scan</th>
            </tr>
        </thead>
        <tbody>
            <!-- @forelse ($barcodes as $barcode) -->
                <tr>
                    <td>{{ $barcode->id }}</td>
                    <td>{{ $barcode->code }}</td>
                    <td>{{ $barcode->created_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Data belum ada</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

		</div>

    <script src="SideBar/js/jquery.min.js"></script>
    <script src="SideBar/js/popper.js"></script>
    <script src="SideBar/js/bootstrap.min.js"></script>
    <script src="SideBar/js/main.js"></script>
  </body>
</html>