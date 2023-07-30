     var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
           var calendar = new Array();

        for (var i = 0; i < 12; i++) {
            calendar[i] = $("div[id='calendar" + i + "']").fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title'
                    right:'resourceDay,resourceWeek,resourceNextWeeks,resourceMonth'
                },
                defaultView: 'resourceMonth',
                firstDay: 1,
                editable: true,
                selectable: true,
                minTime: 8,
                maxTime: 16,
                monthno: i,  //custom property
                selectHelper: true,
                resources: [{ "name": "Resource 1", "id": "resource1" },
              { "name": "Resource 2", "id": "resource2" },
              { "name": "Resource 3", "id": "resource3" },
              { "name": "Resource 4", "id": "resource4" }
              ],
                events: [
            {
                title: 'Lunch 12.15-14.45',
                start: new Date(y, m, d, 12, 15),
                end: new Date(y, m, d, 14, 45),
                allDay: false,
                resource: 'resource1'
            },
            {
                title: 'Meeting',
                start: new Date(y, m, d, 10, 30),
                end: new Date(y, m, d + 4, 11, 00),
                allDay: false,
                resource: 'resource1'
            },
                {
                    title: 'All Day Event',
                    start: new Date(y, m, 1),
                    resource: 'resource2'
                }
        ],
                dayClick: function (date, allDay, jsEvent, view) {
                    alert(date);
                },
                select: function (start, end, allDay, jsEvent, view, resource) {
                    var title = prompt('event title:');
                    if (title) {
                        calendar[start.getMonth()].fullCalendar('renderEvent',
                    {
                        title: title,
                        start: start,
                        end: end,
                        allDay: allDay,
                        resource: resource.id
                    },
                    true // make the event "stick"
                );
                    }
                    calendar[start.getMonth()].fullCalendar('unselect');
                },
                eventDrop: function (event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view) {
                    alert('event moved to ' + event.start + ' to ' + event.resource);
                },
                eventResize: function (event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view) {
                    alert('event was resized, new endtime: ' + event.end);
                },
                eventClick: function (event, jsEvent, view) {
                    alert('event ' + event.title + ' was clicked');
                }                  
            });
        }         