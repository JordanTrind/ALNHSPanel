<?php
if(!$me->hasPermission("mto") && !$me->hasPermission("smto") && !$me->hasPermission("consultants")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <iframe class="embed-sheat noheader" src="https://docs.google.com/forms/d/e/1FAIpQLSfnL3I7EXCtVtXh4QJROoV846MKT4Hi1f4BOhAzHiGMagjLrA/viewform?embedded=true"></iframe>
        <div stlye="clear: both;"></div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
