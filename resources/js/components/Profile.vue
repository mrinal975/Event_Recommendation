<template>
    <div class="container" >
        <div class="row justify-content-center" v-if="user.name">
            <div class="col-md-11">
                <div class="card card-default">

                    <div class="card-body">
                        <div class="container emp-profile">            
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img  alt="Profile Picture" :src="showProfileImage(user.image)">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                            <br><br>
                                    <h4>
                                        {{user.name | empty}}
                                    </h4>
                                    <br>
                                    <button class="btn btn-info" v-if="$gate.userId()!=user.id" @click="followOrNotProfile()">
                                         {{followOrNot}}
                                         </button>
                                         <br><br>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <a class="btn btn-success" style="color:white;" @click="followers">
                                                followers
                                                {{user.followers}}
                                            </a>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-4">
                                        <a class="btn btn-success" style="color:white;" @click="following">
                                            following
                                            {{user.following}}
                                        </a>
                                        </div>
                                       
                                    </div>
                                    <br><br>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                            </ul>
                        </div>
                    </div> 
                </div>




  <!-- The following Modal -->
  <div class="modal fade" id="followemyModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal following Header  v-show="editmode" -->
        <div class="modal-header">
          <h4 class="modal-title"  v-show="!followmodel">Followers </h4>
          <h4 class="modal-title"  v-show="followmodel">Following</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal following body -->
        <div class="modal-body scrollable-model-body">
            <div class="row" v-for="follow in follows" :key="follow.id">
                <div class="col-sm-2">
                    <img class="rounded-circle" alt="Profile" :src="showModelImage(follow.image)" height="60px" width="70px">
                </div>
                <div class="col-sm-7 followName">
                    <a >{{follow.name}}</a>
                </div>
            </div>
            <br>
        </div>
        <!-- Modal following footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>      
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-work">
                            <br>
                           <h4>Interest list</h4>        
       <table class="table table-borderless democlass">
           
    <tbody>
      <tr v-for="interest in interests" :key="interest.id">
        <td>{{interest.Interest_on}}</td>
        <td></td>
        <td v-if="$gate.userId()==interest.user_id">
            <button @click="EditInterest(interest)" >Edit</button>
            </td>
      </tr>
    </tbody>
  </table>
                            <div v-if="$gate.userId()==user.id" class="pull-right float-right" >
                                <button type="button" class="btn btn-primary" data-toggle="modal" @click="AddInerestModel">
                                Add Inerest
                            </button>
                            </div>
                              
                        </div>
                    </div>
                    <div class="col-md-1" style="border-left:1px dotted;">
                    </div>
                    <div class="col-md-7 ">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <!-- Button trigger modal --> 
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Name</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{user.name | empty}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{user.email | empty}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>Phone</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{user.phone | empty}}</p>
                                    </div>
                                </div> 
                            </div>
                             <div  v-if="$gate.userId()==user.id" id="profile_details" class="text-right pull-right display-detail-button ">
                            <button type="button" class="btn btn-primary" data-toggle="modal" @click="openProfileModel(user)">
                            Edit
                        </button>
                        </div>
                        </div>
                    </div>

                    <!--       Modal Profile Start           -->

    <div class="modal fade" id="Profile_Model" tabindex="-1" role="dialog" aria-labelledby="Profile_Model" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="Profile_Model">Edit Informationt</h5>
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form @submit.prevent="updateinformation()">
        <div class="modal-body">
            <h5 class="text-center red">{{errors}}</h5>
            <div class="row">
                <div class="col-md-5">
                    <label for="eventImage">Picture</label>
                    <input type="File" class="form-control" id="eventImage" @change="ProfilePicture"
                     aria-describedby="emailHelp" :class="{ 'is-invalid': form.errors.has('eventImage') }">
                    <has-error :form="form" field="eventImage"></has-error>
                </div>
                <div class="col-md-7">
                    <!-- <img alt="Image test" height="130px" width="260px" src="/img/12.jpg"> -->
                     <img  alt="Profile Picture" :src="modelProfileImage()" height="150px" width="210px">
                </div>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" v-model=profile.name aria-describedby="emailHelp" 
                placeholder="Event Place" :class="{ 'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" v-model=profile.email aria-describedby="emailHelp" 
                placeholder="Event Place" :class="{ 'is-invalid': form.errors.has('email') }">
                <has-error :form="form" field="email"></has-error>
            </div>
            <div class="form-group">
                <label for="phone">Phone </label>
                <input type="phone" class="form-control" id="phone" v-model=profile.phone aria-describedby="emailHelp" 
                placeholder="Event Place" :class="{ 'is-invalid': form.errors.has('phone') }">
                <has-error :form="form" field="phone"></has-error>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
        </div>
    </div>
    </div>

             <!--            Modal Profile End                   -->




             <!--           Modal Profile Test / Interest  Start             -->

    <div class="modal fade" id="Profile_Test_Model" tabindex="-1" role="dialog" aria-labelledby="Profile_Test_Model" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="Profile_Test_Model">You Like To</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="canselupdate()">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form @submit.prevent="editmode ? updateInterst():addInterst()">
        <div class="modal-body">
           <div class="form-group">
                 <label for="Interest_on">Event Type</label>
                <select class="form-control" id="Interest_on" v-model=form.Interest_on 
                :class="{ 'is-invalid': form.errors.has('Interest_on') }">
                    <option value="music">Music</option>
                    <option value="study">Study</option>
                    <option value="movie">Movie</option>
                    <option value ="work">Work</option>
                    <option value="dancing">Dancing</option>
                </select>
                <has-error :form="form" field="Interest_on"></has-error>
            </div>
        </div>
        <div class="modal-footer">
            
            <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="canselupdate()">Close</button>
           
            <button type="submit" v-show="editmode" class="btn btn-success">Update</button>
            <button type="submit" v-show="!editmode" class="btn btn-primary">Create</button>
        </div>
        </form>
        </div>
    </div>
    </div>
        </div>           
        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!user.name">
            <not-found></not-found>
        </div>
    </div>

