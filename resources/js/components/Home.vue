<template>
    <div class="container classbg">
      <div class="row justify-content-center">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
      <div class="input-group mb-3">
      <input type="text" class="form-control" placeholder="Search events"  v-model="searchQuery.searchText">
      <div class="input-group-append">
        <span class="input-group-text">From</span>
        <input type="date" v-model="searchQuery.startDate">
        <span class="input-group-text">To</span>
        <input type="date" v-model="searchQuery.endDate">
      </div>
      <button type="submit" class="btn btn-primary" @click="search()">Search</button>
    </div>
        </div>
        <div class="col-sm-1"></div>
        <div>
        </div>
      </div>
        <div class="row">
<!-- left side bar user list Start-->
          <div class="col-md-2">
            <!-- <br><br> -->
            <div class="row" style="position:fixed;">
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center">User List</h5>
                  <div class="list-group">
                  <!-- <a href="#" class="list-group-item list-group-item-action active">
                    Cras justo odio
                  </a> -->
                  <div v-for="(userList,index) in userLists" :key="index" :value="userList.value">
                    <router-link  v-bind:to="'/profile/'+userList.id" class="list-group-item list-group-item-action">
                  {{userList.name}}
                  </router-link>
                  </div>
                </div>
      <ul class="pagination">
   
        <!-- loadUserList pagination -->
        <li  v-bind:class="[{disabled: !userPagination.prev_page_url}]" class="page-item">
          <a class="page-link"  @click="loadUserList(userPagination.prev_page_url)">
          <i class="fas fa-arrow-left"></i>
          </a>
        </li>
        <!-- loadUserList pagination End-->
        <li class="page-item disabled">
          <a class="page-link text-dark">{{ userPagination.current_page }} of {{ userPagination.last_page }}
          </a>
        </li>
        <!--  loadUserList pagination   -->
        <li  v-bind:class="[{disabled: !userPagination.next_page_url}]" class="page-item">
          <a class="page-link" @click="loadUserList(userPagination.next_page_url)">
           <i class="fas fa-arrow-right"></i> 
          </a>
        </li>
        
  </ul>
                </div>
              </div>
            </div>
            </div>
<!-- left side bar user list End-->

<!-- Main bar Event list Start-->
            <div class="col-md-8">
              <!-- Card start -->
                <div class="card"> 
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
							<span class="time">{{event.eventStartTime | EventTime}}</span>
						</time>
						<img alt="Event Image" :src="showEventImage(event.eventImage)" />
						<div class="info">
              <router-link  v-bind:to="'event/'+event.id">
							<h4 class="title">{{event.eventName |upText}}</h4>
              </router-link>
              <p class="desc ">Type : {{event.eventType | upText}}</p>             
							<p class="desc">{{event.eventDescription | upText | Des}}</p>
               
							<ul>
								<li style="width:23%;">
                  <a class="glyphicon glyphicon-ok" @click="goingOrNot(index,event.id)">
                 <br>
                 {{event.goingstatus}}
                  </a></li>
								<li style="width:27%;">

                  <a class="glyphicon glyphicon-ok" @click="InterestedOrNot(index,event.id)">
                  <br>
                  {{event.intereststatus}}
                  </a>
                 </li>
								<li style="width:18%;">{{event.totalGoing}} <br> Going</li>
                <li style="width:20%;">{{event.totalInterested}} <br> Interested</li>
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

 <nav aria-label="Page navigation example">
  <ul class="pagination float-right">
    <!-- Event type wise Data Links Previous  -->
        <li v-show="eventTypeModel" v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
          <a class="page-link"  @click="eventTypeData(showEventType,pagination.prev_page_url)">
            Previous 
          </a>
        </li>
        <!-- Search mode -->
        <li v-show="searchmode" v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
          <a class="page-link"  @click="search(pagination.prev_page_url)">
            Previous 
          </a>
        </li>
        <!-- Search mode End  -->
        <!-- Default Mode    -->
        <li v-show="!searchmode && !eventTypeModel" v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
          <a class="page-link"  @click="loadEvents(pagination.prev_page_url)">
            Previous
          </a>
        </li>
        <!--  Default Mode End   -->
        <li class="page-item disabled">
          <a class="page-link text-dark">Page {{ pagination.current_page }} of {{ pagination.last_page }}
          </a>
        </li>
        <!-- Default Main Next -->
        <li v-show="!searchmode && !eventTypeModel" v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
          <a class="page-link" @click="loadEvents(pagination.next_page_url)">
            Next 
          </a>
        </li>
        <!--  Search mode   -->
        <li v-show="searchmode" v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
          <a class="page-link" @click="search(pagination.next_page_url)">
             Next
          </a>
        </li>
         <!--  Event type wise Data Links Next    -->
        <li v-show="eventTypeModel" v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
          <a class="page-link" @click="eventTypeData(showEventType,pagination.next_page_url)">
            Next
          </a>
        </li>
        <!-- Search mode End -->
  </ul>
