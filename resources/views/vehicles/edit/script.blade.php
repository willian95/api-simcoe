<script>
        
    const app = new Vue({
        el: '#dev-vehicles',
        data(){
            return{
                modalTitle:"New vehicle",
                id:"",
                name:"",
                vehicleId:"{{ $vehicle->id }}",
                action:"create",
                services:[],
                service_id:"{{ $vehicle->Service->id }}",
                name:"{{ $vehicle->name }}",
                maxPassengers:"{{ $vehicle->max_passenger }}",
                pictureStatus:"",
                imageProgress:"",
                imagePreview:"{{ $vehicle->picture }}",
                file:"",
                finalPictureName:"",
                is_private:"{{ $vehicle->is_private == 0 ? 'false' : 'true'}}",
                is_shared:"{{ $vehicle->is_shared == 0 ? 'false' : 'true'}}",
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
                        text:"Format not supported",
                        "icon": "error"
                    })

                }

                
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

                        this.update()

                    }).catch(err => {

                        this.loading = false
                        swal({
                            "text":err.response.data.message,
                            "icon": "error"
                        })

                    })

                }else{

                    this.update()


                }

            },
            async update(){

                const response = await axios.put("{{ url('api/admin/vehicle') }}"+"/"+this.vehicleId,
                    {
                        id:this.vehicleId,
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
            
            fetchservices(){

                axios.get("{{ url('/api/admin/service') }}", {
                    headers:{
                        "Authorization": "Bearer "+window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                    }
                })
                .then(res => {

                    this.services = res.data.service

                    this.service_id=this.service_id;

                })

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
            
            this.fetchservices()


        }

    })

</script>