</template>

<script>
export default {
  data() {
    return {
      followmodel: false,
      followOrNot: "",
      editmode: false,
      errors: "",
      errorInterest: "",
      id: this.$route.params.id,
      follows: {},
      user: {},
      profilePicture: {
        picture: ""
      },
      interests: {},
      form: new Form({
        id: "",
        Interest_on: "",
        ProfilePicture: ""
      }),
      interest: {
        id: "",
        Interest_on: ""
      },
      oop: [],
      profile: {
        id: "",
        name: "",
        email: "",
        phone: "",
        image: ""
      }
    };
  },
  methods: {
    showModelImage(profileImage) {
      if (profileImage == "profile.png") {
        return "img/" + profileImage;
      } else {
        let Image = "img/profile/" + profileImage;
        return Image;
      }
    },
    followers() {
      this.followmodel = false;
      $("#followemyModal").modal("show");
      axios
        .get("http://127.0.0.1:8000/api/followers/" + this.id)
        .then(({ data }) => (this.follows = data.data));
    },
    following() {
      this.followmodel = true;
      $("#followemyModal").modal("show");
      axios
        .get("http://127.0.0.1:8000/api/following/" + this.id)
        .then(({ data }) => (this.follows = data.data));
    },
    followOrNotProfile() {
      axios
        .get("http://127.0.0.1:8000/api/follow/" + this.id)
        .then(({ data }) => (this.followOrNot = data));
    },
    followStaus() {
      axios
        .get("http://127.0.0.1:8000/api/followStaus/" + this.id)
        .then(({ data }) => (this.followOrNot = data));
    },
    showProfileImage(profileImage) {
      if (profileImage == "profile.png") {
        return "img/" + this.profile.image;
      } else {
        let Image =
          this.profile.image.length > 70
            ? this.profile.image
            : "img/profile/" + this.profile.image;
        return Image;
      }
    },
    modelProfileImage() {
      if (this.profile.image == "profile.png") {
        return "img/" + this.profile.image;
      } else {
        let Image =
          this.profile.image.length > 70
            ? this.profile.image
            : "img/profile/" + this.profile.image;
        return Image;
      }
    },
    ProfilePicture(e) {
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
        this.profile.image = reader.result;
      };
      reader.readAsDataURL(file);
    },
    canselupdate() {
      this.editmode = false;
    },
    EditInterest(data) {
      this.editmode = true;
      $("#Profile_Test_Model").modal("show");
      this.form.fill(data);
    },
    updateInterst() {
      this.form.put("api/InterestUpdate/" + this.form.id).then(({ data }) => {
        this.loadInterestOn();
        toast({
          type: "success",
          title: "Updated successfully"
        });
        $("#Profile_Test_Model").modal("hide");
      });
    },
    addInterst() {
      this.form
        .post("http://127.0.0.1:8000/api/personalInterest")
        .then(({ data }) => {
          this.loadInterestOn();
          toast({
            type: "success",
            title: "created successfully"
          });
          this.$Progress.finish();
          $("#Profile_Test_Model").modal("hide");
        });
    },
    AddInerestModel() {
      $("#Profile_Test_Model").modal("show");
      this.form.reset();
    },

    openProfileModel(profile) {
      $("#Profile_Model").modal("show");
      this.form.fill(profile);
    },
    loadInterestOn() {
      axios
        .get("http://127.0.0.1:8000/api/interest/" + this.id)
        .then(({ data }) => (this.interests = data.data));
    },
    loadUserInfo() {
      axios
        .get("http://127.0.0.1:8000/api/Profile/" + this.id)
        .then(
          ({ data }) => ((this.user = data.data), (this.profile = data.data))
        );
    },
    updateinformation() {
      axios
        .post(`http://127.0.0.1:8000/api/Profile `, {
          body: this.profile
        })
        .then(response => {
          this.$Progress.start();
          this.loadUserInfo();
          $("#Profile_Model").modal("hide");
          swal("Updated!", "Information has been updated.", "success");
          this.$Progress.finish();
        })
        .catch(e => {
          this.errors = "Name And email field is required";
        });
    }
  },
  created() {
    this.loadUserInfo();
    this.loadInterestOn();
    this.followStaus();
  }
};
</script>