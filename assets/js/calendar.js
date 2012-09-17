// keep track of the year,month,and day selected on the page
var selected_month = (new Date()).getMonth();
var selected_year = (new Date()).getFullYear();
var selected_day = (new Date()).getDate();

// month lookup 
var monthNames = [ "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December" ];
// day of week lookup
var weekday=new Array(7);
weekday[0]="Sunday";
weekday[1]="Monday";
weekday[2]="Tuesday";
weekday[3]="Wednesday";
weekday[4]="Thursday";
weekday[5]="Friday";
weekday[6]="Saturday";



/* 
set global options for the draggable event
reset draggable revert to invalid when dragging stops
we do this because we set revert to true
when the booking div doesn't find anything to drop on
*/
var draggable_options = {
    revert: 'invalid',
    stop: function(){
            $(this).draggable('option','revert','invalid');
        }
};
/**
	get the month calendar on page load
	and set the Month and Day on the calendar title element
**/
function initialize_time_table (time_table_url, res_url) {
    $.get(
    	time_table_url,
    	function(data){
    		
    		$("#heading").html(data.heading);
    		// calculate bottom of header
    		var top = $("#heading").position().top+$("#heading").height()+1;
    		// position the timing div
    		$("#timings").html(data.timings).css("top", top);
    		// move the headings to the left of the timings
    		$("#heading").css("left", ($("#heading").position().left + $("#timings").width())+"px")
    		// create and position the reservations table
            $("#reservations")
    		    .html(data.reservations)
    		    .css({"top": $("#heading").height()+1, "left": $("#timings > table").width()})
    		    .droppable({
    		        drop: handle_drop
    		    });
  		
    		// call display reservations after we get the calendar from the backend
    		display_reservations(res_url, selected_year+'-'+parseInt(selected_month+1)+'-'+selected_day, null);
    	},
    	"json"
    );
    
}

// these variables to set padding of reservation div
var bottom_padding = 3;
var top_padding = 3;
var left_padding = 1;
var right_padding = 1;

var height_of_cell = 15;
var width_of_cell = 188;

// make a new reservation in the system
function make_new_reservation ($cell, url, facility_id) {
	var time = $cell.parent().attr('id');
	var court_id = $cell.attr('court-id');
	//console.log("time",time,"court_id",court_id,"url",url);
	
	var col_position = $cell.position();
	var top = col_position.top+top_padding;
	var height = height_of_cell;
	var width = width_of_cell;
	var left = (col_position.left+left_padding);
	
	console.log(
	    "Width", width,
	    "height", height
	    );
	
	$.post(
		url,
		{
			user_id: 1,
			court_id: court_id,
			facility_id: facility_id,
			date: selected_year+"-"+parseInt(selected_month+1)+"-"+selected_day,
			start_time: time
		},
		function(data){
			last_added_reservation = data.id;
			
			// add the div to the page on top of the table
			$cell.prepend(function(){
			    console.log("I should be adding this ",data.id);
			    return $('<div id="'+data.id+'" '+ 
			    'class="booking" '+ 
			    'rel="popover" '+
			    '>New Reservation'+
			    '</div>').resizable(get_resizable_options(width)).draggable(draggable_options);
			});
		},
		'json'
	);
	
}

function display_reservations(display_reservations_url, date, $reservations_table){
	$.get(
		display_reservations_url+"/"+date,
		function(data){
			for(var key in data){
				if(data.hasOwnProperty(key)){
					var start_time = data[key].start_time;
					var end_time = data[key].end_time;
					var court_id = data[key].court_id;
					var $start_column = $("tr#"+start_time+" > td[court-id='"+court_id+"']");
					var $end_column = $("tr#"+end_time+" > td[court-id='"+court_id+"']");
					if(!$end_column.length){
					    $end_column = $($start_column.closest('tr').next().children().eq($start_column.index()));
					}
					
					var top =  ($start_column.position().top);
					var left = ($start_column.position().left);
                    var height_of_div = calculate_height_div($start_column, $end_column);
					var width = width_of_cell;
					var div_html = '<div id="'+key+'" '+ 
    			    'class="booking" '+ 
    			    'rel="popover" '+
    			    'style="position:absolute;top:'+top+'px;left:'+left+'px;height:'+height_of_div+'px;">'+
    			    'New Reservation'+
    			    '</div>';
					$(div_html)
					    .resizable(get_resizable_options(width))
					    .draggable(draggable_options)
					    .appendTo("#reservations");
				}
			}
			// if we are asked to animate the fade in
			if($reservations_table && $reservations_table.length){
			    $reservations_table.fadeIn();
			}
			
		},
		"json"
		);
}

