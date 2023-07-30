/*
Name: 			Pages / Calendar - Examples
Written by: 	Okler Themes - (http://www.okler.net)
Theme Version: 	1.1.0
*/

(function( $ ) {

	'use strict';

	var initCalendarDragNDrop = function() {
		$('#external-events div.external-event').each(function() {

			// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
			// it doesn't need to have a start or end
			var eventObject = {
				title: $.trim($(this).text()) // use the element's text as the event title
			};

			// store the Event Object in the DOM element so we can get to it later
			$(this).data('eventObject', eventObject);

			// make the event draggable using jQuery UI
			$(this).draggable({
				zIndex: 999,
				revert: true,      // will cause the event to go back to its
				revertDuration: 0  //  original position after the drag
			});

		});
	};

	var initCalendar = function() {
		var $calendar = $('#calendar');
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		$calendar.fullCalendar({
			
			header: {
				left: 'title',
				//right: 'prev,today,next,basicDay,basicWeek,month'
				right: 'prev,today,next,year'
			},

			//timeFormat: 'h:mm',
			timeFormat: '',

			titleFormat: {
				month: 'MMMM 2021',      // September 2009
				//month: 'MMMM yyyy',      // September 2009
			    week: "MMM d yyyy",      // Sep 13 2009
			    day: 'dddd, MMM d, yyyy', // Tuesday, Sep 8, 2009m
			    defaultView: 'year',
    			yearColumns: 3,
			},

			themeButtonIcons: {
				prev: 'fa fa-caret-left',
				next: 'fa fa-caret-right',
			},


			editable: false,
			droppable: false, // this allows things to be dropped onto the calendar !!!
			drop: function(date, allDay) { // this function is called when something is dropped
				var $externalEvent = $(this);
				// retrieve the dropped element's stored Event Object
				var originalEventObject = $externalEvent.data('eventObject');

				// we need to copy it, so that multiple events don't have a reference to the same object
				var copiedEventObject = $.extend({}, originalEventObject);

				// assign it the date that was reported
				copiedEventObject.start = date;
				copiedEventObject.allDay = allDay;
				copiedEventObject.className = $externalEvent.attr('data-event-class');

				// render the event on the calendar
				// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
				$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

				// is the "remove after drop" checkbox checked?
				if ($('#RemoveAfterDrop').is(':checked')) {
					// if so, remove the element from the "Draggable Events" list
					$(this).remove();
				}

			},
			events: [
				{
					title: '신정',
					start: new Date(y, m, 1),
					className: 'fc-event-danger'
				},
			
				{
					title: '일요일',
					start: new Date(y, m, 3),					
					allDay: false,
					className: 'fc-event-danger'
				},
					
				{
					title: '일요일',
					start: new Date(y, m, 10),					
					allDay: false,
					className: 'fc-event-danger'
				},
				{
					title: '일요일',
					start: new Date(y, m, 17),					
					allDay: false,
					className: 'fc-event-danger'
				},
				{
					title: '일요일',
					start: new Date(y, m, 24),					
					allDay: false,
					className: 'fc-event-danger'
				},
				{
					title: '일요일',
					start: new Date(y, m, 31),					
					allDay: false,
					className: 'fc-event-danger'
				},
					{
					title: '기후불능일',
					start: new Date(y, m, 12),					
					allDay: false,
					
				},
					{
					title: '기후불능일',
					start: new Date(y, m, 7),					
					allDay: false,
					
				},
					{
					title: '기후불능일',
					start: new Date(y, m, 20),					
					allDay: false,
					
				},
			
			]
		});

		// FIX INPUTS TO BOOTSTRAP VERSIONS
		var $calendarButtons = $calendar.find('.fc-header-right > span');
		$calendarButtons
			.filter('.fc-button-prev, .fc-button-today, .fc-button-next')
				.wrapAll('<div class="btn-group mt-sm mr-md mb-sm ml-sm"></div>')
				.parent()
				.after('<br class="hidden"/>');

		$calendarButtons
			.not('.fc-button-prev, .fc-button-today, .fc-button-next')
				.wrapAll('<div class="btn-group mb-sm mt-sm"></div>');

		$calendarButtons
			.attr({ 'class': 'btn btn-sm btn-default' });
	};

	$(function() {
		initCalendar();
		initCalendarDragNDrop();
	});

}).apply(this, [ jQuery ]);