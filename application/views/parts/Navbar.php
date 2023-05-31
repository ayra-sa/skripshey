<!-- nav -->
<nav>
  <div id="logo">
    <a href="<?php echo base_url(); ?>Welcome/">
      <img src="<?php echo base_url() ?>Assets/web/images/kra-logo.png" alt="logo" class="logo">
    </a>
  </div>
  <label for="drop" class="toggle">Menu</label>
  <input type="checkbox" id="drop">
  <ul class="menu mt-2">
    <!-- 1 -->
    <li class="active"><a href="<?php echo base_url(); ?>Welcome/">Home</a></li>
    <!-- 2 -->
    <li class="mx-lg-3 mx-md-2 my-md-0 my-1"><a href="<?php echo base_url(); ?>Welcome/about">About</a></li>
    <!-- 3 -->
    <li><a href="<?php echo base_url(); ?>Welcome/tanaman">Data UMKM</a></li>
    <!-- 4 -->
    <li><a href="<?php echo base_url(); ?>Welcome/lokasi">Lokasi UMKM</a></li>
    <!-- 5 -->
    <li><a href="<?php echo base_url(); ?>Home/Login">Login</a></li>
  </ul>
</nav>
<!-- //nav -->