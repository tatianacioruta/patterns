<?session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">

<head>
    <title>Welcome to my site</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Oswald Font -->
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
   <link rel="stylesheet" type="text/css" href="<?= _URL_PATH?>css/tooltipster.css" />

    <!-- home slider-->
    <link href="<?= _URL_PATH?>css/pgwslider.css" type="text/css" rel="stylesheet"/>
    <!-- Font Awesome -->
   <!-- <link rel="stylesheet" type="text/css" href="<?/*= _URL_PATH */?>css/bootstrap.min.css" />-->
    <link type="text/css" rel="stylesheet" href="<?= _URL_PATH ?>css/dataTables.bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="<?= _URL_PATH ?>css/dimensions.css">
    <link type="text/css" rel="stylesheet" href="<?= _URL_PATH ?>css/validationEngine.jquery.css">
    <link type="text/css" rel="stylesheet" href="<?= _URL_PATH ?>css/jquery.fancybox.css">
    <link rel="stylesheet" type="text/css" href="<?= _URL_PATH?>css/font-awesome.min.css"/>
    <link href="<?= _URL_PATH?>css/style.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="<?= _URL_PATH?>css/responsive.css" rel="stylesheet"  type="text/css" media="screen"/>
    <link href="<?= _URL_PATH?>js/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" type="text/css" rel="stylesheet"/>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
      <!--Script-->
    <script type="text/javascript" src="<?= _URL_PATH?>js/jquery-2.1.0.min.js" charset="UTF-8"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?= _URL_PATH?>js/admin.main.js"></script>
    <script type="text/javascript" src="<?= _URL_PATH?>js/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script><script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcZpIst37QPf5dVOHDFw9O-YhQ0rZLoTo&signed_in=true&libraries=places&callback=initMap" async defer></script>
    <script type="text/javascript" src="<?= _URL_PATH ?>js/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="<?= _URL_PATH ?>js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= _URL_PATH ?>js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= _URL_PATH ?>js/dataTables.responsive.js"></script>
    <script type="text/javascript" src="<?= _URL_PATH ?>js/bootbox.min.js"></script>
   <!-- <script type="text/javascript" src="<?/*= _URL_PATH */?>js/jquery-ui.min.js"></script>-->
    <script type="text/javascript" src="<?= _URL_PATH ?>js/jquery.validationEngine.js"></script>
    <script type="text/javascript" src="<?= _URL_PATH ?>js/jquery.validationEngine-en.js"></script>
    <script type="text/javascript" src="<?= _URL_PATH ?>js/jquery.validationEngine.other-validations.js"></script>

</head>
<body>
<? (!empty($data)) ? extract($data):""; ?>
<section id="header_area">
    <div class="wrapper header">
        <div class="clearfix header_top">
            <div class="clearfix logo floatleft">
                <a href=""><h1><span>Tany's</span> Forum admin</h1></a>
            </div>
            <div class="floatright" style="align-content: center; color: white;" id="status">
            </div>
            <div class="floatright" style="color: white; border: 1px solid white; display: block;">User:<?= $_SESSION['user_data']['name']?>
                <a style="color: white; border-left: 1px solid white;" href="<?= _URL_PATH . 'authorization/log_out'?>">Log out</a>
            </div>
            <div class="clearfix search floatright">
                <form>
                    <input type="text" placeholder="Search"/>
                    <input type="submit" />
                </form>
            </div>
        </div>
        <div class="header_bottom">
            <nav>
                <ul id="nav">
                    <li><a href="<?=_URL_PATH .'home/admin'?>">Admin</a></li>
                    <li><a href="<?=_URL_PATH . 'posts/admin'?>">Posts</a></li>
                    <li><a href="<?=_URL_PATH . 'user/admin'?>">Users</a></li>
                    <li><a href="<?=_URL_PATH . 'comments/admin'?>">Comments</a></li>
                    <li><a href="<?=_URL_PATH . 'categories/admin'?>">Post Categories</a></li>
                    <li><a href="<?=_URL_PATH ?>">Back Home</a></li>
                </ul>
            </nav>
        </div>
    </div>
</section>


		