<script>

    var app = new Vue({
        el: '#dev-service',
        data(){
            return{

                services:[],
                links:[],
                currentPage:"",
                totalPages:"",
                linkClass:"page-link",
                activeLinkClass:"page-link active-link bg-main",


            }
        },
        methods:{

            async fetch(link = "{{ url('/api/admin/service') }}"){

                const response = await axios.get(link, {
                    headers:{
                        "Authorization": "Bearer "+window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                    }
                })
                this.services = response.data.service
                this.links = response.data.links
                this.currentPage = response.data.current_page
                this.totalPages = response.data.last_page

            },
            erase(id){
                
                swal({
                    title: "Are you sure?",
                    text: "You will delete this service!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        this.loading = true
                        axios.delete("{{ url('/api/admin/service') }}"+"/"+id, {
                            headers:{
                                "Authorization": "Bearer "+window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                            }
                        }).then(res => {
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


        },
        mounted(){

           this.fetch()

        }

    })

</script>