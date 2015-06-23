 <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Admin Template</a>
          <div class="nav-collapse">
			<ul class="nav pull-right"><!-- right navigation & dropdown -->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Administrator <b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo base_url(); ?>administrator/ganti_password"> <i class="icon-wrench"></i> Ganti Password </a></li>
						<li><a href="<?php echo base_url(); ?>auth/logout"><i class="icon-off"></i> Logout </a></li>
					</ul>
				</li>
			</ul><!-- right navigation & dropdown -->
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
