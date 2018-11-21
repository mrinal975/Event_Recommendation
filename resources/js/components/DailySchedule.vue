<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card card-default">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-9" v-for="(event,index) in events" :key="index" :value="event.value">
                               <div class="row justify-content-center">
                                    <div class="card" style="width:75%">
                                        <router-link  v-bind:to="'event/'+event.id">
                                        <h3 class="text-center top-style">{{event.eventName}}</h3>
                                        </router-link>
                                        <p class="text-center">{{event.eventPlace}}</p>
                                        <img class="card-img-top" height="220px;"  :src="showEventImage(event.eventImage)" alt="Card image" style="width:100%">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <router-link  v-bind:to="'profile/'+event.createdBy">
                                                    <h4 class="card-title">{{event.createdByName}}</h4>
                                                    </router-link>
                                                    <p> 
                                                        <span class="time">{{event.eventStartTime| EventTime}}</span>
                                                        <span class="day">{{event.eventStartDate | EventDate}}</span>
                                                        <span class="month">{{event.eventStartDate | EventMonth}}</span>
                                                        <span class="year">{{event.eventStartDate | EventYear}}</span>
                                                    </p>
                                                    <p class="card-text">Short Description of the project</p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="float-right">
                                                        <p> Going : {{event.totalGoing}}</p>
                                                        <p>Interested : {{event.totalInterested}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-md-9">
                               <div class="row justify-content-center" 
                               v-for="(schedule,index) in schedules" :key="index" :value="schedule.value">
                                    <div class="card" style="width:75%">
                                        <h2 class="text-center top-style">{{schedule.schedulerName}}</h2>
                                        <p class="text-center">
                                            <span class="time">{{schedule.schedulerStartTime| EventTime}}</span>
                                          </p>
                                          <p class="text-center">
                                            <span class="day">{{schedule.schedulerStartDate | EventDate}}</span>
                                            <span class="month">{{schedule.schedulerStartDate | EventMonth}}</span>
                                            <span class="year">{{schedule.schedulerStartDate | EventYear}}</span>
                                            
                                          </p>
                                        <p class="text-center">Short Description of the Task</p>
                                    </div>
                               </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      schedules: {},
      events: {}
    };
  },
  methods: {
    showEventImage(eventImage) {
      let photo = "img/event/" + eventImage;
      return photo;
    },
    loadDailySchedule() {
      axios
        .get("api/dailySchedule")
        .then(({ data }) => (this.schedules = data.data));
    },
    loadDailyEvent() {
      axios.get("api/dailyEvent").then(({ data }) => (this.events = data.data));
    }
  },
  created() {
    this.loadDailySchedule();
    this.loadDailyEvent();
  }
};
</script>
