<!DOCTYPE html>
<html>
<head>
	<title>iVote(<?= $title; ?>)</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
  	<script src="<?php echo base_url(); ?>assets/jqueryfile/jquery-3.3.1.min.js"></script>
  	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
 <style>
 #vote input {/*border-radius: 0%;*/}
  /* Note: Try to remove the following lines to see the effect of CSS positioning */
  .affix {
    top: 0;
    width: 100%;
    z-index: 9999 !important;
    background-color: #2f4f4f !important;
    border-bottom: 1px solid white !important;
  }

.nav-wrapper
{
    min-height:62px; /*account for 20px margin-bottom on .nav */
    height: 100%;
}


  .navbar-default {z-index: 1000 !important;}

  .affix + .container-fluid {
    padding-top: 10vh; 
  }

  #vote ul li a#date {
    text-decoration: none;
    padding-right: 50px;
  	color: gold;
    font-family: cursive;
  }
  #mySidenav a {
    position: fixed;
    left: -160px;
    transition: 0.3s;
    padding: 10px;
    width: 200px;
    text-decoration: none;
    font-size: 20px;
    color: white;
    border-radius: 0%;
    z-index: 20 !important;
}

#mySidenav a:hover {
    left: 0;
}

#home {
    top: 160px;
    background-color: #2f4f4f;
}

#about {
    top: 210px;
    background-color: #2f4f4f;
}

#candidates {
    top: 260px;
    background-color: #2f4f4f;
}

#admin {
    top: 310px;
    background-color: #2f4f4f;
}

#votes {
    top: 360px;
    background-color: #4CAF50;
}
#register {
  top: 310px;
  background-color: #2f4f4f;
}
#dashb {
  top: 360px;
  background-color: #2f4f4f;
}

@media screen and (max-height: 560px) {
  
  #mySidenav a {
    position: fixed;
    left: -130px;
    transition: 0.3s;
    padding: 10px;
    width: 170px;
    text-decoration: none;
    font-size: 12px;
    color: white;
    border-radius: 0%;
    z-index: 20 !important;
}
#home {
    top: 160px;
    background-color: #2f4f4f;
}
#about {
    top: 200px;
    background-color: #2f4f4f;
}
#candidates {
    top: 240px;
    background-color: #2f4f4f;
}
#admin {
    top: 280px;
    background-color: #2f4f4f;
}
#votes {
    top: 320px;
    background-color: #4CAF50;
}
#register {
  top: 280px;/*320px*/
  background-color: #2f4f4f;
}
#dashb {
  top: 320px;/*360px*/
  background-color: #2f4f4f;
}
#modd {width: 45vh;}
}
  </style>
</head>
<body id="vote" style="background-color: lightgrey;">
	<div id="mySidenav" class="sidenav">
  <?php if (!$this->session->userdata('voter_in')): ?>
  <a href="<?php echo base_url(); ?>" id="home">Home <span style="float: right;" class="glyphicon glyphicon-home"></span></a>
  <a href="<?php echo base_url(); ?>about" id="about">About<span style="float: right;" class="glyphicon glyphicon-info-sign"></span></a>
  <?php endif; ?>
  <a href="<?php echo base_url(); ?>users/candidates/all" id="candidates">Candidates<span style="float: right;" class="glyphicon glyphicon-user"></span></a>
  <?php if (!$this->session->userdata('log_in')) : ?>
  <?php if (!$this->session->userdata('voter_in')): ?>
  <a href="#" id="admin" data-toggle="modal" data-target="#myadmin">Admin<span style="float: right;" class="glyphicon glyphicon-log-in"></span></a>
  <?php if (!$this->session->userdata('resultReady')): ?>
   <a href="#" id="votes" data-toggle="modal" data-target="#myvote">Vote<span style="float: right;" class="glyphicon glyphicon-check"></span></a>
 <?php endif; ?>
 <?php if ($this->session->userdata('resultReady')): ?>
   <a href="<?php echo base_url(); ?>vote/results" id="votes">Results<span style="float: right;" class="glyphicon glyphicon-check"></span></a>
 <?php endif; ?>
  <?php endif ?>
  <?php if ($this->session->userdata('voter_in')): ?>
   <a href="<?php echo base_url(); ?>vote/index" id="votes">Vote<span style="float: right;" class="glyphicon glyphicon-check"></span></a>
  <?php endif ?>
<?php endif; ?>
<?php if ($this->session->userdata('log_in')) : ?>
  <a href="<?php echo base_url(); ?>users/register" id="register">Register<span style="float: right;" class="glyphicon glyphicon-edit"></span></a>
  <a href="<?php echo base_url(); ?>users/dashboard" id="dashb">Dashboard<span style="float: right;" class="glyphicon glyphicon-dashboard"></span></a>
<?php endif; ?>
</div>
<!--ADMIN MODAL STARTS-->
<div class="modal fade" id="myadmin" role="dialog">
  <div id="modd" class="modal-dialog" style="top: 30vh; z-index: 9999 !important;">

    <div class="modal-content" style="background: transparent;">
      <div class="modal-body">
      <button style="color: red;" type="button" class="close" data-dismiss="modal">&times;</button>
      <?php echo validation_errors(); ?>
        <?php echo form_open('users/login'); ?>
          <div class="form-group">
            <input type="text" class="form-control" name="username" placeholder="Username" autofocus="autofocus">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="password" placeholder="Password">
          </div>
          <button type="submit" class="btn btn-success">Admin Login</button>
        </form>
      </div>
    </div>                
  </div>              
