<?php    
    header("Content-Type: text/html; charset=ISO 8859-1",true);

    include 'conecta_bd.php';

    if (isset($_POST['register_btn'])) {

        session_start();
        
        //informações introduzidas pelo utilizador
        $username = $_POST["username"];
        $email = $_POST["email"];
        $age= $_POST["age"];
        $password = $_POST["password"];
        $password2 = $_POST["password2"];
        $allowed_d = array('@gmail.com', '@outlook.com', '@outlook.pt'); //criaçao dos emails que sao aceitaveis de colocar

        function match($allowed_d, $email) //criaçao da funçao para verificar se o mail e valido
        {
          foreach($allowed_d as $allowed){
            if (strpos($email, $allowed) !== false) {
              return true;
            }
          }
          return false;
        }

        if(!match($allowed_d, $email)){//verifica se existe algum dos emails validos no email escrito pelo utilizador, caso
        	//nao exista, e mostrado o aviso abaixo
?>
          <div class="container">
            <div class="alert alert-warning">
              <strong>Warning!</strong> Enter only trusted email address providers
            </div>
          </div>
<?php
        //Proximas linhas verificam se o username ou email ja existem
        }elseif ($password == $password2) { //condiçao que verifica se a o email e/ou username ja esta em uso por outro utilizador
        	//criaçao de variaveis que verificam se o email/username introduzido pelo user ja exista algures na bd
          $select_u = mysqli_query($ligacao, "SELECT `username` FROM `users` WHERE `username` = '".$_POST['username']."'") or exit(mysqli_error($ligacao));
          $select_m = mysqli_query($ligacao, "SELECT `email` FROM `users` WHERE `email` = '".$_POST['email']."'") or exit(mysqli_error($ligacao));
          //Os 2 if abaixo sao para retornar avisos ao utilizador de que o email/username ja existe caso uma das variaveis encontre
          //um username/email iguais
          if(mysqli_num_rows($select_m)) {
?>
            <div class="container">
              <div class="alert alert-warning">
                <strong>Warning!</strong> The email is already being used
              </div>
            </div>
<?php
          }elseif(mysqli_num_rows($select_u)) {
?>
            <div class="container">
              <div class="alert alert-warning">
                <strong>Warning!</strong> Username already exists!
              </div>
            </div>
<?php    
          }
          else{
            $password = md5($password); //hash password before storing for security purposes
            $insert = "INSERT INTO users (id_u, username, email,idade, data_insc, password, id_d, id_l, id_e, img_p) VALUES (NULL, '$username', '$email', '$age' , NULL, '$password', NULL, NULL, NULL, NULL )";      
            if (mysqli_query($ligacao, $insert)) {
              header("location: success.php");
            } else {
              echo "Error: " . $insert . "<br>" . mysqli_error($ligacao);
            }        
          } 
        }else{
?>
          <div class="container">
            <div class="alert alert-warning">
              <strong>Warning!</strong> The 2 passwords must be equal!
            </div>
          </div>
<?php
        }
    }
 
    $ligacao -> close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; 
    charset=ISO 8859-1">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>ScoreHaven - Sign up</title>

    <!-- All sizes including Android,iOS... Favicon -->
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="img/favicon/apple-touch-icon-57x57.png" />
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/favicon/apple-touch-icon-114x114.png" />
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/favicon/apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/favicon/apple-touch-icon-144x144.png" />
	<link rel="apple-touch-icon-precomposed" sizes="60x60" href="img/favicon/apple-touch-icon-60x60.png" />
	<link rel="apple-touch-icon-precomposed" sizes="120x120" href="img/favicon/apple-touch-icon-120x120.png" />
	<link rel="apple-touch-icon-precomposed" sizes="76x76" href="img/favicon/apple-touch-icon-76x76.png" />
	<link rel="apple-touch-icon-precomposed" sizes="152x152" href="img/favicon/apple-touch-icon-152x152.png" />
	<link rel="icon" type="image/png" href="img/favicon/favicon-196x196.png" sizes="196x196" />
	<link rel="icon" type="image/png" href="img/favicon/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/png" href="img/favicon/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="img/favicon/favicon-16x16.png" sizes="16x16" />
	<link rel="icon" type="image/png" href="img/favicon/favicon-128.png" sizes="128x128" />
	<meta name="application-name" content="&nbsp;"/>
	<meta name="msapplication-TileColor" content="img/favicon/#FFFFFF" />
	<meta name="msapplication-TileImage" content="img/favicon/mstile-144x144.png" />
	<meta name="msapplication-square70x70logo" content="img/favicon/mstile-70x70.png" />
	<meta name="msapplication-square150x150logo" content="img/favicon/mstile-150x150.png" />
	<meta name="msapplication-wide310x150logo" content="img/favicon/mstile-310x150.png" />
	<meta name="msapplication-square310x310logo" content="img/favicon/mstile-310x310.png" />
    <!-- End of Favicon -->


    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.13/css/all.css"></script>
    <!-- End of Bootstrap -->
 

    <!-- Links for the footer style -->
    <link href="https://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <!-- End of the links for the footer style -->

    <!-- CSS files -->
    <link rel="stylesheet" href="login/css/sign_up.css">
    <!-- End of CSS files -->

</head>
<body>

  <div class="container">

     <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
      <div class="container-fluid">
            <a id="logo_navbar_text_type" class="navbar-brand" href="index">
                <img src="img/sitelogo.svg" width="35" height="35" class="d-inline-block align-top" alt="">
                Score<span id="logo_text_color">Haven</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>     
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="index">Soccer<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="basketball">Basketball</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="volleyball">Volleyball</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="hockey">Hockey</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Other
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="amfootball">AM.Football</a>
                    <a class="dropdown-item" href="tennis">Tennis</a>
                    <a class="dropdown-item" href="cricket">Cricket</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="iphone">Iphone</a>
                </li>
              </ul>
          </div>
        </div>
    </nav>
    <!-- End of Navigation Bar -->

    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card card-signin flex-row my-5">
          <div class="card-img-left d-none d-md-flex">

          </div>
          <div class="card-body">
            <h5 class="card-title text-center">Register</h5>
            <form class="form-signin" method="post" action="sign_up.php">
              <div class="form-label-group">
                <input type="text" id="inputUserame" name="username" class="form-control" placeholder="Username" required autofocus>
                <label for="inputUserame">Username</label>
              </div>

              <div class="form-label-group">
                <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required>
                <label for="inputEmail">Email address</label>
              </div>
              
              <div class="form-label-group">
                <input type="text" pattern="^[0-9]*$" class="form-control" name="age" />
                <label for="inputAge">Your Age</label>
              </div>
              
              <hr>

              <div class="form-label-group">
                <input type="password" id="inputPassword" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
              </div>
              
              <div class="form-label-group">
                <input type="password" id="inputConfirmPassword" name="password2" class="form-control" placeholder="Password" required>
                <label for="inputConfirmPassword">Confirm password</label>
              </div>
              
              <button class="btn btn-lg btn-primary btn-block text-uppercase" name="register_btn" type="submit">Register</button>
              <a class="d-block text-center mt-2 small" href="sign_in.php">Sign In</a>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Footer -->
    <footer class="bg-dark">
      <div class="container">
      	<br>
        <p  id="company" class="m-0 text-center text-white">Copyright &copy; ScoreHaven 2018</p>
        <p id="contributor" class="m-0 text-center text-gray">Livescore service provided by: <a href="http://www.livescore.in/" title="Livescore.in" target="_blank">Livescore.in</a></p>
        <br>
      </div>
    </footer>
<!-- End of Footer -->

</body>
</html>