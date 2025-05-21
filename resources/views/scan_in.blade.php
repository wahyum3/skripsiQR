<!doctype html>
<html lang="en">
  <head>
  	<title>Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">


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
      <div id="content" class="p-4 p-md-5 pt-5">

	  <div id="reader" style="width: 300px;"></div>
<p id="scan-result" class="mt-3"></p>

<h2>Scan Barcode</h2>
    <div id="reader" style="width: 300px;"></div>
    <div id="scan-result"></div>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        document.getElementById('scan-result').innerText = `QR Code terdeteksi: ${decodedText}`;
        // Kamu bisa redirect atau kirim data ke server di sini
        // window.location.href = `/proses/${decodedText}`;
        // Kirim ke server Laravel
      fetch('/scan-in', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            kode_qr: decodedText
        })
      })
      .then(response => response.json())
      .then(data => {
        console.log(data);
        alert("QR berhasil disimpan!");
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }

    function startScanner() {
        const html5QrCode = new Html5Qrcode("reader");

        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                // Pilih kamera belakang jika ada
                let backCamera = devices.find(device => device.label.toLowerCase().includes('back')) || devices[0];

                html5QrCode.start(
                    backCamera.id,
                    {
                        fps: 10,
                        qrbox: 250
                    },
                    onScanSuccess
                );
            }
        }).catch(err => {
            console.error("Camera error:", err);
        });
    }

    // Auto start scanner saat halaman dibuka
    window.addEventListener('load', startScanner);
</script>
      </div>
		</div>

    <script src="SideBar/js/jquery.min.js"></script>
    <script src="SideBar/js/popper.js"></script>
    <script src="SideBar/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
	<script src="SideBar/js/main.js"></script>
  </body>
</html>