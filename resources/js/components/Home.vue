<template>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
          <div class="form-group">
          <input type="text" class="form-control" id="usr" v-model="searchQuery" v-on:keyup="search"  name="username" placeholder="Search events" >
        </div>
        </div>
        <div class="col-sm-3"></div>
        <div>
        </div>
      </div>
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card card-default"> 
                    <div class="card-body">
                <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" 
                        @click="openModel">
                        Create Event
                        </button>
                        <br>
                        <br>
                        <div class="row justify-content-center">

				    <ul class="event-list">
					<li v-for="(event,index) in events" :key="index" :value="event.value">
						<time>
							<span class="day">{{event.eventStartDate | EventDate}}</span>
							<span class="month">{{event.eventStartDate | EventMonth}}</span>
							<span class="year">{{event.eventStartDate | EventYear}}</span>
							<span class="time">{{event.eventStartTime| EventTime}}</span>
						</time>
						<img alt="Event Image" :src="showEventImage(event.eventImage)" />
						<div class="info">
              <router-link  v-bind:to="'event/'+event.id">
							<h2 class="title">{{event.eventName}}</h2>
              </router-link>
                           
							<p class="desc">Bar Hopping in Erie, Pa.Bar Hopping in Erie, Pa</p>
               
							<ul>
								<li style="width:25%;">
                  <a class="glyphicon glyphicon-ok" @click="goingOrNot(index,event.id)">
                 {{event.goingstatus}}
                  </a></li>
								<li style="width:27%;">

                  <a class="glyphicon glyphicon-ok" @click="InterestedOrNot(index,event.id)">
                  {{event.intereststatus}}
                  </a>
                 </li>
								<li style="width:21%;">{{event.totalGoing}} Going</li>
                <li style="width:27%;">{{event.totalInterested}} Interested</li>
							</ul>
						</div>
						<div class="social">
							<ul>
								<li v-if="$gate.userId()==event.createdBy" class="facebook" style="width:33%;"><a @click="editEvent(event)"><i class="fas fa-edit" title="Edit Event"></i></a></li>
								<li v-if="$gate.userId()==event.createdBy" class="twitter" style="width:34%;"><a @click="deleteEvent(event.id)"><i class="fas fa-trash" title="Delete Event"></i></a></li>
							</ul>
						</div>
					</li>
				</ul>


			</div>
                    </div>
                </div>
                <div>            
