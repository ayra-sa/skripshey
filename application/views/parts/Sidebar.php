<!--sidebar-menu-->
<?php
$active = '';
$temp_lv1 = $this->GlobalVar->GetSideBar($user_id, 0, 0)->result();
?>

<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <h3>General</h3>
    <ul class="nav side-menu">
      <!-- <li><a href="<?php echo base_url() ?>Home"><i class="fa fa-home"></i> Home <span class="label label-success pull-right"></span></a></li> -->
      <?php
      foreach ($temp_lv1 as $key) {
        $parent_id = $key->id;
        $temp_lv2 = $this->GlobalVar->GetSideBar($user_id, $parent_id, 0)->result();

        if ($key->multilevel == "0") {
          if ($key->separator == "0") {
            echo "<li><a href='" . base_url() . $key->link . "'><i class='fa " . $key->ico . " nav_icon'></i> " . $key->permissionname . "<span class='label label-success pull-right'></span></a> </li>";
          } else {
            echo "<li class ='content'><center><span class ='separator-custom'> " . $key->permissionname . "</span></center></li>";
          }
        } else {
          echo "<li>";
          echo "<a href='" . base_url() . $key->link . "'><i class='fa " . $key->ico . " nav_icon'></i> " . $key->permissionname . "<span class='fa fa-chevron-down'></span></a>";
          echo "<ul>";
          foreach ($temp_lv2 as $child) {
            if ($child->separator == "0") {
              echo "<li><a href='" . base_url() . $child->link . "'>" . $child->permissionname . "</a></li>";
            } else {
              echo "<li class ='content'><center><span class ='separator-custom'> " . $child->permissionname . "</span></center></li>";
            }
          }
          echo "</ul>";
          echo "</li>";
        }
      }
      ?>
      <li><a href="<?php echo base_url() ?>Auth/logout"><i class="glyphicon glyphicon-off"></i> Logout <span class="label label-success pull-right"></span></a>
      </li>
    </ul>
  </div>

</div>
<!-- /sidebar menu -->
</div>
</div>

<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
    <div class="nav toggle">
      <a id="menu_toggle"><i class="fa fa-bars"></i></a>
    </div>
    <nav class="nav navbar-nav">
    </nav>
  </div>
</div>
<!-- /top navigation -->