@extends('layouts.login')

@section('content')
<style>
.logo-login{
    width: 160px;
}
    </style>
    <div class="login_admin " id="dev-login">

        <div class="row">
            <div class="login100-more mask col-md-6"
                style="background-image: url('img/loginBG.jpg');">


               <!---- <p>Bienvenido a Aidacaceres CMS</p>--->
            </div>
            <div class="login100-form validate-form col-md-6">
            <img class="logo-login" src="{{ asset('img/loginBG.jpg') }}">
                <p> Content Management System </p>


                <div class="wrap-input100 validate-input">
                    <input class="input100" type="text" v-model="email">
                    <span class="focus-input100"></span>
                    <span class="label-input100">Email</span>
                    <small class="text-danger" v-if="errors.hasOwnProperty('email')">@{{ errors['email'][0] }}</small>
                </div>


                <div class="wrap-input100 validate-input">
                    <input class="input100" type="password" v-model="password">
                    <span class="focus-input100"></span>
                    <span class="label-input100">Password</span>
                    <small class="text-danger" v-if="errors.hasOwnProperty('password')">@{{ errors['password'][0] }}</small>
                </div>




                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" @click="login()">
                        Sign in
                    </button>
                </div>

            </div>


        </div>

    </div>
@endsection


@push("scripts")

<script type="text/javascript">
const app = new Vue({
    el: '#dev-login',
    data() {
        return {
            email: "",
            password: "",
            errors:[]
        }
    },
    methods: {

        async login() {

            try{

                const response = await axios.post("{{ route('admin.login') }}", {
                    email: this.email,
                    password: this.password
                })
                
                if (response.data.success == true) {

                    this.email = ""
                    this.password = ""
                    window.localStorage.setItem("SIMCOE_AUTH_TOKEN", response.data.token)
                    window.location.href = "{{ url('/dashboard') }}"

                }

                else{

                    swal({
                        text: res.data.msg,
                        icon: "error"
                    });

                }

            }catch(err){

                this.errors = err.response.data.errors

            }

        }

    },
    created() {


    }
});
</script>

@endpush