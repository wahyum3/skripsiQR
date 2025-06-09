<!doctype html>
<html lang="en">
  <head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('LoginTemplate/css/style.css') }}">
  </head>
  <body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-5">
					<div class="login-wrap p-4 p-md-5">
		      	<div class="icon d-flex align-items-center justify-content-center">
		      		<span class="fa fa-user-o"></span>
		      	</div>
		      	<h3 class="text-center mb-4">Have an account?</h3>
				<form method="POST" action="{{ route('login') }}">
					@csrf
					<div class="form-group">
						<input type="email" name="email" class="form-control rounded-left" placeholder="Email" required autofocus>
					</div>
					<div class="form-group d-flex">
						<input type="password" name="password" class="form-control rounded-left" placeholder="Password" required>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary rounded submit p-3 px-5">Login</button>
					</div>
                    <div id="emailHelp" class="form-text text-center mb-5 text-dark">Not
                        Registered? <a href="#" class="text-dark fw-bold"> Create an
                        Account</a>
                    </div>
				</form>
	        </div>
				</div>
			</div>
		</div>
	</section>
  </body>
</html>

