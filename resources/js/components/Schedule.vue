<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card card-default">
                    <div class="card-header">Schedule Component</div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-toggle="modal" @click="openModel()">
                        Add Task
                      </button>
                      <br><br>
                        <div class="row justify-content-center">
                            <div class="col-md-9">
                               <div class="row justify-content-center">
                                    <div class="card" style="width:75%" 
                                    v-for="(schedule,index) in schedules" :key="index" :value="schedule.value" >
                                      <div class="row">
                                        <div class="col-md-11">
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
                                        <div class="col-md-1">
                                           <div class="float-right">
                                            <a @click="editSchedulet(schedule)" style="cursor:pointer;"><i class="fas fa-edit" title="Edit Schedule"></i></a>
                                            <a @click="deleteSchedulet(schedule.id)" style="cursor:pointer;"><i class="fas fa-trash" title="Delete Schedule"></i></a>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                               </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-7">
<p v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item float-center text-center"><a class="page-link"
@click="loadScheduler(pagination.next_page_url)">Show more</a></p>
                                <!-- <li class="page-item  float-center text-center">
                                  <a class="page-link" >Show more</a></li> -->
                            </div>
                        </div>
                    </div>
    <!-- Modal Start-->
    <div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" v-show="!editmode">Add Schedule</h5>
            <h5 class="modal-title" id="exampleModalLabel" v-show="editmode">Edit Schedule</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="cancelEdit()">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form  @submit.prevent="editmode ? updateSchedule() : createSchedule()">
        <div class="modal-body">
            <!-- Form for input field start here -->
     <div class="form-row">
    <div class="col-md-12">
      <label for="schedulerName">What</label>
      <input type="text" class="form-control is-valid" id="schedulerName" placeholder="Schedule name" required
      :class="{ 'is-invalid': form.errors.has('schedulerName') }" v-model=form.schedulerName >
      <has-error :form="form" field="schedulerName" class="fontinput"></has-error>
    </div>
  </div>

  <div class="form-row">  
    <div class="col-md-5 mb-2">
      <label for="schedulerStartDate">Start Date</label>
      <input type="date" class="form-control is-valid" id="schedulerStartDate"
      required :class="{ 'is-invalid': form.errors.has('schedulerStartDate') }" v-model=form.schedulerStartDate >
      <has-error :form="form" field="schedulerStartDate" class="fontinput"></has-error>
      <!-- <div class="valid-feedback">
        Looks good!
      </div> -->
    </div>
    <div class="col-md-5 mb-2">
      <label for="schedulerStartTime">Start Time</label>
      <input type="time" class="form-control is-valid" id="schedulerStartTime" 
      required :class="{ 'is-invalid': form.errors.has('schedulerStartTime') }" v-model=form.schedulerStartTime >
      <has-error :form="form" field="schedulerStartTime" class="fontinput"></has-error>
    </div>
  </div>
    <div class="form-row">  
    <div class="col-md-5 mb-2">
      <label for="schedulerEndDate">End Date</label>
      <input type="date" class="form-control is-valid" id="schedulerEndDate"
      required :class="{ 'is-invalid': form.errors.has('schedulerEndDate') }" v-model=form.schedulerEndDate >
      <has-error :form="form" field="schedulerEndDate" class="fontinput"></has-error>
      <!-- <div class="valid-feedback">
        Looks good!
      </div> -->
    </div>
    <div class="col-md-5 mb-2">
      <label for="schedulerEndTime">End Time</label>
      <input type="time" class="form-control is-valid" id="schedulerEndTime"
      required :class="{ 'is-invalid': form.errors.has('schedulerEndTime') }" v-model=form.schedulerEndTime >
      <has-error :form="form" field="schedulerEndTime" class="fontinput"></has-error>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-12">
      <label for="schedulerDescription">Description</label>
      <textarea class="form-control is-valid" id="schedulerDescription" placeholder="Scheduler name"
      required :class="{ 'is-invalid': form.errors.has('schedulerDescription') }" v-model=form.schedulerDescription ></textarea>
    <has-error :form="form" field="schedulerDescription" class="fontinput"></has-error>
    </div>
  </div>

  <!-- Form end  -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="cancelEdit()">Close</button>
            <button type="submit" class="btn btn-primary" v-show="!editmode" >Create Schedule</button>
            <button type="submit" class="btn btn-success"  v-show="editmode" >Update</button>
        </div>
          </form>
        </div>
    </div>
    </div>
    <!-- Modal End-->
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
export default {
  data() {
    return {
      temp: {},
      editmode: false,
      schedules: {},
      pagination: {},
      form: new Form({
        id: "",
        schedulerName: "",
        schedulerStartDate: "",
        schedulerStartTime: "",
        schedulerEndDate: "",
        schedulerEndTime: "",
        schedulerDescription: "",
        createdBy: ""
      })
    };
  },
  methods: {
    cancelEdit() {
      this.editmode = false;
    },
    updateSchedule() {
      this.form
        .put("api/schedule/" + this.form.id)
        .then(() => {
          //success
          this.$Progress.start();
          this.loadScheduler();
          $("#scheduleModal").modal("hide");
          swal("Updated!", "Information has been updated.", "success");
          this.$Progress.finish();
        })
        .catch(() => {
          //error
          swal("Fail!", "updated failed", "warning");
          this.$Progress.fail();
        });
    },
    createSchedule() {
      this.$Progress.start();
      this.form.post("api/schedule").then(({ data }) => {
        this.loadScheduler();
        toast({
          type: "success",
          title: "Schedule created successfully"
        });
        this.$Progress.finish();
        $("#scheduleModal").modal("hide");
      });
    },
    openModel() {
      $("#scheduleModal").modal("show");
      this.form.reset();
    },
    editSchedulet(schedule) {
      this.editmode = true;
      $("#scheduleModal").modal("show");
      this.form.fill(schedule);
    },
    deleteSchedulet(scheduleID) {
      swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        console.log(result.value);
        if (result.value) {
          //send request for delete
          this.form
            .delete("api/schedule/" + scheduleID)
            .then(() => {
              if (result.value) {
                swal("Deleted!", "Your file has been deleted.", "success");
              }
              this.loadScheduler();
            })
            .catch(() => {
              swal("Failed!", "There was something wrong.", "warning");
            });
        }
      });
    },
    loadScheduler(page_url) {
      let vm = this;
      var peram = page_url;
      console.log("peram : " + peram);
      page_url = page_url || "api/schedule";
      axios
        .get(page_url)
        .then(
          ({ data }) => (
            (this.schedules = data.data),
            vm.makePagination(data.meta, data.links)
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
    }
  },
  created() {
    this.loadScheduler();
  }
};
</script>
