<script>
        
        const app = new Vue({
    el: '#dev-groups',
    data() {
        return {
            modalTitle: "New group",
            id: "",
            name: "",
            groupId: "",
            action: "create",
            groups: [],
            errors: [],
            pages: 0,
            page: 1,
            showMenu: false,
            loading: false,
        }
    },
    methods: {

        create() {
            this.modalTitle = "New group"
            this.action = "create"
            this.id = ""
            this.name = ""
            this.groupId = ""

        },
        store() {

            this.loading = true
            axios.post("{{ url('/api/admin/group') }}", {
                    name: this.name
                }, {
                    headers: {
                        "Authorization": "Bearer " + window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                    }
                })
                .then(res => {
                    this.loading = false
                    if (res.data.success == true) {

                        swal({
                            text: res.data.message,
                            icon: "success"
                        });
                        this.name = ""
                        this.fetch()

                        $('#groupsModal').modal('hide')
                        $('.modal-backdrop').remove()
                    } else {

                        message = res.data.message;

                        if (res.data.status == "Token is Expired")

                            message = "Session expired";

                        swal({
                            text: message,
                            icon: "error"
                        });

                        if (res.data.status == "Token is Expired")

                            window.location.replace("{{ url('/') }}");

                    }

                })
                .catch(err => {
                    this.loading = false
                    this.errors = err.response.data.errors
                })

        },
        update() {

            this.loading = true
            axios.put("{{ url('api/admin/group') }}" + "/" + this.groupId, {
                    name: this.name
                }, {
                    headers: {
                        "Authorization": "Bearer " + window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                    }
                })
                .then(res => {
                    this.loading = false
                    if (res.data.success == true) {

                        swal({
                            text: res.data.message,
                            icon: "success"
                        });
                        this.name = ""
                        this.groupId = ""

                        $('#groupsModal').modal('hide')
                        $('.modal-backdrop').remove()
                        this.fetch()

                    } else {

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
        edit(group) {
            this.modalTitle = "Edit group"
            this.action = "edit"
            this.id = group.id
            this.name = group.name
            this.groupId = group.id

        },
        fetch() {

            axios.get("{{ url('/api/admin/group') }}", {
                    headers: {
                        "Authorization": "Bearer " + window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                    }
                })
                .then(res => {

                    this.groups = res.data.group

                })

        },
        erase(id) {

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
                        axios.delete("{{ url('/api/admin/group') }}" + "/" + id, {
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

        },


    },
    mounted() {

        this.authenticated();

        this.fetch()

    }

})

</script>