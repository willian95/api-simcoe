<script>
        
    const app = new Vue({
        el: '#dev-groups',
        data(){
            return{
                modalTitle:"New group",
                name:"",
                groupId:"",
                action:"create",
                groups:[],
                errors:[],
                pages:0,
                page:1,
                showMenu:false,
                loading:false,
            }
        },
        methods:{
            
            create(){
                this.modalTitle = "New group"
                this.action = "create"
                this.name = ""
                this.groupId = ""

            },
            store(){

                this.loading = true
                axios.post("{{ url('/api/admin/group') }}", {name: this.name})
                .then(res => {
                    this.loading = false
                    if(res.data.success == true){

                        swal({
                            text: res.data.msg,
                            icon: "success"
                        });
                        this.name = ""
                        this.fetch()

                        $('#groupsModal').modal('hide')
                        $('.modal-backdrop').remove()
                    }else{

                        swal({
                            text: res.data.msg,
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
                axios.put("{{ url('/admin/group') }}"+"/"+this.groupId, {name: this.name,})
                .then(res => {
                    this.loading = false
                    if(res.data.success == true){

                        swal({
                            text: res.data.msg,
                            icon: "success"
                        });
                        this.name = ""
                        this.groupId = ""
 
                        $('#groupsModal').modal('hide')
                        $('.modal-backdrop').remove()
                        this.fetch()
                        
                    }else{

                        swal({
                            text: res.data.msg,
                            icon: "error"
                        });

                    }

                })
                .catch(err => {
                    this.loading = false
                    this.errors = err.response.data.errors
                })

            },
            edit(group){
                this.modalTitle = "Edit group"
                this.action = "edit"
                this.name = group.name
                this.groupId = group.id

            },
            fetch(){

                axios.get("{{ url('/api/admin/group') }}")
                .then(res => {

                    this.groups = res.data

                })

            },
            erase(id){
                
                swal({
                    title: "Are you sure?",
                    text: "You will delete this group!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        this.loading = true
                        axios.delete("{{ url('/api/admin/group') }}", {id: id}).then(res => {
                            this.loading = false
                            if(res.data.success == true){
                                swal({
                                    text: res.data.msg,
                                    icon: "success"
                                });
                                this.fetch()
                            }else{

                                swal({
                                    text: res.data.msg,
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