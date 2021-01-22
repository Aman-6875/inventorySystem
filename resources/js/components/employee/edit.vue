<template>
    <div>

      <div class="col-xl-12 col-lg-12 col-md-12">
          <div>
            <router-link to="/employee" class="btn" style="background:white">Employee List</router-link>
        </div>
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Update Employee</h1>
                  </div>
                  <form class="user" @submit.prevent="updateEmployee" enctype="multipart/form-data">
                    <div class="form-group">
                      <label>Name</label>
                      <input type="text" class="form-control" id="exampleInputFirstName" v-model="form.name" placeholder="Enter Name">
                        <small class="text-danger" v-if="errors.name">{{errors.name[0]}}</small>

                    </div>

                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                        v-model="form.email" placeholder="Enter Email Address">
                        <small class="text-danger" v-if="errors.email">{{errors.email[0]}}</small>

                    </div>
                    <div class="form-group">
                      <label>Phone</label>
                      <input type="phone" class="form-control" id="exampleInputPassword" v-model="form.phone" placeholder="phone">
                        <small class="text-danger" v-if="errors.phone">{{errors.phone[0]}}</small>

                    </div>

                    <div class="form-group">
                      <label>DOB</label>
                      <input type="date" class="form-control" id="exampleInputPassword" v-model="form.dob" placeholder="dob">
                        <small class="text-danger" v-if="errors.dob">{{errors.dob[0]}}</small>

                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">


                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                                <img :src="form.newphoto" alt="" style="height: 40px; width:40px;">
                        </div>
                        </div>


                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Update</button>
                    </div>
                  </form>

                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script type="text/javascript">

 export default{
    created(){
        if(!User.loggedIn()){
            this.$router.push({name:'/'})
        }

    },
    data(){
        return{
            form:{
                name:'',
                email:'',
                phone:'',
                dob:'',
                photo:'',
                newphoto:'',
            },
            errors:{}
        }
    },
    created(){
        let id = this.$route.params.id
        axios.get('/api/employee/'+id)
        .then(({data})=>(this.form = data))
        .catch(console.log('error'))
    },

    methods: {
        onFileSelected(event){
           let file = event.target.files[0];
           if(file.size>=1024000){
               Notification.imageValidation();
           }
           else{
               var reader = new FileReader();
            reader.onload =event=> {
                // The file's text will be printed here
                // console.log(e.target.result)
                this.form.newphoto = event.target.result;
                console.log(event.target.result);
            };

            reader.readAsDataURL(file);
                    }
        },

        updateEmployee(){
           // console.log(this.form);
            let id = this.$route.params.id
            axios.patch('/api/employee/'+id,this.form)
                .then(res =>{
                    console.log(res);
                     this.$router.push({name:'employee'})
                     Notification.successUpdate()

                })
                  .catch(error =>this.errors= error.response.data.errors)
                // .catch(
                //     Toast.fire({
                //     icon: 'warning',
                //     title: 'Something Went Wrong'
                //     })
                // )
        }
    },
}
</script>

<style type ="text/css">

</style>
