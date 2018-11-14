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
                                        <p class="text-center">{{event.creatorName}} created :</p>
                                        <img class="card-img-top" height="260px;"  :src="showEventImage(event.eventImage)" alt="Card image" style="width:100%">
                                        <div class="card-body">
                                        <h4 class="card-title">{{event.eventPlace}}</h4>
                                        
                                        <p class="card-text">{{event.eventStartDate | EventDate}} {{event.eventStartDate | EventMonth}} {{event.eventStartDate | EventYear}}</p>
                                        <p>{{event.eventStartTime | EventTime}}</p>
                                        <a class="btn btn-primary" style="color:white;">Interested</a>
                                        <a class="btn btn-primary" style="color:white;">Going</a>
                                        <p>Going : 12</p>
                                        <p>Interested : 12</p>
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
