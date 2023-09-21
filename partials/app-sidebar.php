<?php
    $user = $_SESSION["user"];
?>

<div class="dashboard_sidebar" id="dashboard_sidebar">
    <h3 class="dashboard_logo" id="dashboard_logo">SGI</h3>
    <div class="dashboard_sidebar_user">
        <img src="images/user/person.png" alt="User image" id="userImage" />
        <span><?= $user["first_name"] . " " . $user["last_name"] ?></span>
    </div>
    <div class="dashboard_sidebar_menus">
        <ul class="dashboard_menu_lists">
            <!-- <li class="liMainMenu">
                <a href="./dashboard.php"><i class="fa fa-dashboard"></i><span class="menuText">   Dashboard</span></a>
            </li> -->
            <li class="liMainMenu">
                <a href="javascript:void(0);" class="showHideSubmenu"><i class="fa fa-home mainMenuIconArrow showHideSubmenu"></i><span class="menuText showHideSubmenu"> Propiedad </span>
                <ul class="subMenus">
                    <li><a class="subMenuLink" href="./property-add.php"><i class="fa fa-circle-o"></i> Agregar Propiedad</a></li>
                    <li><a class="subMenuLink" href="./property-view.php"><i class="fa fa-circle-o"></i> Ver Propiedad</a></li>
                </ul>

            </li>
            <li class="liMainMenu">
                <a href="javascript:void(0);" class="showHideSubmenu"><i class="fa fa-users mainMenuIconArrow showHideSubmenu"></i><span class="menuText showHideSubmenu"> Inquilinos </span>
                <ul class="subMenus">
                    <li><a class="subMenuLink" href="./tenant-add.php"><i class="fa fa-circle-o"></i> Agregar Inquilinos</a></li>
                    <li><a class="subMenuLink" href="./tenant-view.php"><i class="fa fa-circle-o"></i> Ver Inquilino</a></li>
                </ul>
            </li>
            <li class="liMainMenu showHideSubmenu">
                <a href="javascript:void(0);" class="showHideSubmenu"><i class="fa fa-user-plus mainMenuIconArrow showHideSubmenu"></i><span class="menuText showHideSubmenu"> Usuarios </span>
                <ul class="subMenus">
                    <li><a class="subMenuLink" href="./users-add.php"><i class="fa fa-circle-o"></i> Agregar Usuario</a></li>
                    <li><a class="subMenuLink" href="./users-view.php"><i class="fa fa-circle-o"></i> Ver Usuarios</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>