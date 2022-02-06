<script>
        
    const app = new Vue({
        el: '#dev-vehicles',
        data(){
            return{
                modalTitle:"New vehicle",
                id:"",
                name:"",
                vehicleId:"",
                action:"create",
                services:[],
                vehicles:[],
                service_id:"",
                name:"",
                maxPassengers:"",
                pictureStatus:"",
                imageProgress:"",
                imagePreview:"",
                file:"",
                finalPictureName:"",
                is_private:"",
                is_shared:"",
                picture:"",
                errors:[],
                pages:0,
                page:1,
                showMenu:false,
                loading:false,
            }
        },
        methods:{

            onImageChange(e){
                this.picture = e.target.files[0];

                this.imagePreview = URL.createObjectURL(this.picture);
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.view_image = false
                this.createImage(files[0]);
            },

            createImage(file) {

                this.file = file

                this.mainImageFileType = file['type'].split('/')[0]

                if(this.mainImageFileType == "image"){
                    
                    let reader = new FileReader();

                    let vm = this;

                    reader.onload = (e) => {

                        vm.picture = e.target.result;

                    };

                    reader.readAsDataURL(file);
                    
                }else{

                    swal({
                        text:"Formato no permitido",
                        "icon": "error"
                    })

                }

                
            },
            
            create(){
                this.id=""
                this.name=""
                this.vehicleId=""
                this.action="create"
                this.services=[]
                this.service_id=""
                this.vehicles=[]
                this.name=""
                this.maxPassengers=""
                this.pictureStatus=""
                this.imageProgress=""
                this.imagePreview=""
                this.file=""
                this.finalPictureName=""
                this.is_private=""
                this.is_shared=""
                this.picture=""
                this.errors=[]
                this.pages=0
                this.page=1
                this.showMenu=false
                this.loading=false
            },
            
            uploadMainImage(){

                if(this.picture){
                    
                    this.loading = true
                    this.imageProgress = 0;
                    let formData = new FormData()
                    formData.append("file", this.file)
                    formData.append("upload_preset", this.cloudinaryPreset)

                    var _this = this
                    var fileName = this.fileName
                    this.pictureStatus = "subiendo";

                    var config = {
                        headers: { "X-Requested-With": "XMLHttpRequest", "Authorization": "Bearer "+window.localStorage.getItem("SIMCOE_AUTH_TOKEN")},
                        onUploadProgress: function(progressEvent) {
                            
                            var progressPercent = Math.round((progressEvent.loaded * 100.0) / progressEvent.total);
                        
                            _this.imageProgress = progressPercent
                            
                        }
                    }

                    axios.post(
                        "{{ url('/api/admin/upload-file') }}",
                        formData,
                        config                        
                    ).then(res => {

                        this.pictureStatus = "listo";
                        this.finalPictureName = res.data.file_route
                        this.loading = false

                        this.store()

                    }).catch(err => {

                        this.loading = false
                        swal({
                            "text":err.response.data.message,
                            "icon": "error"
                        })

                    })

                }else{

                    swal({
                        text:"No hay imagen para subir",
                        "icon": "error"
                    })


                }

            },
            async store(){

                const response = await axios.post("{{ route('admin.vehicle') }}",
                    {
                        service_id:this.service_id,
                        name:this.name,
                        max_passenger:this.maxPassengers,
                        is_private:JSON.parse(this.is_private),
                        is_shared:JSON.parse(this.is_shared),
                        picture:this.finalPictureName,
                    },
                    {
                        headers:{
                            "Authorization": "Bearer "+window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                        }
                    }
                )

                if(response.data.success == true){
                    await swal({
                        "text": response.data.message,
                        "icon":"success"
                    })

                    window.location.href="{{ route('vehicles.index') }}"
                }

                else{
                    swal({
                        "text": response.data.message,
                        "icon":"error"
                    })
                }

            },
            update(){

                this.loading = true
                axios.put("{{ url('api/admin/vehicle') }}"+"/"+this.vehicleId, {service_id: this.service_id,name: this.name}, {
                    headers:{
                        "Authorization": "Bearer "+window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                    }
                })
                .then(res => {
                    this.loading = false
                    if(res.data.success == true){

                        swal({
                            text: res.data.message,
                            icon: "success"
                        });
                        this.name = ""
                        this.vehicleId = ""
 
                        $('#vehiclesModal').modal('hide')
                        $('.modal-backdrop').remove()
                        this.fetch()
                        
                    }else{

                        swal({
                            text: res.data.message,
                            icon: "error"
                        });

                    }

                })
                .catch(err => {
                    this.loading = false
                    this.errors = err.response.data.errors
                })

            },
            edit(vehicle){
                this.modalTitle = "Edit vehicle"
                this.action = "edit"
                this.id = vehicle.id
                this.service_id= vehicle.service_id
                this.name = vehicle.name
                this.vehicleId = vehicle.id

            },
            fetch(){

                axios.get("{{ url('/api/admin/vehicle') }}", {
                    headers:{
                        "Authorization": "Bearer "+window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                    }
                })
                .then(res => {

                    this.vehicles = res.data.vehicle

                })

            },
            fetchservices(){

                axios.get("{{ url('/api/admin/service') }}", {
                    headers:{
                        "Authorization": "Bearer "+window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                    }
                })
                .then(res => {

                    this.services = res.data.service

                })

            },
            erase(id){
                
                swal({
                    title: "Are you sure?",
                    text: "You will delete this vehicle!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        this.loading = true
                        axios.delete("{{ url('/api/admin/vehicle') }}"+"/"+id, {
                            headers:{
                                "Authorization": "Bearer "+window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                            }
                        }).then(res => {
                            this.loading = false
                            if(res.data.success == true){
                                swal({
                                    text: res.data.message,
                                    icon: "success"
                                });
                                this.fetch()
                            }else{

                                swal({
                                    text: res.data.message,
                                    icon: "error"
                                });

                            }

                        }).catch(err => {
                            this.loading = false
                            $.each(err.response.data.errors, function(key, value){
                                alert(value)
                            });
                        })

                    }
                });

            },
            toggleMenu(){

                if(this.showMenu == false){
                    $("#menu").addClass("show")
                    this.showMenu = true
                }else{
                    $("#menu").removeClass("show")
                    this.showMenu = false
                }

            }


        },
        mounted(){
            
            this.fetch()
            this.fetchservices()


        }

    })

</script>