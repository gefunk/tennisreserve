<link href="<?php echo base_url();?>assets/css/calendar.css" rel="stylesheet">
<script language="javascript" src="<?php echo base_url();?>assets/js/calendar.js"></script>

<script>
$(document).ready(function(){
	// calendar on the right hand side
	initialize_time_table('<?php echo site_url("facility/get_time_calendar/10"); ?>', '<?php echo site_url("courts/get_reservations"); ?>');
	
	var $topbar = $("#heading"),
		$sidebar = $("#timings");
		$window = $(window),
		topoffset = $topbar.offset(),
		sideoffset = $sidebar.offset(),
		topPadding = $("div.navbar").height(),
		sidePadding = 10,
		navbarHeight = $("div.navbar").height();
		
	$window.scroll(function(){
		if ($window.scrollTop() > topoffset.top-navbarHeight) {
			$topbar.stop().animate({
		    	marginTop: $window.scrollTop() - topoffset.top + topPadding
		    });
		 } else {
		    $topbar.stop().animate({
		       marginTop: 0
		    });
		 }
		
		if($window.scrollLeft() > sideoffset.left){
			$sidebar.stop().animate({
		    	marginLeft: $window.scrollLeft() - sideoffset.left + sidePadding
		    });
		}else{
			$sidebar.stop().animate({
				marginLeft: 0
			});
		}
	});
});
</script>

<div id="heading">
	
</div>
<div id="timings">
	
</div>
<div id="reservations">
	
</div>