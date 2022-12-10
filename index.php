<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>
        Web game
    </title>
  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body>
    <noscript>
      <strong>We're sorry but app doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>

    <div id="app">
        <nav class="red darken-1" role="navigation">
            <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo"></a>
                <ul class="right hide-on-med-and-down">
                <li><a>Admin</a></li>
                </ul>

                <ul id="nav-mobile" class="sidenav">
                <li><a>Admin</a></li>
                </ul>
                <a href="#" data-target="nav-mobile" class="sidenav-trigger">Admin</a>
            </div>
        </nav>
        <div class="row">
            <div class="col s12 m4 l3">
                <div id="menu">
                    <ul class="collapsible expandable">
                        <li>
                            <div class="collapsible-header"><i class="material-icons">arrow_drop_down</i>
                                <h6> Game </h6>
                            </div>
                            <div class="collapsible-body"><span>
                                <a href="?menu=games">List Game</a>
                            </span></div>
                        </li>
                        <li>
                            <div class="collapsible-header"><i class="material-icons">arrow_drop_down</i>
                                <h6> Score </h6>
                            </div>
                            <div class="collapsible-body"><span>
                                <a href="?menu=scoreboard">Scoreboard</a>
                            </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col s12 m8 l9">
                <div id="container" style="min-height:800px">
                    <div id="content">

                    <?php
                    
                    $menu = "";
                    if (isset($_GET['menu']) && !empty($_GET['menu'])) {
                        $menu = $_GET['menu'];

                        if ($menu == "games"){
                            include_once "pages/games.php";

                        } else if ($menu == "scoreboard"){
                            include_once "pages/scoreboard.php";

                        } else {
                            header("location: /index.php?message=menu tidak ditemukan");
                            exit;
                        }

                    } else {
                    ?>

                        <br><br>
                            <h1 class="header center red-text">Welcome</h1>
                            <div class="row center">
                                <h5 class="header col s12 light">this is just simple admin web game</h5>
                            </div>
                            <br><br>

                    <?php  } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!--  Scripts-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="./js/materialize.js"></script>
    <script>
        var elem = document.querySelector('.collapsible.expandable');
        var instance = M.Collapsible.init(elem, {
            accordion: false
        });
    </script>
</body>
</html>