<header class="header-section header-onestyle cmn-breadcrumnd-header cmn-fixed py-lg-2 py-6">
    <div class="container">
        <div class="main-navbar">
            <nav class="navbar-custom">
                <div class="d-lg-flex flex-xl-nowrap flex-wrap align-items-center justify-content-lg-between">
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="<?php echo url('/'); ?>" class="brand-logo">
                            <img class="w-100" src="<?php echo asset('assets/img/logo/logo.png'); ?>" alt="logo">
                        </a>
                        <div class="d-flex align-items-center gap-xxl-5 gap-5">
                            <div class="d-lg-none d-block">
                                <a href="#0" class="search-trigger search-icon d-center radius100">
                                    <i class="fal fa-search"></i>
                                </a>
                            </div>
                            <button class="navbar-toggle-btn d-block d-lg-none" type="button">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                    <div class="navbar-toggle-item">
                        <ul
                            class="custom-nav d-lg-flex d-grid gap-xxl-12 gap-xl-8 gap-lg-5 gap-md-2 gap-2 pt-lg-0 pt-5">
                            <li class="menu-item position-relative pe-lg-5">
                                <button class="position-relative  white-clr fw_500 cus-z1">
                                    Home
                                </button>
                                <ul class="sub-menu px-lg-4 py-xxl-3 py-2">
                                    <li class="menu-link py-1">
                                        <a href="<?php echo url('/'); ?>" class="fw_500 white-clr">Home Version-1</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item position-relative">
                                <a href="#" class="fw_500">
                                    About
                                </a>
                            </li>
                            <li class="menu-item position-relative pe-lg-5">
                                <button class="position-relative fw_500 white-clr cus-z1">
                                    Podcast
                                </button>
                                <ul class="sub-menu px-lg-4 py-xxl-3 py-2">
                                    <li class="menu-link py-1">
                                        <a href="#" class="fw_500 white-clr">Episode v1</a>
                                    </li>
                                    <li class="menu-link py-1">
                                        <a href="#" class="fw_500 white-clr">Episode v2</a>
                                    </li>
                                    <li class="menu-link py-1">
                                        <a href="#" class="fw_500 white-clr">Episode v3</a>
                                    </li>
                                    <li class="menu-link py-1">
                                        <a href="#" class="fw_500 white-clr">Episode Details</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item position-relative pe-lg-5">
                                <button class="position-relative fw_500 white-clr cus-z1">
                                    Pages
                                </button>
                                <ul class="sub-menu px-lg-4 py-xxl-3 py-2">
                                    <li class="menu-link py-1">
                                        <a href="#" class="fw_500 white-clr">Events</a>
                                    </li>
                                    <li class="menu-link py-1">
                                        <a href="#" class="fw_500 white-clr">Events Details</a>
                                    </li>
                                    <li class="menu-link py-1">
                                        <a href="#" class="fw_500 white-clr">Hosts</a>
                                    </li>
                                    <li class="menu-link py-1">
                                        <a href="#" class="fw_500 white-clr">Hosts Details</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item position-relative pe-lg-5">
                                <button class="position-relative fw_500 white-clr cus-z1">
                                    Blog
                                </button>
                                <ul class="sub-menu px-lg-4 py-xxl-3 py-2">
                                    <li class="menu-link py-1">
                                        <a href="#" class="fw_500 white-clr">Blog</a>
                                    </li>
                                    <li class="menu-link py-1">
                                        <a href="#" class="fw_500 white-clr">Blog Details</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item position-relative">
                                <a href="#" class="fw_500">
                                    Contact Us
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div
                        class="d-lg-flex d-none d-grid justify-content-center ph-clickwrap align-items-center gap-xxl-3 gap-xl-2 gap-1">
                        <div class="search-shopcart d-flex gap-xxl-9 gap-xl-5 gap-3">
                            <a href="#0" class="search-trigger search-icon d-center radius100">
                                <i class="fal fa-search"></i>
                            </a>
                        </div>
                        <?php if (auth()->check()): ?>
                            <form action="<?php echo route('logout'); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="d-flex align-items-center text-uppercase fw-500 py-2 pe-2 ps-xxl-7 ps-3 theme-bg gap-sm-4 gap-2 touch-btn border-0">
                                    Logout
                                    <span class="icon d-center whitebg">
                                        <i class="ph-fill ph-sign-out theme-clr"></i>
                                    </span>
                                </button>
                            </form>
                        <?php else: ?>
                            <a href="<?php echo route('login'); ?>"
                                class="d-flex align-items-center text-uppercase fw-500 py-2 pe-2 ps-xxl-7 ps-3 theme-bg gap-sm-4 gap-2 touch-btn">
                                Login
                                <span class="icon d-center whitebg">
                                    <i class="ph-fill ph-user theme-clr"></i>
                                </span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>