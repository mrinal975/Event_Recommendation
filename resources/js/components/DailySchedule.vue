<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card card-default">
                    <div class="card-header">Hellow,YourName. Today you have below's task.</div>

                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-9">
                               <div class="row justify-content-center">
                                    <div class="card" style="width:75%">
                                        <h2 class="text-center top-style">Event  Name</h2>
                                        <p class="text-center">Event Place:</p>
                                        <img class="card-img-top" height="260px;"  src="img/12.jpg" alt="Card image" style="width:100%">
                                        
                                        <div class="card-body">
                                        <h4 class="card-title">Created By</h4>
                                        <p class="card-text">Short Description of the project</p>
                                        <a href="#" class="btn btn-primary">Event Page</a>
                                        </div>
                                    </div>
                               </div>
                            </div>
                        </div>

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
