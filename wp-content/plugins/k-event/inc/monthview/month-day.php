<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
?>
<%  %>
<% if (events.length > 0) { %>
<div class="cal-month-day has-background <%= cls %>" <% _.each(events, function(event) { if ( event.style == 'style-2' ) { if ( event.class ) { %> style="background:<%= event.class%>" <% } else { %> style="background: #3f51b5;" <% }}}); %> data-day-val="<%= data_day %>">
<% } else { %>
<div class="cal-month-day <%= cls %>" data-day-val="<%= data_day %>">
<% } %>
	<span class="cal-slide-tick"></span>
	<span class="pull-left" data-cal-date="<%= data_day %>" data-cal-view="day" data-toggle="tooltip" title="<%= tooltip %>"><%= day %></span>
	<% if (events.length > 0) { %>
		<div class="k2t-tooltip">
			<span><?php _e( 'Event today:' );?></span>
			<%
			iz=0;
			_.each(events, function(event) { 
			iz=iz+1;
			%>
				<a href="<%= event.url %>" target="_blank"><span>• <%= event.startDate %>: <%= event.title %></span></a>
			<% }); %>
		</div>
		<div class="events-list" data-cal-start="<%= start %>" data-cal-end="<%= end %>">
			<%
			iz=0;
			_.each(events, function(event) { 
			iz=iz+1;
			%>
				<a href="<%= event.url %>" class="event-item" target="_blank" data-next-carousel="<%=iz%>" data-event-id="<%= event.id %>" data-event-class="<%= event["class"] %>' ?>" <% if( event["class"] && event.style == 'style-1' ){ %> style="background:<%= event["class"]%>" <% } %> data-toggle="tooltip" title="<%= event.title %>" data-event-day-ck="<%= data_day %>"></a>
			<% }); %>
			<a href="javascript:;" data-next-carousel="1" class="event event-default-black-hidden"></a>
		</div>
	<% } %>
</div>