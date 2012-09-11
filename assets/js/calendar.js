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
    		$("#reservations").html(data.reservations).css({"top": $("#heading").height()+1, "left": $("#timings > table").width()});
  		
    		// call display reservations after we get the calendar from the backend
    		// display_reservations(res_url, selected_year+'-'+selected_month+'-'+selected_day);
    	},
    	"json"
    );
    
}