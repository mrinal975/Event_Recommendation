<template>
    <div class="container">

        <div class="row justify-content-center" v-if="event.eventName">
            <div class="col-md-11">
                <div class="card card-default">
                    <div class="card-header">Event</div>

                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-9">
                               <div class="row justify-content-center">
                                    <div class="card" style="width:75%">
                                        <h3 class="text-center top-style">
                                        {{event.eventName}}
                                        </h3>
                                        <router-link  v-bind:to="'/profile/'+event.createdBy">
                                        <p class="text-center event_creator">{{event.creatorName}}</p>
                                        </router-link>
                                        <img class="card-img-top" height="260px;"  :src="showEventImage(event.eventImage)" alt="Card image" style="width:100%">
                                        <div class="card-body">
                                        <h4 class="card-title">{{event.eventPlace}}</h4>
                                        
                                        <p class="card-text">{{event.eventStartDate | EventDate}} {{event.eventStartDate | EventMonth}} {{event.eventStartDate | EventYear}}</p>
                                        <p>Event will start at: {{event.eventStartTime | EventTime}}</p>
                                        <p>Type of event : {{event.eventType}}</p>
                                        <a class="btn btn-primary" style="color:white;"
                                        @click="interestcheck(event.id)">
                                            {{event.intereststatus}}
                                            </a>

                                        <a class="btn btn-primary" style="color:white;" 
                                        @click="goingCheck(event.id)">
                                            {{event.goingstatus}}
                                            </a>
                                        <p>Going : {{event.totalGoing}} </p>
                                        <p>Interested : {{event.totalInterested}}</p>
                                        <hr>
                                        <p>{{event.eventDescription}}</p>
                                        </div>
                                    </div>
                               </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!event.eventName">
            <not-found></not-found>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
      id: this.$route.params.id,
      event: {}
    };
  },
  methods: {
    goingCheck(eventid) {
      axios
        .get("http://127.0.0.1:8000/api/goingupdate/" + eventid)
        .then(({ data }) => (this.event["goingstatus"] = data));
      axios
        .get("http://127.0.0.1:8000/api/totalGoing/" + eventid)
        .then(({ data }) => (this.event["totalGoing"] = data));
    },
    interestcheck(eventid) {
      axios
        .get("http://127.0.0.1:8000/api/insterestupdate/" + eventid)
        .then(({ data }) => (this.event["intereststatus"] = data));
      axios
        .get("http://127.0.0.1:8000/api/totalInterested/" + eventid)
        .then(({ data }) => (this.event["totalInterested"] = data));
    },
    showEventImage(Image) {
      let photo = "/img/event/" + Image;
      return photo;
    }
  },
  created() {
    this.$Progress.start();
    axios
      .get("http://127.0.0.1:8000/api/event/" + this.id)
      .then(({ data }) => (this.event = data.data));
    this.$Progress.finish();
    console.log(this.$route.params);
  }
};
</script>