function handle_drop (event, ui) {
    /* 
        figure out which column the user intended to put the reservation
        if they drag more than half of it over to the right column, then it should go right
    */    
    var $element = $(ui.helper);
    var element_width = $element.width();
    var top = ui.offset.top - $(window).scrollTop() - 2;
    var left = ui.offset.left - $(window).scrollLeft() - 3;
    //var top = ui.position.top;
    //var left = ui.position.left;
    var element_found = document.elementFromPoint(left,top);
    console.log(
        "Element Found", element_found,
        "Top", top,
        "left", left);
    // check if we have found a table cell to drop it on
    var bottom_cell = get_bottom_cell($div);
    if(element_found.nodeName.toLowerCase() == 'td'){    
        var $top_cell = $(element_found);
        var top_cell_right = ($top_cell.offset().left - $(window).scrollLeft())+$top_cell.width();
        console.log("Originally PIcked", $top_cell, "right", top_cell_right);
        var middle_of_element = left + (element_width/2);
        if(middle_of_element > top_cell_right){
            $top_cell = $top_cell.next();
        }
    
        var go_left = $top_cell.position().left+1;
        var go_top = $top_cell.position().top;
        console.log("Should be going Left", go_left, "Top", go_top);
        $(ui.draggable).animate({
            left: go_left,
            top: go_top
        });
    }else{
        console.log("Did not find td reverting");
        // revert to original position
        ui.draggable.draggable('option','revert',true);
    }
}


/**
    resize of reservation div
**/
function handle_resize(event, ui){
    var $div = $(ui.helper);
	var bottom_cell =  get_bottom_cell($div);
    if(bottom_cell.nodeName.toLowerCase() == 'td'){
        // get the cell below the bottom cell
        bottom_cell = $(bottom_cell).closest('tr').next().children().eq($(bottom_cell).index());
        
        // save the reservation information into the database, async
    	change_reservation($(ui.helper).attr("id"), null, null, $(bottom_cell).parent().attr('id')); 
        
        /**
            get the height of the div 
            based on the cell below the bottom
            the top of the next cell 
        */
        var height_of_div = calculate_height_div($div,$(bottom_cell));
    	$(ui.helper).height(height_of_div);
    }	
}

/**
    clear reservations from the screen
**/
function clear_reservations () {
    $("div.booking").remove();
}


/*
    listens for the scroll event
    moves the header (Court names)
    and the side bar (Times)
    when the user scrolls to see the whole calendar
*/
function attach_scroll_handler () {
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
}



/**
    helper functions
**/

// get the cell which is at the bottom of the booking div 
function get_bottom_cell ($div) {
    var left = $div.offset().left-$(window).scrollLeft()-1;
    var top = ($div.offset().top-$(window).scrollTop())+$div.height()+2;
	var element = document.elementFromPoint(left,top);
	if(element.length && element.nodeName.toLowerCase() == 'td'){
	    return element;
	}
	return null;
}

// calculate the height of the booking div based on the start col and end col
function calculate_height_div($start_td, $end_td){
	var height_of_div = ($end_td.offset().top-$(window).scrollTop()) - ($start_td.offset().top - $(window).scrollTop())  ;
    height_of_div =  height_of_div - ((bottom_padding+top_padding)*2 + 1);   
    return height_of_div;
}

function get_resizable_options (width) {
    return { 
    	maxWidth: width,
    	minWidth: width,
    	handles: 's',
    	stop: handle_resize
    };
}