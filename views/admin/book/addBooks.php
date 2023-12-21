<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>BookShop dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="https://fonts.googleapis.com/css2?family=Paytone+One&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="../../../public/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../../../public/css/dashboard.css" rel="stylesheet">
</head>

<body>
    <style>
        .cube {
            height: 10vh !important;

        }

        .card {
            width: 100%;
            border: none;
            background-color: transparent;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card img {
            width: 200px;
            border-radius: 50%;
            object-fit: cover;
        }

        .card label {
            margin-top: 30px;
            text-align: center;
            height: 40px;
            cursor: pointer;
            font-weight: bold;
            margin-bottom: 20px;
            color: white;
        }

        .form-input-label,
        .form-label {
            color: white;

        }

        .card input {
            display: none;
        }
    </style>
    <div class="container-xxl position-relative bg-white d-flex p-0">

        <div class="sidebar pe-4 pb-3">
            <nav style="background: #28323A;" class="navbar bg-light navbar-light">
                <a href="../dashboard.php" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary">DASHMIN</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="../../../public/images/user.png" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                        </div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?= $_SESSION['name'] ?></h6>
                        <span>Admin</span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="../dashboard.php" class="nav-item nav-link" id="dashboard-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                    <a href="showBooks.php" class="nav-item nav-link active "><i class="fa fa-tachometer-alt me-2"></i>Books</a>
                </div>

            </nav>
        </div>


        <div class="content">
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="dashboard.php" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-home"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>

                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-envelope me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Message</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <div class="d-flex align-items-center">
                                    <img class="rounded-circle" src="../../../public/images/user.png" alt="" style="width: 40px; height: 40px;">
                                    <div class="ms-2">
                                        <h6 class="fw-normal mb-0">User-name send you a message</h6>
                                        <small>15 minutes ago</small>
                                    </div>
                                </div>
                            </a>

                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all message</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Notificatin</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Profile updated</h6>
                                <small>15 minutes ago</small>
                            </a>

                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">See all notifications</a>
                        </div>
                    </div>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="../../../public/images/user.png" alt="" style="width: 40px; height: 40px;">
                            <span class="d-none d-lg-inline-flex"><?= $_SESSION['name'] ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">My Profile</a>
                            <a href="#" class="dropdown-item">Log Out</a>
                        </div>
                    </div>
                </div>
            </nav>



            <div class="container-fluid pt-4 px-4" id="content">
                <div class="container-fluid pt-4 px-4">
                    <div class="row g-4">
                        <div class="col-sm-12 col-xl-12">
                            <div class="bg-dark text-center rounded p-4">

                                <div class="container d-flex justify-content-center" style="margin-top:5%;">
                                    <form method="POST" action="../../../App/Controllers/BookController.php" enctype="multipart/form-data" style="width:50vw; min-width:300px;">
                                        <div class="card">
                                            <img src="../../../public/images/book.jpg" alt="image" id="image">
                                            <label for="input-file">Choose Image</label>
                                            <input type="file" accept="image/jpg , image/png , image/jpeg" id="input-file" name="photo" required>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label">Title</label>
                                                <input type="text" class="form-control" name="title" placeholder="name of the book" required>
                                            </div>

                                            <div class="col">
                                                <label class="form-label">author:</label>
                                                <input type="text" class="form-control" name="author" placeholder="author" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">genre:</label>
                                            <input type="text" class="form-control" name="genre" placeholder="genre of the book" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">description:</label>
                                            <input type="text" class="form-control" name="description" placeholder="description of the book" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">publication year:</label>
                                            <input type="date" class="form-control" name="publication_year" placeholder="publication year" required>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <label class="form-label">total copie:</label>
                                                <input type="number" class="form-control" name="total_copie" placeholder="total copie" required>
                                            </div>

                                            <div class="col">
                                                <label class="form-label">avaible copies:</label>
                                                <input type="number" class="form-control" name="avaible_copies" placeholder="avaible copies" required>
                                            </div>
                                        </div>

                                        <div class="row ms-1 mt-4 justify-content-center">
                                            <button type="submit" name="add_book_submit" class="btn btn-success col-3 me-3">Save changes</button>
                                            <a href="showBooks.php" class="btn btn-danger col-3">Cancel</a>
                                        </div>

                                </div>


                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
    </div>
    <!-- Content End -->


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../../../public/js/chart.min.js"></script>
    <script src="../../../public/js/dashboard.js"></script>
</body>
<script>
    AOS.init();
</script>
<script>
    // Sidebar Toggler
    document
        .querySelector(".sidebar-toggler")
        .addEventListener("click", function() {
            document.querySelector(".sidebar").classList.toggle("open");
            document.querySelector(".content").classList.toggle("open");
            return false;
        });
    var currentPage = window.location.href;

    var navLinks = document.querySelectorAll(".navbar-nav .nav-link");

    navLinks.forEach(function(link) {
        if (link.href === currentPage) {
            link.classList.add("active");
        }
    });
    let image = document.getElementById("image");
    let input = document.getElementById("input-file");

    input.onchange = () => {
        image.src = URL.createObjectURL(input.files[0]);
    }
</script>

</html>