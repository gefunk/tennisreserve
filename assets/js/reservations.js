
var clicked_row = null;
var row_index = null;
var clicked_day = null;
var last_added_reservation = null;

// keep track of the year,month,and day selected on the page
var selected_month = null;
var selected_year = null;
var selected_day = (new Date()).getDay();

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


// these variables to set padding of reservation div
var bottom_padding = 2;
var top_padding = 3;
var left_padding = 5;
var right_padding = 8;

/**
	get the month calendar on page load
	and set the Month and Day on the calendar title element
**/
function initialize_calendar (calendar_post_url, res_url) {
    $.get(
    	calendar_post_url,
    	function(data){
    		$("#month-calendar").append(data.calendar);
    		selected_month = data.month;
    		selected_year = data.year;
    		selected_day = (new Date()).getDate();
    		var day_header = monthNames[parseInt(selected_month,10)-1] + ' ' + selected_day;
    		$("#calendar-title").html("<h1>"+day_header+"</h1><h4>"+weekday[(new Date()).getDay()]+"</h4>");
    		
    		// call display reservations after we get the calendar from the backend
    		// display_reservations(res_url, selected_year+'-'+selected_month+'-'+selected_day);
    	},
    	"json"
    );
    
}


/**
	paint the reservations on the time table 
**/
function display_reservations(display_reservations_url, date){
	$.get(
		display_reservations_url+"/"+date,
		function(data){
			// loop through result set
			for(var key in data){
				if(data.hasOwnProperty(key)){
					var start_time = data[key].start_time;
					var end_time = data[key].end_time;
					console.log("Start Time", start_time, "End Time", end_time, "id", key);
					
					var start_div = $("#"+start_time);
					var end_div = null;
					if(end_time != "00_00"){
					    end_div = start_div;
					}else{
					    end_div = $("#"+end_time);
					}
					
					
					// calculate the top location of where the div should be added
                	var top = start_div.position().top+top_padding;
                	var height = end_div.height()-bottom_padding;
                	var width = $(tdcell).width()-right_padding;
                	var left = (col_position.left+left_padding);
					
					
					
					$("table#time").before(function(){
        			    console.log("I should be adding this ",data.id);
        			    return $('<div id="'+data.id+ 
        			    '"class="booking"'+ 
        			    'rel="popover"'+
        			    'style="top:'+top+'px;left:'+left+'px;height:'+height+'px;width:'+width+'px">'+
        			    'New Reservation'+
        			    '</div>').resizable(
                			{ 
                				maxWidth: width,
                				minWidth: width,
                				handles: 's',
                				stop: change_reservation
                			}
                		).draggable({
                		    revert: 'invalid'
                		});
        			});
				}
			}
		},
		"json"
		);
}


function gray_out_closed_times (timing_url) {
    $.get(
        timing_url,
        function(data){
            var start_time = parseInt(data.open_time.split()[0],10);
            for(var time = 0; time < start_time; time++){
                $('#'+"0"+time+"_00").addClass('not-available');
                $('#'+"0"+time+"_30").addClass('not-available');
            }
            var end_time = parseInt(data.close_time.split()[0],10);
            console.log("End Time", end_time);
            for(var time = end_time; time < 24; time++){
                console.log("Time should be gray",time+"_00");
                $('#'+time+"_00").addClass('not-available');
                $('#'+time+"_30").addClass('not-available');
            }
        },
        "json"
    );
}


function new_reservation (tdcell, start_row, start_post_url) {
	/* 
		there hasn't been a table row clicked, 
		set the clicked_row variable to equal the currently clicked row
	*/
	var time = start_row.id;				
	console.log("This is what i got",time, "This is the cell that was clicked", $(tdcell));
	/** 
		calculate where to place the reservation div 
	**/
	// get the table cell, position
	var col_position = $(tdcell).offset();

	// calculate the top location of where the div should be added
	var top = col_position.top+top_padding;
	var height = $(tdcell).height()-bottom_padding;
	var width = $(tdcell).width()-right_padding;
	var left = (col_position.left+left_padding);
	
	console.log("top", top, "height", height, "width", width, "left", left);
	
	$.post(
		start_post_url,
		{
			user_id: 1,
			court_id: 1,
			date: selected_year+"-"+selected_month+"-"+selected_day,
			start_time: time
		},
		function(data){
			last_added_reservation = data.id;
			
			// add the div to the page on top of the table
			$("body").before(function(){
			    console.log("I should be adding this ",data.id);
			    return $('<div id="'+data.id+ 
			    '"class="booking"'+ 
			    'rel="popover"'+
			    'style="top:'+top+'px;left:'+left+'px;height:'+height+'px;width:'+width+'px";>'+
			    'New Reservation'+
			    '</div>').resizable(
        			{ 
        				maxWidth: width,
        				minWidth: width,
        				handles: 's',
        				stop: change_reservation
        			}
        		).draggable({
        		    revert: 'invalid'
        		});
			});
		},
		'json'
	);
}


/**
	change in reservation
**/
function change_reservation(event, ui){
	console.log("Event type", event.type, "Div", $(ui.helper), "Target", event.target);
	// these variables have to calculated everytime
	var res = $(ui.helper);
	
	var top_cell = document.elementFromPoint(ui.position.left-5,ui.position.top+10-$(window).scrollTop());
	var top_right_cell = document.elementFromPoint(ui.position.left+$(top_cell).width()+5, ui.position.top+10-$(window).scrollTop());
	if(top_right_cell && top_right_cell.nodeName.toLowerCase() == 'td'){
	    var top_cell_position = $(top_cell).offset();
	    var border = top_cell_position.left+$(top_cell).width()+(res.width()/2);
	    var middle = (res.position().left+res.width());
	    if(middle > border)
	        top_cell = top_right_cell;
	}
	var bottom_cell = document.elementFromPoint(ui.position.left-5,(ui.position.top+$(ui.helper).height()+2)-$(window).scrollTop());
	
	// check if top and bottom cell's are td's
	if(top_cell.nodeName.toLowerCase() == 'td' && bottom_cell.nodeName.toLowerCase() == 'td'){
	    // more than half the div is on the right, then go to the right column

    	// variables used to calculate position of div
    	var top_cell_position = $(top_cell).offset();
    	var top_right_cell_position = $(top_right_cell).offset();
    	var bottom_cell_position = $(bottom_cell).offset();
    	var bottom_cell_height = $(bottom_cell).height();
        var border = top_cell_position.left+$(top_cell).width()+(res.width()/4);
        console.log(
            "top cell", top_cell, 
            "top left", top_cell_position.left,
            "border", top_cell_position.left+$(top_cell).width()+(res.width()/4),
            "middle", (res.position().left+res.width()),
            "top right cell", top_right_cell, 
            "top right cell left", top_right_cell_position.left,
            "bottom_cell", bottom_cell
        );

    	// variables for location of div
    	var height_of_div = (bottom_cell_position.top-top_cell_position.top)+bottom_cell_height-bottom_padding;

    	// resizable event
    	if(event.type == 'resizestop'){
    		// change height of div
    		res.height(height_of_div);
    	}else if(event.type == 'drop'){
    		console.log("inside drop");

    		// these only have to be calculated at the drop event
    		var top_of_div = top_cell_position.top + top_padding;
    		var left_of_div = top_cell_position.left + left_padding; 
    		// fit to time calendar
    		res.animate({
    			top: top_of_div,
    			left: left_of_div
    		}); //.height(height_of_div);
    	}
    }    
	
	
}

