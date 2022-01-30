<script>

    var app = new Vue({
        el: '#dev-service',
        data(){
            return{

                loading:false,
                errors:[],
                airports:[],
                groups:[
                    {id:1, name: "Group A"},
                    {id:2, name: "Group B"},
                    {id:3, name: "Group C"}
                ],
                prices:JSON.parse('{!! $service->Prices !!}'),
                serviceTypes:JSON.parse('{!! $service->ServiceTypes !!}'),

                serviceId:"{{ $service->id }}",
                title:"{{ $service->name }}",
                applySoldOut:"{{ $service->apply_sold_out == 0 ? 'false' : 'true' }}",
                depotAddress:"{{ $service->depot_address }}",
                maxPets:"{{ $service->ServiceInfoRate->max_pets }}",
                maxBags:"{{ $service->ServiceInfoRate->max_bags }}",
                maxCarryOn:"{{ $service->ServiceInfoRate->max_carry_on_bag }}",
                maxPassengers:"{{ $service->ServiceInfoRate->max_passager }}",
                pictureStatus:"",
                imageProgress:"",
                imagePreview:"{{ $service->icon }}",
                file:"",
                finalPictureName:"",
                hasGroups:"{{ $service->has_groups == 0 ? 'false' : 'true' }}",
                isSharedAndPrivate:"{{ $service->is_shared_and_private == 0 ? 'false' : 'true' }}",
                maxStops:"{{ $service->ServiceInfoRate->max_stops }}",
                description:"",
                advice:"",
                secondaryAdvice:"",
                purchaseAdvice:"",
                
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

                modalServiceTypeTitle:"Create service type",
                modalServiceTypeAction:"create",
                serviceTypeId:"",
                serviceTypeName:"",
                serviceTypeIsOnlyPrivate:"true",
                serviceTypeDiscountPercentage:"",
                
                modalErrorServiceTypeName:"",
                modalErrorServiceTypeIsOnlyPrivate:"",
                modalErrorServiceTypeDiscountPercentage:"",

                editorDescriptionField:null,
                editorAdviceField:null,
                editorSecondaryAdviceField:null,
                editorPurchaseAdviceField:null


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
                this.sharedPrice = ""
                this.privatePrice = ""
                this.uniquePrice = ""
                this.baseBordenPrice = ""
                this.extraPassengerFee = ""
                this.extraFamilyPrice = ""
                this.parkingDayPrice = ""
                this.pricePerStops = ""
                this.selectedAirport = ""
                this.selectedGroup = ""
                this.priceId = ""

            },
            modalEdit(price, index){

                this.modalAction = 'edit'
                this.modalTitle = "Edit prices"

                this.priceId = index
                this.sharedPrice = price.shared_price
                this.privatePrice = price.private_price
                this.uniquePrice = price.unique_price
                this.baseBordenPrice = price.base_borden_price
                this.extraPassengerFee = price.extra_passenger_fee
                this.extraFamilyPrice = price.extra_family_price
                this.parkingDayPrice = price.parking_day_price
                this.pricePerStops = price.price_per_stop
                this.selectedAirport = price.airport_id
                this.selectedGroup = price.group_id

            },
            addPrice(){

                this.clearModalErrors()

                if(this.pricesHasErrors()){
                    return 
                }

                this.prices.push(
                    {
                        "airport_id": this.selectedAirport,
                        "group_id": this.selectedGroup,
                        "shared_price": this.sharedPrice,
                        "private_price": this.privatePrice,
                        "unique_price": this.uniquePrice,
                        "base_borden_price": this.baseBordenPrice,
                        "extra_passenger_fee": this.extraPassengerFee,
                        "extra_family_price": this.extraFamilyPrice,
                        "parking_day_price": this.parkingDayPrice,
                        "price_per_stop": this.pricePerStops
                    }
                )

                this.modalCreate()

            },
            serviceTypeModalCreate(){

                this.modalServiceTypeAction = "create"
                this.modalServiceTypeTitle = "Create service type"
                this.serviceTypeId = ""
                this.serviceTypeName = ""
                this.serviceTypeIsOnlyPrivate = "true"
                this.serviceTypeDiscountPercentage = ""

            },
            addServiceType(){

                this.modalErrorServiceTypeName = ""
                this.modalErrorServiceTypeIsOnlyPrivate = ""
                this.modalErrorServiceTypeDiscountPercentage = ""

                if(this.serviceTypesHasError()){
                    return 
                }

                this.serviceTypes.push({
                    "name": this.serviceTypeName,
                    "is_only_private": JSON.parse(this.serviceTypeIsOnlyPrivate),
                    "discount_percentage":this.serviceTypeDiscountPercentage ? this.serviceTypeDiscountPercentage : 0
                })

            },
            modalServiceTypeEdit(serviceType, index){

                this.modalServiceTypeAction = "edit"
                this.serviceTypeId = index
                this.serviceTypeName = serviceType.name
                this.serviceTypeIsOnlyPrivate = serviceType.is_only_private == 0 ? 'false' : 'true'
                this.serviceTypeDiscountPercentage = serviceType.discount_percentage

            },
            updateServiceType(){

                this.modalErrorServiceTypeName = ""
                this.modalErrorServiceTypeIsOnlyPrivate = ""
                this.modalErrorServiceTypeDiscountPercentage = ""

                if(this.serviceTypesHasError()){
                    return 
                }

                this.serviceTypes[this.serviceTypeId].name = this.serviceTypeName
                this.serviceTypes[this.serviceTypeId].is_only_private = JSON.parse(this.serviceTypeIsOnlyPrivate)
                this.serviceTypes[this.serviceTypeId].discount_percentage = this.serviceTypeDiscountPercentage ? this.serviceTypeDiscountPercentage : 0

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
            serviceTypesHasError(){

                let error = false

                if(this.serviceTypeName == ""){
                    this.modalErrorServiceTypeName = "Service type name is required"
                    error = true
                }

                if(this.serviceTypeIsOnlyPrivate == ""){
                    this.modalErrorServiceTypeIsOnlyPrivate = "This field is required"
                    error = true
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
            removeServiceType(index){

                this.serviceTypes.splice(index, 1)

            },
            clearPrices(){
                this.prices = []
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

                const response = await axios.put("{{ url('api/admin/service') }}"+"/"+this.serviceId,
                    {
                        "name":this.title,
                        "is_shared_and_private":JSON.parse(this.isSharedAndPrivate),
                        "has_groups":JSON.parse(this.hasGroups),
                        "icon":this.finalPictureName,
                        "depot_address":this.depotAddress,
                        "description":this.editorDescriptionField.getData(),
                        "advice":this.editorAdviceField.getData(),
                        "second_advice":this.editorSecondaryAdviceField.getData(),
                        "apply_sold_out":JSON.parse(this.applySoldOut),
                        "is_sold_out":false,
                        "purchase_advice":this.editorPurchaseAdviceField.getData(),
                        "info_rates":{
                            "max_passenger":this.maxPassengers,
                            "max_pets":this.maxPets,
                            "max_bags":this.maxBags,
                            "max_carry_on_bag":this.maxCarryOn,
                            "max_stops":this.maxStops
                        },
                        "prices":this.prices,
                        "service_types":this.serviceTypes
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

                    window.location.href="{{ route('services.index') }}"
                }

                else{
                    swal({
                        "text": response.data.message,
                        "icon":"error"
                    })
                }

            },
            async fetchAirports(){
                axios.get("{{ url('/api/admin/airport') }}", {
                    headers:{
                        "Authorization": "Bearer "+window.localStorage.getItem("SIMCOE_AUTH_TOKEN")
                    }
                })
                .then(res => {

                    this.airports = res.data.airport

                })

            },
            async createEditor(idTag){

                const editor = await ClassicEditor.create( document.querySelector( '#'+idTag ) )
                if(idTag == "editorDescription"){
                    this.editorDescriptionField = editor
                    this.editorDescriptionField.setData('{!! $service->description !!}')
                }

                if(idTag == "editorAdvice"){
                    this.editorAdviceField = editor
                    this.editorAdviceField.setData('{!! $service->advice !!}')
                }

                if(idTag == "editorSecondaryAdvice"){
                    this.editorSecondaryAdviceField = editor
                    this.editorSecondaryAdviceField.setData('{!! $service->secondary_advice !!}')
                }

                if(idTag == "editorPurchaseAdvice"){
                    this.editorPurchaseAdviceField = editor
                    this.editorPurchaseAdviceField.setData('{!! $service->purchase_advice !!}')
                
                }

            }
        },
        mounted(){

            this.fetchAirports()
            this.createEditor("editorDescription")
            this.createEditor("editorAdvice")
            this.createEditor("editorSecondaryAdvice")
            this.createEditor("editorPurchaseAdvice")

        },

    })

</script>