<template>


    <div class="row">
        <div class="col-md-12">
            <router-link to="/create-employee" class="btn" style="background:white">ADD Employee</router-link>
        </div>
        <br><br>
        <div class="col-md-12">
        <input type="text" v-model="searchItem" class="form-control" style="width:300px" placeholder="Search Here">
        </div>
        <br><br>
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Employee List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>

                        <th>Name</th>
                        <th>Image</th>
                        <th>DOB</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="employee in filterSearch" :key="employee.id">
                        <td>{{ employee.name }}</td>
                        <td><img :src="employee.photo" id="em_photo"></td>
                        <td>{{ employee.dob }}</td>
                        <td>{{ employee.phone }}</td>
                        <td>{{ employee.email }}</td>
                        <td><router-link :to="{name: 'edit-employee', params:{id:employee.id}}" class="btn btn-sm btn-primary">Edit</router-link>
                        <a href="#" @click="deleteEmployee(employee.id)" class="btn btn-danger">Delete</a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
          </div>
</template>

<script>
export default {
    created(){
        if(!User.loggedIn()){
            this.$router.push({name:'/'})
        }
    },
    data(){
       return{
           employees:[],
           searchItem:""
       }
    },
    computed:{
        filterSearch(){
            return this.employees.filter(employee=>{
                return employee.phone.match(this.searchItem)||employee.name.match(this.searchItem)||employee.email.match(this.searchItem)
            })
        }
    },
    methods:{
        allEmployee(){
            axios.get('/api/employee')
            .then(({data})=> (this.employees = data))
            .catch()
        },
        deleteEmployee(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if(result.value){
                            axios.delete('api/employee/'+id)
                            .then(()=>{
                                this.employees = this.employees.filter(employee=>{
                                    return employee.id != id
                                })
                            })
                            .catch(()=>{
                                this.$router.push({name: 'employee'})
                            })


                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        )
                    }
                })

        },

    },
    created(){
        this.allEmployee();
    }





}
</script>

<style>
    #em_photo{
        height: 50px;
        width: 50px;
    }
</style>
