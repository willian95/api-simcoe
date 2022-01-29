<script>
        
    const app = new Vue({
        el: '#dev-airports',
        data(){
            return{
                modalTitle:"New airport",
                name:"",
                airportId:"",
                action:"create",
                airports:[],
                errors:[],
                pages:0,
                page:1,
                showMenu:false,
                loading:false,
            }
        },
        methods:{
            
            create(){
                this.modalTitle = "New airport"
                this.action = "create"
                this.name = ""
                this.airportId = ""

            },
            store(){

                this.loading = true
                axios.post("{{ url('/api/admin/airport') }}", {name: this.name}, {
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
                        this.fetch()

                        $('#airportsModal').modal('hide')
                        $('.modal-backdrop').remove()
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
            update(){

                this.loading = true
                axios.put("{{ url('api/admin/airport') }}"+"/"+this.airportId, {name: this.name}, {
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
                        this.airportId = ""
 
                        $('#airportsModal').modal('hide')
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
            edit(airport){
                this.modalTitle = "Edit airport"
                this.action = "edit"
                this.name = airport.name
                this.airportId = airport.id

            },
            fetch(){

                axios.get("{{ url('/api/admin/airport') }}", {
                    headers:{
                        "Authorization": "Bearer "+window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                    }
                })
                .then(res => {

                    this.airports = res.data.airport

                })

            },
            erase(id){
                
                swal({
                    title: "Are you sure?",
                    text: "You will delete this airport!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        this.loading = true
                        axios.delete("{{ url('/api/admin/airport') }}"+"/"+id, {
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

        }

    })

</script>