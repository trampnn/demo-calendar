@extends('site.layouts.main-guest')
@section('title', 'Index')
@section('page-css')
	<link rel="stylesheet" href="vendor/jquery-ui-1.12.1/jquery-ui.min.css">
	<link rel="stylesheet" href="site/lib/fullcalendar-3.10.0/fullcalendar.min.css">
	<link rel="stylesheet" href="site/lib/fullcalendar-3.10.0/fullcalendar.print.min.css" media="print">
@stop
@section('style')
	<style>
	  body {
	    margin-top: 40px;
	    text-align: center;
	    font-size: 14px;
	    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
	  }

	  #wrap {
	    width: 1100px;
	    margin: 0 auto;
	  }

	  #external-events {
	    float: left;
	    width: 150px;
	    padding: 0 10px;
	    border: 1px solid #ccc;
	    background: #eee;
	    text-align: left;
	  }

	  #external-events h4 {
	    font-size: 16px;
	    margin-top: 0;
	    padding-top: 1em;
	  }

	  #external-events .fc-event {
	    margin: 10px 0;
	    cursor: pointer;
	  }

	  #external-events p {
	    margin: 1.5em 0;
	    font-size: 11px;
	    color: #666;
	  }

	  #external-events p input {
	    margin: 0;
	    vertical-align: middle;
	  }

	  #calendar {
	    float: right;
	    width: 900px;
	  }
	</style>
@stop
@section('page-js')
	<script src="vendor/jquery-ui-1.12.1/jquery-ui.min.js"></script>
	<script src="site/lib/fullcalendar-3.10.0/lib/moment.min.js"></script>
	<script src="site/lib/fullcalendar-3.10.0/fullcalendar.min.js"></script>
@stop
@section('script')
	<script type="text/javascript">
	  $(document).ready(function() {
	    /* initialize the external events
	    -----------------------------------------------------------------*/

	    $('#external-events .fc-event').each(function() {
	      // store data so the calendar knows to render an event upon drop
	      $(this).data('event', {
	        title: $.trim($(this).text()), // use the element's text as the event title
	        stick: true // maintain when user navigates (see docs on the renderEvent method)
	      });

	      // make the event draggable using jQuery UI
	      $(this).draggable({
	        zIndex: 999,
	        revert: true,      // will cause the event to go back to its
	        revertDuration: 0  //  original position after the drag
	      });
	    });


	    /* initialize the calendar
	    -----------------------------------------------------------------*/

	    $('#calendar').fullCalendar({
	    	defaultView: 'agendaWeek',
	      header: {
	        left: 'prev,next today',
	        center: 'title',
	        right: 'month,agendaWeek,agendaDay'
	      },
	      editable: true,
	      droppable: true, // this allows things to be dropped onto the calendar
	      drop: function() {
	        // is the "remove after drop" checkbox checked?
	        if ($('#drop-remove').is(':checked')) {
	          // if so, remove the element from the "Draggable Events" list
	          $(this).remove();
	        }
	      },
	      eventClick: function(calEvent, jsEvent, view) {
			    alert('Event: ' + calEvent.title);
			    alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
			    alert('View: ' + view.name);

			    // change the border color just for fun
			    $(this).css('border-color', 'red');
			  }
	    });
	  });
	</script>
@stop
@section('content')
	<div id='wrap'>
    <div id='external-events'>
      <h4>Draggable Events</h4>
      <div class='fc-event'>My Event 1</div>
      <div class='fc-event'>My Event 2</div>
      <div class='fc-event'>My Event 3</div>
      <div class='fc-event'>My Event 4</div>
      <div class='fc-event'>My Event 5</div>
      <p>
        <input type='checkbox' id='drop-remove' />
        <label for='drop-remove'>remove after drop</label>
      </p>
    </div>
    <div id='calendar'></div>
    <div style='clear:both'></div>
  </div>
@stop
@section('page-modal')