<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card card-default">
                    <div class="card-header">Schedule Component</div>

                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Add Task
                        </button>
                        <div class="row justify-content-center">
                            <div class="col-md-9">
                               <div class="row justify-content-center">
                                    <div class="card" style="width:75%">
                                        <h2 class="text-center top-style">Task  Name</h2>
                                        <p class="text-center">Time</p>
                                        <p class="text-center">Short Description of the Task</p>
                                        
                                    </div>
                               </div>
                            </div>
                        </div>
                    </div>
    <!-- Modal Start-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <!-- Form for input field start here -->
<form>
     <div class="form-row">
    <div class="col-md-12">
      <label for="validationServer01">What</label>
      <input type="text" class="form-control is-valid" id="validationServer01" placeholder="Task name" required>
    </div>
  </div>

  <div class="form-row">  
    <div class="col-md-5 mb-2">
      <label for="Date">Date</label>
      <input type="date" class="form-control is-valid" id="Date" required>
      <!-- <div class="valid-feedback">
        Looks good!
      </div> -->
    </div>
    <div class="col-md-5 mb-2">
      <label for="Time">Time</label>
      <input type="time" class="form-control is-valid" id="Time" required>
    
    </div>
  </div>
    <div class="form-row">
    <div class="col-md-12">
      <label for="validationServer01">Where</label>
      <input type="text" class="form-control is-valid" id="validationServer01" placeholder="Where name" required>
    </div>
  </div>
      <div class="form-row">
    <div class="col-md-12">
      <label for="validationServer01">Repeat</label>
      <input type="text" class="form-control is-valid" id="validationServer01" placeholder="Where name"  required>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-12">
      <label for="validationServer01">Description</label>
      <textarea class="form-control is-valid" id="validationServer01" placeholder="Description name"  required></textarea>
    </div>
  </div>
  </form>
  <!-- Form end  -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
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
  mounted() {
    console.log("Component mounted.");
  }
};
</script>
