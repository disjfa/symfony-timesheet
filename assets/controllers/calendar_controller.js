import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
  static targets = ['calendar'];

  connect() {
    const calendar = new FullCalendar.Calendar(this.calendarTarget, {
      initialView: 'dayGridMonth',
      events: 'api/calendar',
      slotMinTime: '08:00:00',
      headerToolbar: {
        left: 'prev,next',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,dayGridDay' // user can switch between the two
      }
    });

    calendar.render();
  }
}
