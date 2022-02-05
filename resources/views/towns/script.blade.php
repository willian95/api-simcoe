<script>
        
    const app = new Vue({
        el: '#dev-towns',
        data(){
            return{
                modalTitle:"New town",
                id:"",
                name:"",
                townId:"",
                action:"create",
                groups:[],
                group_id:"",
                towns:[],
                errors:[],
                pages:0,
                page:1,
                showMenu:false,
                loading:false,
            }
        },
        methods:{
            
            create(){
                this.modalTitle = "New town"
                this.action = "create"
                this.id = ""
                this.group_id=""
                this.name = ""
                this.townId = ""
            },
            
            store(){

                this.loading = true
                axios.post("{{ url('/api/admin/town') }}", {group_id: this.group_id,name: this.name}, {
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

                        $('#townsModal').modal('hide')
                        $('.modal-backdrop').remove()
                    }else{

                        message=res.data.message;
                        
                        if(res.data.status=="Token is Expired")
                        
                                message="Session expired";

                        swal({
                            text: message,
                            icon: "error"
                        });

                        if(res.data.status=="Token is Expired")

                            window.location.replace("{{ url('/') }}");

                    }

                })
                .catch(err => {
                    this.loading = false
                    this.errors = err.response.data.errors
                })

            },
            update(){

                this.loading = true
                axios.put("{{ url('api/admin/town') }}"+"/"+this.townId, {group_id: this.group_id,name: this.name}, {
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
                        this.townId = ""
 
                        $('#townsModal').modal('hide')
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
            edit(town){
                this.modalTitle = "Edit town"
                this.action = "edit"
                this.id = town.id
                this.group_id= town.group_id
                this.name = town.name
                this.townId = town.id

            },
            fetch(){

                axios.get("{{ url('/api/admin/town') }}", {
                    headers:{
                        "Authorization": "Bearer "+window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                    }
                })
                .then(res => {

                    this.towns = res.data.town

                })

            },
            fetchGroups(){

                axios.get("{{ url('/api/admin/group') }}", {
                    headers:{
                        "Authorization": "Bearer "+window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                    }
                })
                .then(res => {

                    this.groups = res.data.group

                })

            },
            erase(id){
                
                swal({
                    title: "Are you sure?",
                    text: "You will delete this town!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        this.loading = true
                        axios.delete("{{ url('/api/admin/town') }}"+"/"+id, {
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