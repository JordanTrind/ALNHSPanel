<?php
if(!$me->hasPermission("consultants") && !$me->hasPermission("seniorappteam") && !$me->hasPermission("app_team")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>

<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <iframe class="embed-sheat noheader" src="https://docs.google.com/forms/d/e/1FAIpQLScr1UQ2BInVFHqobt2UJcUIf37wvSiw1LIvudh6dvfo44KVhQ/viewform"></iframe>
        <div stlye="clear: both;"></div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
