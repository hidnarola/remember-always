<header class="header">
    <div class="container">
        <div class="logo">
            <a href=""><img src="assets/images/logo.png" alt="" /></a>
        </div>
        <?php if ($this->is_user_loggedin) { ?>
            <div class="login-user dropdown">
                <a href="" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <span class="user-name">
                        <?php if ($this->session->userdata('remalways_user')['profile_image'] != '') { ?>
                            <img src="<?php echo USER_IMAGES . $this->session->userdata('remalways_user')['profile_image']; ?>" alt="<?php echo $this->session->userdata('remalways_user')['firstname'] ?>"/>
                        <?php } else { ?>
                            <img src="assets/images/profile-icon.png" alt="<?php echo $this->session->userdata('remalways_user')['firstname'] ?>"/>
                        <?php } ?>
                    </span>
                    <?php echo $this->session->userdata('remalways_user')['firstname'] . ' ' . $this->session->userdata('remalways_user')['lastname'] ?>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><a href="">My Profile</a></li>
                    <li><a href="">Edit Profile </a></li>
                    <li><a href="<?php echo site_url('logout') ?>">Logout</a></li>
                </ul>
            </div>
        <?php } else {
            ?>
            <div class="login-register">
                <a href="javascript:void(0)" onclick="showModal('log-in')">Login</a>
                <a href="javascript:void(0)" onclick="showModal('sign-up')">Register</a>
            </div>
        <?php } ?>
        <div class="search">
            <a href=""><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 129 129" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 129 129">
                    <g>
                        <path d="M51.6,96.7c11,0,21-3.9,28.8-10.5l35,35c0.8,0.8,1.8,1.2,2.9,1.2s2.1-0.4,2.9-1.2c1.6-1.6,1.6-4.2,0-5.8l-35-35   c6.5-7.8,10.5-17.9,10.5-28.8c0-24.9-20.2-45.1-45.1-45.1C26.8,6.5,6.5,26.8,6.5,51.6C6.5,76.5,26.8,96.7,51.6,96.7z M51.6,14.7   c20.4,0,36.9,16.6,36.9,36.9C88.5,72,72,88.5,51.6,88.5c-20.4,0-36.9-16.6-36.9-36.9C14.7,31.3,31.3,14.7,51.6,14.7z"/>
                    </g>
                </svg>
            </a>
            <form>
                <input type="text" name="" placeholder=""/>
                <button type="submit"></button>
            </form>
        </div>
        <nav class="navbar navbar-default nav-menu">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Brand</a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Features</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <?php if (isset($breadcrumb)) { ?>
            <div class="breadcrumb">
                <ul>
                    <?php foreach ($breadcrumb['links'] as $bcrumb) { ?>
                        <li><a href="<?php echo $bcrumb['link'] ?>"><?php echo $bcrumb['title'] ?></a></li>
                    <?php } ?>
                    <li><?php echo $breadcrumb['title'] ?></li>
                </ul>
            </div>
        <?php } ?>
    </div>
</header>