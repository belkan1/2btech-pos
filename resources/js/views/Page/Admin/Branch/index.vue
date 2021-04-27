<template>
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="page-title m-0">Branches</h4>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end page-title-box -->
            </div>
        </div> 
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-8">
                                <h4 class="mt-0 header-title">All Branches</h4>
                            </div>
                            
                            <div class="col-4">

                                <div class="float-right d-none d-md-block">
                                    <div class="dropdown">
                                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalAdd">
                                            <i class="ti-plus mr-1"></i> Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="offset-md-8 col-md-4 col-sm-12">
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                                </div>
                                    <input type="text" class="form-control" placeholder="Search branch By Name/Email"  aria-describedby="basic-addon1" v-model="search" @keyup="searchData">
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-lg" id='category-table'>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="data in branches" v-bind:key='data.id'>
                                        <td>{{ data.id }}</td>
                                        <td>{{ data.name }}</td>
                                        <td>{{ data.email }}</td>
                                        <td>{{ data.phone }}</td>
                                        <td>{{ data.address }}</td>
                                        <td>
                                            <button type="button" class='btn btn-primary' @click="branchDetail(data.id)">Detail</button>
                                            <button type="button" class='btn btn-warning' @click="branchEdit(data.id)">Edit</button>
                                            <button type="button" @click="branchDelete(data.id)" class="btn btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <nav aria-label="Page navigation example" class="float-right">
                                <ul class="pagination">
                                    <li class="page-item"><button class="page-link" href="#" v-if="this.current_page !== this.first_page" @click="prevPage">Previous</button></li>
                                    <li class="page-item"><button class="page-link" href="#">{{ this.current_page }}</button></li>
                                    <li class="page-item"><button class="page-link" href="#" @click="nextPage" v-if="this.current_page !== this.last_page">Next</button></li>
                                </ul>
                            </nav>
                    </div>
                </div>
            </div>

        </div>
        <!-- Add Modal -->
        <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Branch</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method='POST' enctype="multipart/form-data" @submit.prevent="branchAdd()">
                        <div class="modal-body">
                            <div class="alert alert-danger" v-if="errors != ''" >
                                <ul>
                                    <li v-for="error in errors" v-bind:key="error.id">{{ error[0] }}</li>
                                </ul>
                            </div>
                                <div class="form-group">
                                    <label for="">Branch name: </label>
                                    <input type="text" name="name" class="form-control" v-model="add.name">
                                </div>
                               
                                <div class="form-group">
                                    <label for="">Email: </label>
                                    <input type="email" name="name" class="form-control" v-model="add.email">
                                </div>
                                
                                <div class="form-group">
                                    <label for="">Phone: </label>
                                    <input type='text' name="description" class="form-control" v-model="add.phone">
                                </div>
                                <div class="form-group">
                                    <label for="">Address: </label>
                                    <textarea name="description" class="form-control" v-model="add.address"></textarea>
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
        <!-- Edit Modal -->
        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Branch</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" method='POST' enctype="multipart/form-data" @submit.prevent="branchUpdate(edit.id)">
                        
                        <div class="modal-body">
                                <div class="alert alert-danger" v-if="errors != ''" >
                                    <ul>
                                        <li v-for="error in errors" v-bind:key="error.id">{{ error[0] }}</li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label for="">Branch Name: </label>
                                    <input type="text" name="name" class="form-control" v-model="edit.name">
                                </div>
                                <div class="form-group">
                                    <label for="">Email: </label>
                                    <input type="email" name="name" class="form-control" v-model="edit.email">
                                </div>
                                <div class="form-group">
                                    <label for="">Phone: </label>
                                    <input type="text" name="name" class="form-control" v-model="edit.phone">
                                </div>

                                <div class="form-group">
                                    <label for="">Address: </label>
                                    <input type="text" name="name" class="form-control" v-model="edit.address">
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
        <!-- Detail Modal -->
        <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Branch Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                        
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="example-search-input" class="col-sm-4 col-form-label">Branch Name: </label>
                            <div class="col-sm-8">
                                <input class="form-control-plaintext" type="search" id="example-search-input" v-model="detail.name" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-sm-4 col-form-label">Email: </label>
                            <div class="col-sm-8">
                                <input class="form-control-plaintext" type="search" id="example-search-input" v-model="detail.email" readonly>
                            </div>
                        </div>
                
                        <div class="form-group row">
                            <label for="example-search-input" class="col-sm-4 col-form-label">Phone No: </label>
                            <div class="col-sm-8">
                                <input class="form-control-plaintext" type="search" id="example-search-input" v-model="detail.phone" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-search-input" class="col-sm-4 col-form-label">Address: </label>
                            <div class="col-sm-8">
                                <textarea name="" id="" cols="30" rows="4" class="form-control-plaintext" v-model="detail.address"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
                    </div>
                </div>
            </div>
        </div>

        <!-- end row -->            

    </div><!-- container fluid -->

