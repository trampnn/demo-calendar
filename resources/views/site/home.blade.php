@extends('site.layouts.main-guest')
@section('title', 'Index')
@section('page-css')
	<link rel="stylesheet" href="vendor/jquery-ui-1.12.1/jquery-ui.min.css">
	<link rel="stylesheet" href="vendor/bootstrap-4.2.1-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="site/lib/fullcalendar-3.10.0/fullcalendar.min.css">
	<link rel="stylesheet" href="site/lib/fullcalendar-3.10.0/fullcalendar.print.min.css" media="print">
	<link rel="stylesheet" href="site/lib/fullcalendar-scheduler-1.9.4/scheduler.min.css">
@stop
@section('style')
	<style>	    
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


	  /*#calendar thead.fc-head td {
			height: 48px;
			vertical-align: middle;
	  }*/
	</style>
@stop
@section('content')
	<section class="py-5">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-3">
					<div id='external-events'>
			      <h4>Draggable Events</h4>
			      <div class='fc-event'>Lịch Xe 1</div>
			      <div class='fc-event'>Lịch Xe 2</div>
			      <div class='fc-event'>Lịch Xe 3</div>
			      <p>
			        <input type='checkbox' id='drop-remove' />
			        <label for='drop-remove'>remove after drop</label>
			      </p>
			    </div>
				</div>

				<div class="col-12 col-md-9">
					<div id='calendar'></div>
				</div>
			</div>
		</div>
	</section>
@stop
@section('page-modal')
	<div class="modal" id="eventModal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title"></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <p>Ngày bắt đầu: <span class="start-day"></span></p>
	        <p>Ngày kết thúc: <span class="end-day"></span></p>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary">Save changes</button>
	      </div>
	    </div>
	  </div>
	</div>

	<div class="modal" id="createEventModal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title">Tạo lịch mới</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<div class="form-group">
				    <label for="title">Tiêu đề</label>
				    <input type="text" class="form-control" name="title">
				  </div>
				  <input type="hidden" name="dayStart">
				  <input type="hidden" name="dayEnd">
				  <input type="hidden" name="verhicleID">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" id="createEvent">Thêm lịch</button>
	      </div>
	    </div>
	  </div>
	</div>
@stop
@section('page-js')
	<script src="vendor/jquery-ui-1.12.1/jquery-ui.min.js"></script>
	<script src="vendor/bootstrap-4.2.1-dist/js/bootstrap.min.js"></script>
	<script src="site/lib/fullcalendar-3.10.0/lib/moment.min.js"></script>
	<script src="site/lib/fullcalendar-3.10.0/fullcalendar.min.js"></script>
	<script src="site/lib/fullcalendar-scheduler-1.9.4/scheduler.min.js"></script>
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

	   	$('#calendar').fullCalendar({
	   		schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
	      now: moment(),
	      editable: true, // enable draggable events
	      droppable: true, // this allows things to be dropped onto the calendar
        eventLimit: true, // allow "more" link when too many events
        selectable: true,
	      aspectRatio: 'none',
	      timeFormat: 'H(:mm)', // uppercase H for 24-hour clock
	      customButtons: {
			    monthPicker: {
			      icon: 'fa fas fa-calendar-alt',
			      click: function() {
			        alert('clicked the custom button!');
			      }
			    }
			  },
	      header: {
	        left: 'title',
	        center: '',
	        right: 'monthPicker prev,next'
	      },
	      defaultView: 'timeline',
	      duration: { months: 1 },
	      /*views: {
	      	timelineMonth: {
	      		type: 'timeline',
	          duration: { months: 1 }
	      	},
	        timelineThreeMonths: {
	          type: 'timeline',
	          duration: { months: 3 }
	        }
	      },*/
	      /*visibleRange: {
		      start: moment().startOf('month'),
		      end: moment().endOf('month').add(1, 'days')
		    },*/
	      resourceAreaWidth: '10%',
      	resourceLabelText: 'Xe',
	      resources: [
	        { id: 'a', title: 'Xe 1', eventColor: 'blue' },
	        { id: 'b', title: 'Xe 2', eventColor: 'green' },
	        { id: 'c', title: 'Xe 3', eventColor: 'orange' }
	      ],
	      drop: function(date, jsEvent, ui, resourceId) {
	        console.log('drop', date.format(), resourceId);

	        // is the "remove after drop" checkbox checked?
	        if ($('#drop-remove').is(':checked')) {
	          // if so, remove the element from the "Draggable Events" list
	          $(this).remove();
	        }
	      },
	      eventReceive: function(event) { // called when a proper external event is dropped
	        console.log('eventReceive', event);
	      },
	      eventDrop: function(event) { // called when an event (already on the calendar) is moved
	        console.log('eventDrop', event);
	      },
	      eventClick: function(calEvent, jsEvent, view) {
	      	var title = calEvent.title,
	      			dayStart = moment(calEvent.start).format('DD/M/YYYY, H:mm'),
	      			dayEnd = moment(calEvent.end).format('DD/M/YYYY, H:mm');
	      	$('#eventModal').find('.modal-title').text(title).end()
	      									.find('.start-day').text(dayStart).end()
	      									.find('.end-day').text(dayEnd);

	      	$('#eventModal').modal();
			  },
			  select: function (start, end, event, view, resource) {
	      	$('#createEventModal').find('input[name="dayStart"]').val(start).end()
	      												.find('input[name="dayEnd"]').val(end).end()
	      												.find('input[name="verhicleID"]').val(resource.id);

	      	$('#createEventModal').modal();

		    	$('#createEvent').on('click', function () {
		    		var closest = $(this).closest('#createEventModal'),
		    				title = closest.find('input[name="title"]').val(),
		    				dayStart = closest.find('input[name="dayStart"]').val(),
		    				dayEnd = closest.find('input[name="dayEnd"]').val(),
		    				verhicleID = closest.find('input[name="verhicleID"]').val();

		        if (title) {
		          $("#calendar").fullCalendar('renderEvent', {
		            title: title,
		            start: dayStart,
		            end: dayEnd,
		            resourceId: verhicleID
		          }, true);
		        }

        		$("#calendar").fullCalendar('unselect');

		        // Clear modal inputs
		        $('#createEventModal').find('input').val('');

		        // hide modal
		        $('#createEventModal').modal('hide');
		    	});
			  }
	    });
	  });
	</script>
@stop