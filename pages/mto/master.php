<?php
if(!$me->hasPermission("mto") && !$me->hasPermission("smto") && !$me->hasPermission("consultants")) {
    die("<h1 class='error'>Permission denied!</h1>");
}
?>
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <iframe class="embed-sheat noheader" src="https://docs.google.com/forms/d/e/1FAIpQLSeX9gisW0VYvbEVLzMdJ40WBRQneuJumJ0v9Kmvr3QuNYkf0w/viewform?embedded=true&usp=pp_url&entry.259787756=%22<?=$me->getSteamid()?>%22&entry.1869560408&entry.1875229128&embedded=true"></iframe>
        <div stlye="clear: both;"></div>
    </div>
</div>
<!-- /#page-wrapper -->
