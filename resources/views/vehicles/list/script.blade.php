<script>
const app = new Vue({
    el: '#dev-vehicles',
    data() {
        return {
            modalTitle: "New vehicle",
            id: "",
            name: "",
            vehicleId: "",
            action: "create",
            vehicles: [],
            errors: [],
            pages: 0,
            page: 1,
            showMenu: false,
            loading: false,
        }
    },
    methods: {

        fetch() {

            axios.get("{{ url('/api/admin/vehicle') }}", {
                    headers: {
                        "Authorization": "Bearer " + window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                    }
                })
                .then(res => {

                    this.vehicles = res.data.vehicle

                })

        },
        erase(id) {

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
                        axios.delete("{{ url('/api/admin/vehicle') }}" + "/" + id, {
                            headers: {
                                "Authorization": "Bearer " + window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                            }
                        }).then(res => {
                            this.loading = false
                            if (res.data.success == true) {
                                swal({
                                    text: res.data.message,
                                    icon: "success"
                                });
                                this.fetch()
                            } else {

                                swal({
                                    text: res.data.message,
                                    icon: "error"
                                });

                            }

                        }).catch(err => {
                            this.loading = false
                            $.each(err.response.data.errors, function(key, value) {
                                alert(value)
                            });
                        })

                    }
                });

        },
        authenticated() {

            this.loading = true

            axios.post("{{ url('api/admin/authenticatedUser') }}", {}, {
                    headers: {
                        "Authorization": "Bearer " + window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                    }
                })
                .then(res => {

                    this.loading = false

                    if (res.data.success == false) {

                        swal({
                            text: res.data.message,
                            icon: "error"
                        }).then(() => {
                            window.location.replace("{{ url('/') }}");
                        });

                    }

                })
                .catch(err => {

                    this.loading = false

                    if (err.response.data.message == "Malformed token")

                        swal({
                            text: "Session Invalid",
                            icon: "error"
                        }).then(() => {
                            window.location.replace("{{ url('/') }}");
                        });

                })
        },
        toggleMenu() {

            if (this.showMenu == false) {
                $("#menu").addClass("show")
                this.showMenu = true
            } else {
                $("#menu").removeClass("show")
                this.showMenu = false
            }

        }

    },
    mounted() {
        this.authenticated();
        this.fetch()
        this.fetchGroups()
    }

})

</script>