<!-- Modal Start-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" v-show="!editmode">Create Event</h5>
            <h5 class="modal-title" id="exampleModalLabel" v-show="editmode">Update Event</h5>
            <button type="button" class="close" @click="cancelEdit()" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form @submit.prevent="editmode ? updateEvent():createEvent()">
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-md-5">
                    <label for="eventImage">Picture</label>
                    <input type="File" class="form-control" id="eventImage" @change="eventPicture"
                     aria-describedby="emailHelp" :class="{ 'is-invalid': form.errors.has('eventImage') }">
                    <has-error :form="form" field="eventImage"></has-error>
                </div>
                <div class="col-md-7">
                    <img alt="Image test" height="130px" width="260px" :src="modelProfileImage()">
                </div>
            </div>
            <div class="form-group">
                <label for="eventType">Event Type</label>
                <select class="form-control" id="eventType" v-model=form.eventType 
                :class="{ 'is-invalid': form.errors.has('eventType') }">
                    <option value="music">Music</option>
                    <option value="study">Study</option>
                    <option value="movie">Movie</option>
                    <option value ="work">Work</option>
                    <option value="dancing">Dancing</option>
                </select>
                <has-error :form="form" field="eventTypes"></has-error>
            </div>
            <div class="form-group">
                <label for="eventName">Event Name</label>
                <input type="text" class="form-control" id="eventName" v-model=form.eventName aria-describedby="emailHelp" 
                placeholder="Event Name" :class="{ 'is-invalid': form.errors.has('eventName') }">
                <has-error :form="form" field="eventName"></has-error>
            </div>
            <div class="form-group">
                <label for="eventPlace">Event Place</label>
                <input type="text" class="form-control" id="eventPlace" v-model=form.eventPlace aria-describedby="emailHelp" 
                placeholder="Event Place" :class="{ 'is-invalid': form.errors.has('eventPlace') }">
                <has-error :form="form" field="eventPlace"></has-error>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="eventStartDate">Start Date</label>
                    <input class="form-control" id="eventStartDate" type="date" v-model=form.eventStartDate 
                    :class="{ 'is-invalid': form.errors.has('eventStartDate') }">
                    <has-error :form="form" field="eventStartDate"></has-error>
                </div>
                <div class="col-md-6">
                    <label for="eventStartTime">Start Time</label>
                    <input class="form-control" id="eventStartTime" type="time" v-model=form.eventStartTime 
                    :class="{ 'is-invalid': form.errors.has('eventStartTime') }">
                    <has-error :form="form" field="eventStartTime"></has-error>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="eventEndDate">End Date</label>
                    <input class="form-control" id="eventEndDate" type="date" v-model=form.eventEndDate 
                    :class="{ 'is-invalid': form.errors.has('eventEndDate') }">
                    <has-error :form="form" field="eventEndDate"></has-error>
                </div>
                <div class="col-md-6">
                    <label for="eventEndTime">End Time</label>
                    <input class="form-control" id="eventEndTime" type="time" v-model=form.eventEndTime
                    :class="{ 'is-invalid': form.errors.has('eventEndTime') }">
                    <has-error :form="form" field="eventEndTime"></has-error>
                </div>
            </div>

            <div class="form-group">
                <label for="eventDescription">Event Description</label>
                <textarea class="form-control" id="eventDescription" rows="3" v-model=form.eventDescription
                :class="{ 'is-invalid': form.errors.has('eventDescription') }"></textarea>
                <has-error :form="form" field="eventDescription"></has-error>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" @click="cancelEdit()" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" v-show="editmode" class="btn btn-success">Update</button>
            <button type="submit" v-show="!editmode" class="btn btn-primary">Create</button>
        </div>
        </form>
        </div>
    </div>
    </div>
    <!-- Modal End -->             
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
  data() {
    return {
      searchQuery: "",
      InterestStatust: "Interested",
      goStatus: "Going",
      editmode: false,
      events: {},
      form: new Form({
        id: "",
        eventImage: "event.jpg",
        eventType: "",
        eventName: "",
        eventPlace: "",
        eventStartDate: "",
        eventStartTime: "",
        eventEndDate: "",
        eventEndTime: "",
        eventDescription: "",
        createdBy: "",
        tempdata: ""
      })
    };
  },
  methods: {
    search() {
      if (this.searchQuery.length > 0) {
        console.log("hi" + this.searchQuery);
        axios
          .get("http://127.0.0.1:8000/api/search/" + this.searchQuery)
          .then(({ data }) => (this.events = data.data));
      }
    },
    goingOrNot(index, eventid) {
      axios
        .get("http://127.0.0.1:8000/api/goingupdate/" + eventid)
        .then(({ data }) => (this.events[index]["goingstatus"] = data));
      axios
        .get("http://127.0.0.1:8000/api/totalGoing/")
        .then(({ data }) => (this.events[index]["totalGoing"] = data));
    },
    InterestedOrNot(index, eventid) {
      axios
        .get("http://127.0.0.1:8000/api/insterestupdate/" + eventid)
        .then(({ data }) => (this.events[index]["intereststatus"] = data));
      axios
        .get("http://127.0.0.1:8000/api/totalInterested/")
        .then(({ data }) => (this.events[index]["totalInterested"] = data));
    },
    showEventImage(eventImage) {
      let photo = "img/event/" + eventImage;
      return photo;
    },
    modelProfileImage() {
      let Image =
        this.form.eventImage.length > 70
          ? this.form.eventImage
          : "img/event/" + this.form.eventImage;
      return Image;
    },
    eventPicture(e) {
      let file = e.target.files[0];
      let reader = new FileReader();
      let limit = 1024 * 1024 * 2;
      var image = file["type"].split("/");
      if (image[0] != "image") {
        swal({
          type: "error",
          title: "Oops...",
          text: "Only Image can be upload",
          footer: "<a href>Erroe ! </a>"
        });
      } else if (file["size"] > limit) {
        swal({
          type: "error",
          title: "Oops...",
          text: "You are uploading a large file"
        });
        return false;
      }

      reader.onloadend = file => {
        this.form.eventImage = reader.result;
      };
      reader.readAsDataURL(file);
    },
    updateEvent() {
      this.form
        .put("api/event/" + this.form.id)
        .then(() => {
          //success
          this.$Progress.start();
          this.loadEvents();
          $("#exampleModal").modal("hide");
          swal("Updated!", "Information has been updated.", "success");
          this.$Progress.finish();
        })
        .catch(() => {
          //error
          swal("Fail!", "updated failed", "warning");
          this.$Progress.fail();
        });
    },
    cancelEdit() {
      this.editmode = false;
    },
    openModel() {
      $("#exampleModal").modal("show");
      this.form.reset();
    },
    editEvent(event) {
      this.editmode = true;
      $("#exampleModal").modal("show");
      this.form.fill(event);
    },
    loadEvents() {
      axios.get("api/event").then(({ data }) => (this.events = data.data));
    },
    deleteEvent(id) {
      swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        //send request for delete
        if (result.value) {
          this.form
            .delete("api/event/" + id)
            .then(() => {
              if (result.value) {
                swal("Deleted!", "Your file has been deleted.", "success");
              }
              this.loadEvents();
            })
            .catch(() => {
              swal("Failed!", "There was something wrong.", "warning");
            });
        }
      });
    },

    createEvent() {
      this.$Progress.start();
      this.form.post("api/event").then(({ data }) => {
        this.loadEvents();
        toast({
          type: "success",
          title: "Event created successfully"
        });
        this.$Progress.finish();
        $("#exampleModal").modal("hide");
      });
    }
  },
  created() {
    this.$Progress.start();
    this.loadEvents();
    this.$Progress.finish();
  }
};
</script>
