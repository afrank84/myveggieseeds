<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <img src="plant.png" width="40" height="40"/>  
        <a class="navbar-brand" href="#">Vegetable Database</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.html">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="search_plants_form.php">Plantabase</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Records
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="user_plants.php">Plants</a></li>
                        <li><a class="dropdown-item" href="#">Tasks</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <span class="navbar-text">Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo htmlspecialchars($_SESSION['profile_image'] ?? 'frank.png'); ?>" alt="Profile" class="rounded-circle" width="40" height="40">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="login_page.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="register_page.php">Signup</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
