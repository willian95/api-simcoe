<script>

    var app = new Vue({
        el: '#dev-service',
        data(){
            return{

                loading:false,
                errors:[],
                airports:[
                    {id: 1, name:"Pearson Airport"},
                    {id: 2, name:"Billy Bishop Airport"},
                ],
                groups:[
                    {id:1, name: "Group A"},
                    {id:2, name: "Group B"},
                    {id:3, name: "Group C"}
                ],
                prices:[],

                title:"",
                applySoldOut:"false",
                depotAddress:"",
                maxPets:"",
                maxBags:"",
                maxCarryOn:"",
                maxPassengers:"",
                pictureStatus:"",
                imageProgress:"",
                imagePreview:"",
                hasGroups:'false',
                isSharedAndPrivate:'false',
                maxStops:0,
                

                modalAction:'create',
                modalTitle:"Add prices",
                sharedPrice:"",
                privatePrice:"",
                uniquePrice:"",
                baseBordenPrice:"",
                extraPassengerFee:"",
                extraFamilyPrice:"",
                parkingDayPrice:"",
                pricePerStops:"",
                selectedAirport:"",
                selectedGroup:"",
                priceId:"",

                modalErrorAirport:"",
                modalErrorGroup:"",
                modalErrorSharedPrice:"",
                modalErrorPrivatePrice:"",
                modalErrorUniquePrice:"",
                
                


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
            modalCreate(){

                this.modalAction = 'create'
                this.modalTitle = "Add prices"
                this.priceId = ""

            },
            modalEdit(price, index){

                this.modalAction = 'edit'
                this.modalTitle = "Edit prices"

                this.priceId = index
                this.sharedPrice = price.sharedPrice
                this.privatePrice = price.privatePrice
                this.uniquePrice = price.uniquePrice
                this.baseBordenPrice = price.baseBordenPrice
                this.extraPassengerFee = price.extraPassengerFee
                this.extraFamilyPrice = price.extraFamilyPrice
                this.parkingDayPrice = price.parkingDayPrice
                this.pricePerStops = price.pricePerStops
                this.selectedAirport = price.airport
                this.selectedGroup = price.group

            },
            addPrice(){

                this.clearModalErrors()

                if(this.pricesHasErrors()){
                    return 
                }

                this.prices.push(
                    {
                        "airport": this.selectedAirport,
                        "group": this.selectedGroup,
                        "sharedPrice": this.sharedPrice,
                        "privatePrice": this.privatePrice,
                        "uniquePrice": this.uniquePrice,
                        "baseBordenPrice": this.baseBordenPrice,
                        "extraPassengerFee": this.extraPassengerFee,
                        "extraFamilyPrice": this.extraFamilyPrice,
                        "parkingDayPrice": this.parkingDayPrice,
                        "pricePerStops": this.pricePerStops
                    }
                )

            },
            updatePrice(){

                this.clearModalErrors()

                if(this.pricesHasErrors()){
                    return 
                }

                this.prices[this.priceId].airport = this.selectedAirport
                this.prices[this.priceId].group = this.selectedGroup
                this.prices[this.priceId].sharedPrice = this.sharedPrice
                this.prices[this.priceId].privatePrice = this.privatePrice
                this.prices[this.priceId].uniquePrice = this.uniquePrice
                this.prices[this.priceId].baseBordenPrice = this.baseBordenPrice
                this.prices[this.priceId].extraPassengerFee = this.extraPassengerFee
                this.prices[this.priceId].extraFamilyPrice = this.extraFamilyPrice
                this.prices[this.priceId].parkingDayPrice = this.parkingDayPrice
                this.prices[this.priceId].pricePerStops = this.pricePerStops

            },
            pricesHasErrors(){

                let error = false;

                if(this.selectedAirport == ""){
                    this.modalErrorAirport = "Airport is required"
                    error = true
                }

                if(this.hasGroups == 'true'){
                    if(this.selectedGroup == ''){
                        this.modalErrorGroup = "Group is required"
                        error = true
                    }
                }

                if(this.isSharedAndPrivate == 'true'){

                    if(this.sharedPrice == ""){
                        this.modalErrorSharedPrice = "Shared price is required"
                        error = true
                    }

                    if(this.privatePrice == ""){
                        this.modalErrorPrivatePrice = "Private price is required"
                        error = true
                    }

                }

                if(this.isSharedAndPrivate == 'false'){
                    if(this.uniquePrice == ""){
                        this.modalErrorUniquePrice = "Unique price is required"
                        error = true
                    }
                }

                return error

            },
            clearModalErrors(){
                this.modalErrorUniquePrice = ""
                this.modalErrorPrivatePrice = ""
                this.modalErrorSharedPrice = ""
                this.modalErrorGroup = ""
                this.modalErrorAirport = ""
            },
            removePrice(index){

                this.prices.splice(index, 1)

            },
            clearPrices(){
                this.prices = []
            },
            async createService(){

                const response = await axios.post("{{ url('/api/admin/service') }}", {

                    

                })

            }



        },
        mounted(){

          

        }

    })

</script>