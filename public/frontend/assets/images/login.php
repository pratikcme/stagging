<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->
    <link href="<?php echo site_url().'files/'; ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="<?php echo site_url().'files/'; ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo site_url().'files/'; ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-stylesheet" />

</head>

<body>

    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="text-center account-logo-box">
                            <div class="mt-2 mb-2">
                                <a href="<?php echo site_url(); ?>" class="text-success">
                                    <span>Admin Panel</span>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">

                            <form method="post" action="<?php echo site_url().'index.php/Admin/login_action'; ?>">

                                <div class="form-group">
                                    <input class="form-control" type="text" name="username" required="" placeholder="Username">
                                </div>

                                <div class="form-group">
                                    <input class="form-control" type="password" required="" id="password" name="password" placeholder="Password">
                                </div>

                                  <?php echo $this->session->flashdata('msg'); ?>

                              

                                <div class="form-group account-btn text-center mt-2">
                                    <div class="col-12">
                                        <button class="btn width-md btn-bordered btn-danger waves-effect waves-light" type="submit">Log In</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->

                   

                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Vendor js -->
    <script src="<?php echo site_url().'files/'; ?>assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="<?php echo site_url().'files/'; ?>assets/js/app.min.js"></script>

</body>

</html>