</div>
<!--ADMIN MODAL ENDS HERE-->

<!--VOTE MODAL STARTS-->
<div style="background: url(<?php echo site_url(); ?>assets/img/votesmart.jpg);" class="modal fade" id="myvote" role="dialog">
  <div id="modd" class="modal-dialog" style="top: 30vh; z-index: 9999 !important;">

    <div class="modal-content">
      <div class="modal-body">
        <button style="color: red;" type="button" class="close" data-dismiss="modal">&times;</button>
        <?php echo form_open('users/loginVoter', array("id" => "voter-login")); ?>
        <div id="votermessage"></div>
          <div id="vote-err" class="form-group">
            <input type="text" class="form-control" name="voterRegNo" id="voterRegNo" placeholder="Registration Number" autofocus="autofocus">
          </div>
          <div id="vote-err" class="form-group">
            <input type="text" class="form-control" name="voterKey" id="voterKey" placeholder="Vote Key">
          </div>
          <button type="submit" class="btn btn-success">Submit</button>
        </form>
      </div>
    </div>                
  </div>              
</div>
<!--VOTE MODAL ENDS HERE-->

<div id="navDiv" class="container-fluid" style="padding-left: 10vh; background-color: #66cdaa; height:100px;">
  <h1 id="logo" style="font-family: Tahoma; font-weight: bold; width: 10%;"><a style="text-decoration: none; color:#2f4f4f;text-shadow: 1px 1px 1px white;" href="<?php echo base_url(); ?>">theVotingApp</a></h1>
  <small><i id="small" style="display: none; position: relative;">...your vote counts <span class="glyphicon glyphicon-ok"></span></i></small>
</div>
<div class="nav-wrapper">
<nav class="navbar navbar-default" data-spy="affix" data-offset-top="100" style="border-radius: 0%; border:none; background-color: #66cdaa;">
	<div class="container-fluid">
    <div class="navbar-header">
      <?php if ($this->session->userdata('log_in') || $this->session->userdata('voter_in')) : ?>
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span style="color: white;" class="glyphicon glyphicon-menu-hamburger"></span>
      </button>
      <?php endif; ?>
      <a class="navbar-brand" href="#" style="font-weight: bold; color: white;"><?= $title; ?></a>
	  <ul style="display: flex; padding-left: 0; flex-wrap: wrap;">
	    <li style="list-style: none; margin-top: 15px;"><a id="date" href="#"><?php date_default_timezone_set('Africa/Lagos'); echo date("l, M Y");
      //echo ', '.date("h:i:sa"); ?></a></li>
	  </ul>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
     <?php if ($this->session->userdata('log_in')) : ?>
    <ul class="nav navbar-nav navbar-right">
      <li><a style="font-weight: bolder; color: white;" href="#"><?php echo ucfirst($this->session->userdata('usernme')); ?></a></li>
      <li><a style="color: white;" href="<?php echo base_url(); ?>users/logout">Logout</a></li>
    </ul>
  <?php endif; ?>
  <?php if ($this->session->userdata('voter_in')) : ?>
    <ul class="nav navbar-nav navbar-right">
      <li><a style="font-weight: bolder; color: white;" href="#"><?php echo ucfirst($this->session->userdata('voter_name')); ?></a></li>
      <li><a style="color: white;" href="<?php echo base_url(); ?>users/logoutVoter">Logout</a></li>
    </ul>
  <?php endif; ?>
  </div>
	 </div>
</nav>
</div>
<?php if (!$this->session->userdata('log_in') && !$this->session->userdata('voter_in')) : ?>
<div class="dropup" style="position: fixed; bottom: 10vh; right: 55vh; z-index: 20 !important;">
<button class="btn btn-primary dropdown-toggle" type="button" style="border-radius: 30%; position: fixed; right: 5vh; box-shadow: 0 0 5px grey;" title="Post campaign"><span class="glyphicon glyphicon-share"></span></button>
   <div class="dropdown-menu" style="background-color: white; width: 50vh; padding:10px 10px;">
      <div id="showmessage"></div>
      <?php echo form_open('pages/create_campaign', array("id" => "campaign-user")); ?>
      <div class="form-group">
  <!--Update by replacing input with a select box here that has options of all the registered users-->
            <input type="text" class="form-control" name="user" id="user" placeholder="Username">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="pass" id="pass" placeholder="Password">
          </div>
          <div class="form-group">
            <textarea class="form-control" name="campaign" id="campaign" maxlength="300" size="300" placeholder="Campaign (Max characters-300)"></textarea><i id="campCount"></i><br>
            <!--input type="file" name="userfile" size="20"-->
          </div>
          <button type="submit" class="btn btn-block" style="color: grey; font-weight: bold; background: transparent; border: 2px solid grey;">Post campaign</button>
          </form>
    </div>
</div>
<?php endif; ?>

<div id="top" class="container-fluid" style="height:100%; margin-left: 40px">
  <?php if ($this->session->flashdata('user_loggedin')) {
      echo '<p class="alert alert-success" id="flashdata">'.$this->session->flashdata('user_loggedin').', '.$this->session->userdata('usernme').'</p>';
    } ?>
    <?php if ($this->session->flashdata('login_failed')) {
      echo '<p style="color: red;" id="flashdata">'.$this->session->flashdata('login_failed').'</p>';
    } ?>
    <?php if ($this->session->flashdata('user_loggedout')) {
      echo '<p class="alert alert-info" id="flashdata">'.$this->session->flashdata('user_loggedout').'</p>';
    } ?>