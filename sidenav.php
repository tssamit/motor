<?php
$resultsuser = $db->query("SELECT * FROM `vw_master_user` WHERE `a_id`='" . $_SESSION['a_id'] . "'");
$rowuser = $resultsuser->fetch_object();
?>
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="dashboard">
            <span class="sidebar-brand-text align-middle">
                <img src="img/logoadmin.png" alt="logo" class="img-fluid bg-light" style=" max-height: 40px;" />
            </span>
            <svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.5"
                 stroke-linecap="square" stroke-linejoin="miter" color="#FFFFFF" style="margin-left: -3px">
            <path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
            <path d="M20 12L12 16L4 12"></path>
            <path d="M20 16L12 20L4 16"></path>
            </svg>
        </a>

        <!--        <div class="sidebar-user">
                    <div class="d-flex justify-content-center">
                        <div class="flex-shrink-0">
                            <img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
                        </div>
                        <div class="flex-grow-1 ps-2">
                            <a class="sidebar-user-title dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                Charles Hall
                            </a>
                            <div class="dropdown-menu dropdown-menu-start">
                                <a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="pages-settings.html"><i class="align-middle me-1" data-feather="settings"></i> Settings &
                                    Privacy</a>
                                <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Log out</a>
                            </div>

                            <div class="sidebar-user-subtitle">Designer</div>
                        </div>
                    </div>
                </div>-->

        <ul class="sidebar-nav">

            <li class="sidebar-item">
                <a class="sidebar-link" href="dashboard">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <?php
            $pagecount = $rowuser->a_pagepermission;
            $cnt = 0;
            //echo "SELECT DISTINCT ref_cd,icon,refer_name FROM vw_menu where menu_status ='Active' and header_status ='Active' and menu_code in ($pagecount) ORDER BY ref_cd";
            $resultsnavd = $db->query("SELECT DISTINCT ref_cd,icon,refer_name FROM vw_menu WHERE menu_status ='Active' AND header_status ='Active' AND menu_code IN ($pagecount) ORDER BY ref_cd");
            while ($datanav = $resultsnavd->fetch_object()) {
                $ref_cd = $datanav->ref_cd;
                $cnt++;
                ?>
                <li class="sidebar-item">
                    <a data-bs-target="#s<?= $datanav->ref_cd; ?>" data-bs-toggle="collapse" class="sidebar-link collapsed">
                        <i class="align-middle" data-feather="plus"></i> <span class="align-middle"><?= $datanav->refer_name; ?></span>
                    </a>
                    <ul id="s<?= $datanav->ref_cd; ?>" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <?php
                        $cnt1 = 0;
                        $resultsnavd1 = $db->query("SELECT DISTINCT refer_name,cust_name,menu_hdr_cd,icon  FROM vw_menu where menu_status ='Active' and header_status ='Active' AND ref_cd='$ref_cd' and menu_code in ($pagecount) ORDER BY menu_hdr_cd ");
                        while ($datanav1 = $resultsnavd1->fetch_object()) {
                            $cnt1++;
                            $menu_hdr_cd = $datanav1->menu_hdr_cd;
                            if ($datanav1->refer_name == $datanav1->cust_name) {
                                $resultsnavd2 = $db->query("SELECT DISTINCT menu_code,menu_cust_name,path,sequence,mnu_icon FROM vw_menu WHERE menu_status ='Active' and header_status ='Active' and  ref_cd='$ref_cd' AND menu_hdr_cd='$menu_hdr_cd' and  menu_code in ($pagecount) order by sequence");
                                while ($datanav2 = $resultsnavd2->fetch_object()) {
                                    ?>


                                    <li class="sidebar-item">
                                        <a class="sidebar-link" href="<?= $datanav2->path; ?>"><?= $datanav2->menu_cust_name; ?></a>
                                    </li>

                                    <?php
                                }
                            } else {
                                ?>

                                <li class="sidebar-item">
                                    <a data-bs-target="#su<?= $cnt1; ?>" data-bs-toggle="collapse" class="sidebar-link collapsed"><?= $datanav1->cust_name; ?></a>
                                    <ul id="su<?= $cnt1; ?>" class="sidebar-dropdown list-unstyled collapse">
                                        <?php
                                        $resultsnavd3 = $db->query("SELECT DISTINCT menu_code,menu_cust_name,path,sequence,mnu_icon FROM vw_menu WHERE menu_status ='Active' and header_status ='Active' and  ref_cd='$ref_cd' AND menu_hdr_cd='$menu_hdr_cd' and  menu_code in ($pagecount) order by sequence");
                                        while ($datanav3 = $resultsnavd3->fetch_object()) {
                                            ?>
                                            <li class="sidebar-item">
                                                <a class="sidebar-link" href="<?= $datanav3->path; ?>"> <?= $datanav3->menu_cust_name; ?></a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php
                            }
                        }
                        ?>
                        <!--                        <li class="sidebar-item">
                                                    <a data-bs-target="#multi-3" data-bs-toggle="collapse" class="sidebar-link collapsed">Three Levels</a>
                                                    <ul id="multi-3" class="sidebar-dropdown list-unstyled collapse">
                                                        <li class="sidebar-item">
                                                            <a data-bs-target="#multi-3-1" data-bs-toggle="collapse" class="sidebar-link collapsed">Item 1</a>
                                                            <ul id="multi-3-1" class="sidebar-dropdown list-unstyled collapse">
                                                                <li class="sidebar-item">
                                                                    <a class="sidebar-link" href="#">Item 1</a>
                                                                </li>
                                                                <li class="sidebar-item">
                                                                    <a class="sidebar-link" href="#">Item 2</a>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li class="sidebar-item">
                                                            <a class="sidebar-link" href="#">Item 2</a>
                                                        </li>
                                                    </ul>
                                                </li>-->
                    </ul>
                </li>
            <?php } ?>



        </ul>


    </div>
</nav>
