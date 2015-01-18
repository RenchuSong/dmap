<div id="top-menu">
    <ul id="topmenu">
         <li><a id="topmenu-home" href="index.php?topid=home" title="Home">Home</a></li>
             <?php 
			      if(isset($_SESSION['dmapUser'])){
					  echo '<li><a id="topmenu-myspace" href="index.php?topid=myspace" title="My space">My space</a></li>';
					  } 
				  ?>
         <li>
                  <a id="topmenu-login" href="javascript:showLoginDialog();" title="Login/out"><?php 
				  if(isset($_SESSION['dmapUser'])&&isset($_SESSION['dmapUserAuthority'])) echo "Logout";else echo "Login"; ?></a>
         </li>
         <li><a id="topmenu-help" href="index.php?topid=help" title="Help">Help</a></li>
         <li><a id="topmenu-contact" href="index.php?topid=contact" title="Contact us">Contact us</a></li>
             
    </ul>
</div>
<script language="javascript">
/*$('#topmenu-'+'<?php echo $_GET['topid']; ?>').addClass("LinkOver");
*/
</script>