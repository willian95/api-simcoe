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
                vehicles:[],
                errors:[],
                pages:0,
                page:1,
                showMenu:false,
                loading:false,
            }
        },
        methods:{

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
            this.fetchGroups()


        }

    })

</script>