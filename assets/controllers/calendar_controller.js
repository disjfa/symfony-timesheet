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
  static values = {
    api: String,
  }

  calendar;

  connect() {

    console.log(this);

    this.calendar = new FullCalendar.Calendar(this.calendarTarget, {
      initialView: 'timeGridWeek',
      events: this.apiValue,
      hiddenDays: [0, 6], // 0 = Sunday, 6 = Saturday
      slotMinTime: '08:00:00',
      slotMaxTime: '18:00:00',
      firstDay: 1,
      headerToolbar: {
        left: 'prev,today,next',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,dayGridDay' // user can switch between the two
      }
    });
    this.calendar.render();
  }

  disconnect() {
    if (this.calendar) {
      this.calendar.destroy();
    }
  }
}