</nav>
              <!-- Card End -->

          </div>
          <!-- Main bar Event list End -->
          <div class="col-md-2">
            <div class="row" style="position:fixed;">
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center">
                    Event Type
                  </h5>
                  <ul class="list-group">
                    <a class="list-group-item" style="cursor:pointer" @click="eventTypeData('music')">Music</a>
                    <a class="list-group-item" style="cursor:pointer" @click="eventTypeData('movie')">Movie</a>
                    <a class="list-group-item" style="cursor:pointer" @click="eventTypeData('work')">Work</a>
                    <a class="list-group-item" style="cursor:pointer" @click="eventTypeData('dancing')">Dancing</a>
                    <a class="list-group-item" style="cursor:pointer" @click="eventTypeData('movie')">Movie</a>
                    <a class="list-group-item" style="cursor:pointer" @click="eventTypeData('study')">Study</a>
                  </ul>  
                </div>
              </div>
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
                :class="{ 'is-invalid': form.errors.has('eventDescription') }">sd asd sa </textarea>
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
    
</template>
<script>
export default {
  data() {
    return {
      searchQuery: {
        searchText: "",
        startDate: "",
        endDate: ""
      },
      showEventType: "",
      eventTypeModel: false,
      userLists: {},
      searchmode: false,
      userPagination: {},
      pagination: {},
      InterestStatust: "Interested",
      goStatus: "Going",
      peramData: "",
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
    eventTypeData(peramData, page_url) {
      if (this.showEventType.length < 2) {
        this.showEventType = peramData;
      }
      if (peramData == null || peramData.length < 2) {
      }
      this.eventTypeModel = true;
      this.searchmode = false;
      let vm = this;
      var peram = page_url;
      page_url = page_url || "api/eventWithType/" + peramData;
      axios
        .get(page_url)
        .then(
          ({ data }) => (
            (this.events = data.data), vm.makePagination(data.meta, data.links)
          )
        );
    },
    loadUserList(page_url) {
      let vm = this;
      var peram = page_url;
      page_url = page_url || "api/loadUserList";
      axios
        .get(page_url)
        .then(
          ({ data }) => (
            (this.userLists = data.data),
            vm.makeUserPagination(data.meta, data.links)
          )
        );
    },
    makeUserPagination(meta, links) {
      let userPagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };
      this.userPagination = userPagination;
    },
    loadEvents(page_url) {
      let vm = this;
      var peram = page_url;
      page_url = page_url || "api/event";
      axios
        .get(page_url)
        .then(
          ({ data }) => (
            (this.events = data.data), vm.makePagination(data.meta, data.links)
          )
        );
    },
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };
      this.pagination = pagination;
    },
    search(page_url) {
      this.searchmode = true;
      let vm = this;
      var peram = page_url;
      console.log("page_url :" + page_url);
      page_url = page_url || "http://127.0.0.1:8000/api/search";
      if (
        this.searchQuery.searchText.length > 0 ||
        this.searchQuery.startDate.length > 0 ||
        this.searchQuery.endDate.length > 0
      ) {
        axios
          .post(page_url, {
            body: this.searchQuery
          })
          .then(response => {
            this.events = response.data.data;
            // this.searchQuery.searchText = "";
            this.pagination = [];
            vm.makePagination(response.data.meta, response.data.links);
          })
          .catch(e => {});
      }
    },
    goingOrNot(index, eventid) {
      axios
        .get("http://127.0.0.1:8000/api/goingupdate/" + eventid)
        .then(({ data }) => (this.events[index]["goingstatus"] = data));
      axios
        .get("http://127.0.0.1:8000/api/totalGoing/" + eventid)
        .then(({ data }) => (this.events[index]["totalGoing"] = data));
    },
    InterestedOrNot(index, eventid) {
      axios
        .get("http://127.0.0.1:8000/api/insterestupdate/" + eventid)
        .then(({ data }) => (this.events[index]["intereststatus"] = data));
      axios
        .get("http://127.0.0.1:8000/api/totalInterested/" + eventid)
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
    this.loadUserList();
    this.$Progress.finish();
  }
};
</script>
