<style>
        #menu_div div {float:right;}
        #menu_div div div{            
            float:left;
            width:auto;
            margin-left: 5px;
        }
        
    </style>
<header style ="background-color:white">
      <div class="row fixed-nav-bar">
      <div class="logo col-md-6">
        <img src="../static/img/logo.png" style="width:250px;">
      </div>
          <div class="navagation col-md-6" id="menu_div"><div>
        <div>
            <a href="../home.php"><button class="btn btn-default">Dashboard</button></a>
        </div>
          <div>
        <?php if($_SESSION['user_type']==1){ ?> 
              <a href="../account.php"><button class=" btn btn-default">Accounts</button></a> <?php } ?>
          </div>
          <div>
          <a href="../logout.php"><button class=" btn btn-default">Logout</button></a>
          
          </a></div>
              </div>
      </div>
      </div>
    </header>