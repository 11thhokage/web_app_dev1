
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Register</title>
    <style>
            .gradient-custom-2 {
        /* fallback for old browsers */
        background: #fccb90;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
        }
        .invalid-feedback {
          display: none;
          color: red;
          margin-top: 5px;
        }

        @media (min-width: 768px) {
        .gradient-form {
        height: 100vh !important;
        }
        }
        @media (min-width: 769px) {
        .gradient-custom-2 {
        border-top-right-radius: .3rem;
        border-bottom-right-radius: .3rem;
        }
        }
    </style>
</head>
<body>
<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                    <h4 class="mb-4">We are not your typical drug store</h4>
                    <p class="small mb-0">But we only sell Legal Drugs.</p>
                </div>
            </div>
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="../img/drug_store_logo.jpg"
                    style="width: 185px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1">Welcome to Drug Store</h4>
                  <h4 class="mt-1 mb-5 pb-1">We Sell Drugs</h4>
                </div>

                <form class="needs-validation" novalidate method="POST" action="../actions/register.php">
                  <p>Please login to your account</p>

                  <div class="form-outline mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input type="email" name="username" id="username" class="form-control" placeholder="Enter a Username" required />
                  </div>

                  <div class="form-outline mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                  </div>

                  <div class="form-outline mb-3">
                    <label class="form-label" for="cpassword">Confirm Password</label>
                    <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirm Password" required />
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Register</button>
                  </div>

                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Already have an account?</p>
                    <a href="../pages/login_form.php" type="button" class="btn btn-outline-danger">Login Now</a>
                  </div>
                </form>

              </div>
            </div>
           
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php
include "../css/footer.php";
?>
