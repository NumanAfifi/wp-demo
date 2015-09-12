jQuery(document).ready(function($) {
  $('#calendar').fullCalendar({
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'month,basicWeek,basicDay'
    },
    editable: false,
    eventLimit: true, // allow "more" link when too many events
    eventBorderColor: '#FFF',
    events: {
      url: tdvars.ajaxurl,
      data: {
        action: 'td_events'
      }
    }
  });

  $('#test').focus().select();
});