</template>
<script>
import Swal from 'sweetalert2'
export default {
    mounted() {
        this.displayData(this.page, this.search);
    },

    data() {
        return {
            edit: {
                id: '',
                name: '',
                email: '',
                phone: '',
                address: '',
            },
            add: {
                id: '',
                name: '',
                email: '',
                phone: '',
                address: '',
                
            },
            errors: '',
            detail: {},
            search: '',
            name: '',
            description: '',
            search: '',
            branches: [],
            photo: '',
            
            page: 1,
            first_page: 1,
            last_page: null,
            current_page: this.$route.query.page || 1,
            next_page_url: '',
            prev_page_url: '',
        }
    },

    methods: {  
        displayData(page = 1, search= '') {
            axios.get('/api/v1/branch', { params: { search: this.search, page: this.page } })
                .then(result => {
                    this.branches = result.data.data;
                    this.last_page = result.data.meta.last_page;
                    this.current_page = result.data.meta.current_page;
                    this.next_page_url = result.data.links.next;
                    this.prev_page_url = result.data.links.prev;
                });
        },

        branchDetail(id) {
            axios.get(`/api/v1/branch/${id}`)
                .then(res => {
                    this.detail = res.data;
                    console.log(res.data);
                    $('#modalDetail').modal('show');
                });
        },
        branchDelete(id) {
            let that = this;
            alertify.confirm("Are you sure?", function (ev) {
                ev.preventDefault();
                axios.delete(`/api/v1/branch/${id}`)
                    .then(res => {
                        console.log(res);
                        that.displayData();
                        alertify.success("Successfull Deletion");
                    });
            }, function(ev) {
                ev.preventDefault();
                alertify.error("Cancel Deletion");
            });
        },
        branchEdit(id) {
            axios.get(`/api/v1/branch/${id}/edit`)
                .then(res => {
                    this.edit.id = res.data.id;
                    this.edit.name = res.data.name;
                    this.edit.phone = res.data.phone;
                    this.edit.email = res.data.email;
                    this.edit.phone = res.data.phone;
                    this.edit.address = res.data.address;
                })
                
            $('#modalEdit').modal('toggle');
        },

        branchUpdate(id) {
            let formData = new FormData();
            
            formData.append('name', this.edit.name);
            formData.append('email', this.edit.email);
            formData.append('phone', this.edit.phone);
            formData.append('address', this.edit.address);

            axios.post(`/api/v1/branch/${this.edit.id}`, formData,{ headers: { 'Content-Type': 'multipart/form-data' }  })
                .then(res => {
                    $('#modalEdit').modal('toggle');
                    this.displayData();
                        Swal.fire(
                        `Success!`,
                        `User Updated Successfully ${this.add.level}!`,
                        'success'
                        )

                }).catch(error => {
                    let statusCode = error.response.status;
                    if(statusCode == 500) {
                        this.errors = {"error": "Terjadi kesalahan sistem."};
                    }else if(statusCode == 400) {
                        console.log(error.response.data)
                        this.errors = error.response.data;
                    }
                });
        },
        branchAdd() {
            let formData = new FormData();
            
            formData.append('name', this.add.name);
            formData.append('email', this.add.email);
            formData.append('phone', this.add.phone);
            formData.append('address', this.add.address);

            axios.post('/api/v1/branch', formData, { headers: { 'Content-Type': 'multipart/form-data' } })
                .then(res => {
                    console.log(res);
                    $('#modalAdd').modal('toggle');
                    this.displayData();
                    setTimeout(() => {
                        Swal.fire(
                        `Success!`,
                        `Branch Added Successfully ${this.add.name}!`,
                        'success'
                        )
                    }, 200);

                }).catch(error => {
                    let statusCode = error.response.status;
                    if(statusCode == 500) {
                        this.errors = {"error": "System Error"};
                    }else if(statusCode == 400) {
                        console.log(error.response.data)
                        this.errors = error.response.data;
                    }
                });
        },

        // onChangePhotoAdd() {
        //     this.add.photo = event.target.files[0];
        //     $('#add-category-image').attr('src', URL.createObjectURL(event.target.files[0]));
        // },

        // onChangePhotoEdit() {
        //     this.edit.photo = event.target.files[0];
        //     $('#edit-category-image').attr('src', URL.createObjectURL(event.target.files[0]));
            
        // },

        nextPage() {
            let nextPage = this.current_page+1;
            window.history.replaceState(null, null, "?page="+nextPage);
            this.displayData(this.current_page+1, this.search);
        },

        prevPage() {
            let prevPage = this.current_page-1;
            window.history.replaceState(null, null, "?page="+prevPage);
            this.displayData(prevPage, this.search);
        },

        searchData() {
            this.displayData(1, this.search);
            window.history.replaceState(null, null, "?page=1");
        }
        
    }
}
</script>
<style>
    .image-table {
        width: 80px;
    }
    .image-table-users {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        margin-right: 10px;
        object-fit: cover;   
    }
</style>
