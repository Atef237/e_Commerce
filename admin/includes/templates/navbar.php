<nav class="navbar navbar-expand-lg navbar-light bg-light ">
  <a class="navbar-brand" href="dashboard.php"> Home <i class="fas fa-home nv"></i></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#add-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="sr-only">toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>

  <div class="collapse navbar-collapse" id="add-nav">
    <ul class="nav navbar-nav">
      
      <li><a class="nav-link" href="categories.php"> categories <i class="fas fa-layer-group nv"></i> </a></li>
      <li><a class="nav-link" href="items.php"> Items <i class="fas fa-tag nv"></i> </a></li>
      <li><a class="nav-link" href="members.php?action=manage"> Members <i class="fas fa-users nv"></i> </a></li>
      <li><a class="nav-link" href="comments.php"> Comments <i class="fas fa-comment-dots nv"></i> </a></li>

    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Atef <i class="fas fa-grin nv"></i></i>
        </a>
        
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="members.php?action=edit&userID=<?php echo $_SESSION['userID']?>">Edit Profile <i class="fas fa-user-edit nv"></i></a></li>
          <li><a class="dropdown-item" href="logout.php">Logout <i class="fas fa-sign-out-alt nv"> </a></i></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>