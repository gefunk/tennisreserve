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

var court_col_positions = new Array();
var time_row_positions = new Array();

var last_update_timestamp;


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
  		    
  		    // initialize positions of courts and timings
  		    $("#reservations > table > tbody > tr:first > td").each(function(index, value){
                court_col_positions.push(
                    { 
                        offset: $(this).offset().left, 
                        id: $(this).attr('court-id')
                    }
                );
  		    });
  		    $("#reservations > table > tbody > tr").each(function(index, value){
  		        var row_id = this.id;
  		        $(this).children('td:first').each(function(){
  		           time_row_positions.push(
  		               {
  		                   offset: $(this).offset().top, 
  		                   id: row_id
  		               }
  		            );
  		        });
                
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
/** displays reservations on page load **/
function display_reservations(display_reservations_url, date, $reservations_table){
	$.get(
		display_reservations_url+"/"+date,
		function(data){
			for(var key in data.reservations){
				if(data.reservations.hasOwnProperty(key)){
					put_reservation_on_calendar (
					    key,
					    data.reservations[key].start_time, 
					    data.reservations[key].end_time, 
					    data.reservations[key].court_id
					);
				}	
			}
			// save timestamp, we use this to check changes periodically
			last_update_timestamp = data.timestamp;
			// start the clock on updating the calendar
			setTimeout(check_update_reservation, 5000);
		},
		"json"
		);
}




/**
    reservation event handlers
**/

/** handles when a user moves a reservation around on the calendar **/
function handle_drop (event, ui) {
    /* 
        figure out which column the user intended to put the reservation
        if they drag more than half of it over to the right column, then it should go right
    */    
    var $element = $(ui.helper);
    // get the closest cell
    var time = find_closest(time_row_positions, $element.offset().top);
    var court = find_closest(court_col_positions, $element.offset().left);
    console.log("Found this ", $("#reservations > table > tbody > tr#"+time+" > td[court-id="+court+"]"));
    $top_cell = $("#reservations > table > tbody > tr#"+time+" > td[court-id="+court+"]");
    
    if($top_cell && $top_cell.length){
        // get the end time cell
        var bottom_time = find_closest(time_row_positions, $top_cell.offset().top+$element.height());
        var $bottom_cell = $("#reservations > table > tbody > tr#"+bottom_time+" > td[court-id="+court+"]");
        console.log("On drag got this bottom cell", $bottom_cell);
        var go_left = $top_cell.position().left+1;
        var go_top = $top_cell.position().top;
        console.log("Should be going Left", go_left, "Top", go_top);
        $(ui.draggable).animate({
            left: go_left,
            top: go_top
        },function(){
            change_reservation($element.attr('id'), $top_cell.attr("court-id"), $top_cell.parent().attr('id'), $bottom_cell.parent().attr('id'));
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
    var $element = $(ui.helper);
    var bottom_time = find_closest(time_row_positions, $element.offset().top+$element.height());
    var court = find_closest(court_col_positions, $element.offset().left);
	var $bottom_cell = $("#reservations > table > tbody > tr#"+bottom_time+" > td[court-id="+court+"]");
    if($bottom_cell && $bottom_cell.length){
        // get the cell below the bottom cell
        $bottom_cell = $bottom_cell.closest('tr').next().children().eq($bottom_cell.index());
        
        // save the reservation information into the database, async
    	change_reservation($(ui.helper).attr("id"), null, null, $bottom_cell.parent().attr('id')); 
        
        /**
            get the height of the div 
            based on the cell below the bottom
            the top of the next cell 
        */
        var height_of_div = calculate_height_div($element,$bottom_cell);
    	$(ui.helper).height(height_of_div);
    }else{
        console.log("Resetting resize");
        $(ui.helper).height(ui.originalSize.height);
    }	
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

/**
    clear reservations from the screen
**/
function clear_reservations () {
    $("div.booking").remove();
}

// calculate the height of the booking div based on the start col and end col
function calculate_height_div($start_td, $end_td){
	var height_of_div = ($end_td.offset().top-$(window).scrollTop()) - ($start_td.offset().top - $(window).scrollTop())  ;
    height_of_div =  height_of_div - ((bottom_padding+top_padding)*2 + 1);   
    return height_of_div;
}

/**
    graphically adds a reservation to the calendar
**/
function put_reservation_on_calendar (reservation_id ,start_time, end_time, court_id) {
    var $start_column = $("tr#"+start_time+" > td[court-id='"+court_id+"']");
	var $end_column = $("tr#"+end_time+" > td[court-id='"+court_id+"']");
	if(!$end_column.length){
	    $end_column = $($start_column.closest('tr').next().children().eq($start_column.index()));
	}
	
	var top =  ($start_column.position().top);
	var left = ($start_column.position().left);
    var height_of_div = calculate_height_div($start_column, $end_column);
	var width = width_of_cell;
	var div_html = '<div id="'+reservation_id+'" '+ 
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


/**
    linear search for the closest number in a list
**/
function find_closest(list, search_value){
    var last_value = null;
    var result = null;
    /*console.log("Search Value", search_value, 
    "Last value in list", list[list.length-1], 
    "Length", list.length);*/
    // check if search_value < 0
    if(search_value < 0){
        result = list[0].id;
    }
    // search value greater than list item in list
    else if(search_value > list[list.length-1].offset){
        //console.log("Should be returning hte last value in the list");
        result = list[list.length-1].id;
    }else{
        // search through list
        for(var index=0; index < list.length; index++){
            var item = list[index];
            if(search_value == item.offset){
                result = item.id;
                break;
            }else if(last_value && 
                (search_value > item.offset && search_value < last_value.offset)
                || (search_value < item.offset && search_value > last_value.offset)){
                    /*console.log("checking absolute value, Item",Math.abs(search_value - item.offset),
                    "Last Value abs",  Math.abs(search_value - last_value.offset),
                    "Last VAlue", last_value);*/
                    // we are in between 2 values in the array
                    if(Math.abs(search_value - item.offset) > Math.abs(search_value - last_value.offset))
                        result = last_value.id;
                    else
                        result = item.id;
                    break;
            }
            last_value = item;
        }
    }
    
    return result;
}

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

/*
    resizable options, global to all reservation divs
*/
function get_resizable_options (width) {
    return { 
    	maxWidth: width,
    	minWidth: width,
    	handles: 's',
    	stop: handle_resize
    };
}