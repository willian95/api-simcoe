@extends("layouts.main")

@section("content")

    <div class="d-flex flex-column-fluid" id="dev-service">
        <div class="loader-cover-custom" v-if="loading == true">
			<div class="loader-custom"></div>
		</div>
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <!--begin::Header-->
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Edit service
                    </div>
                </div>
                <!--end::Header-->
                <!--begin::Body-->
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">* Title</label>
                                <input class="form-control" v-model="title">
                                <small v-if="errors.hasOwnProperty('title')">@{{ errors['title'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" title="(jpg,png | Suggested dimenssions: 250x250px | max: 2mb)">* Icon</label>
                                <input type="file" class="form-control" ref="file" @change="onImageChange" accept="image/*" style="overflow: hidden;">

                                <img id="blah" :src="imagePreview" class="full-image" style="margin-top: 10px; width: 40%">

                                <div v-if="pictureStatus == 'uploading'" class="progress-bar progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" :style="{'width': `${imageProgress}%`}">
                                    @{{ imageProgress }}%
                                </div>
                                
                                <p v-if="pictureStatus == 'subiendo' && imageProgress < 100">Uploading</p>
                                <p v-if="pictureStatus == 'subiendo' && imageProgress == 100">Wait a second</p>
                                <p v-if="pictureStatus == 'listo' && imageProgress == 100">Image ready</p>

                                <small v-if="errors.hasOwnProperty('image')">@{{ errors['image'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">* Is shared and private?</label>
                                <select class="form-control" v-model="isSharedAndPrivate" @change="clearPrices()">
                                    <option value="true">true</option>
                                    <option value="false">false</option>
                                </select>
                                <small v-if="errors.hasOwnProperty('title')">@{{ errors['title'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">* Has groups?</label>
                                <select class="form-control" v-model="hasGroups" @change="clearPrices()">
                                    <option value="true">true</option>
                                    <option value="false">false</option>
                                </select>
                                <small v-if="errors.hasOwnProperty('title')">@{{ errors['title'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">* Apply sold out</label>
                                <select class="form-control" v-model="applySoldOut">
                                    <option value="true">true</option>
                                    <option value="false">false</option>
                                </select>
                                <small v-if="errors.hasOwnProperty('title')">@{{ errors['title'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Depot address (optional)</label>
                                <input class="form-control" v-model="depotAddress">
                                <small v-if="errors.hasOwnProperty('title')">@{{ errors['title'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-12">
                            <h3 class="text-center">General info</h3>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">* Max pets</label>
                                <input class="form-control" v-model="maxPets">
                                <small v-if="errors.hasOwnProperty('title')">@{{ errors['title'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">* Max bags</label>
                                <input class="form-control" v-model="maxBags">
                                <small v-if="errors.hasOwnProperty('title')">@{{ errors['title'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">* Max carry on bags</label>
                                <input class="form-control" v-model="maxCarryOn">
                                <small v-if="errors.hasOwnProperty('title')">@{{ errors['title'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">* Max passengers</label>
                                <input class="form-control" v-model="maxPassengers">
                                <small v-if="errors.hasOwnProperty('title')">@{{ errors['title'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">* Max stops</label>
                                <input class="form-control" v-model="maxStops">
                                <small v-if="errors.hasOwnProperty('title')">@{{ errors['title'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-12">
                            <h3 class="text-center">Prices 
                                <button href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#servicesPricesModal"> <span class="svg-icon svg-icon-md" @click="modalCreate()">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                
                                </button>
                            </h3>
                        </div>

                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Airport</th>
                                        <th v-if="hasGroups == 'true'">Group</th>
                                        <th v-if="isSharedAndPrivate == 'true'">Shared price</th>
                                        <th v-if="isSharedAndPrivate == 'true'">Private price</th>
                                        <th v-if="isSharedAndPrivate == 'false'">Unique price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(price, index) in prices">
                                        <td>
                                            <span v-if="airports.length > 0">
                                                @{{ airports.find(data => data.id == price.airport_id).name }}
                                            </span>
                                        </td>
                                        <td v-if="hasGroups == 'true'">
                                            @{{ groups.find(data => data.id == price.group_id)?.name }}
                                        </td>
                                        <td v-if="isSharedAndPrivate == 'true'">
                                            @{{ price.shared_price }}
                                        </td>
                                        <td v-if="isSharedAndPrivate == 'true'">
                                            @{{ price.private_price }}
                                        </td>
                                        <td v-if="isSharedAndPrivate == 'false'">
                                            @{{ price.unique_price }}
                                        </td>
                                        <td>
                                            <button class="btn btn-success" @click="modalEdit(price, index)" data-toggle="modal" data-target="#servicesPricesModal">
                                                edit
                                            </button>
                                            <button class="btn btn-secondary" @click="removePrice(index)">
                                                remove
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>

                        <div class="col-12">
                            <h3 class="text-center">Service types 
                                <button href="#" class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#servicesTypeModal"> <span class="svg-icon svg-icon-md" @click="serviceTypeModalCreate()">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                            <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                                        </g>
                                    </svg>
                
                                </button>
                            </h3>
                        </div>

                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Service type name</th>
                                        <th>Is only for private rides?</th>
                                        <th>Discount percentage</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(serviceType, index) in serviceTypes">
                                        <td>@{{ serviceType.name }}</td>
                                        <td>@{{ serviceType.is_only_private == 0 ? 'false' : 'true' }}</td>
                                        <td>@{{ serviceType.discount_percentage }}</td>
                                        <td>
                                            <button class="btn btn-success" @click="modalServiceTypeEdit(serviceType, index)" data-toggle="modal" data-target="#servicesTypeModal">
                                                edit
                                            </button>
                                            <button class="btn btn-secondary" @click="removeServiceType(index)">
                                                remove
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>

                        
                        <div class="col-12">
                            <h3 class="text-center">Description and advices</h3>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">* Description</label>
                                <textarea rows="3" id="editorDescription" v-model="description">{!! $service->description !!}</textarea>
                                <small v-if="errors.hasOwnProperty('description')">@{{ errors['description'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Advice (optional)</label>
                                <textarea rows="3" id="editorAdvice" v-model="advice">{!! $service->advice !!}</textarea>
                                <small v-if="errors.hasOwnProperty('advice')">@{{ errors['advice'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Secondary advice (optional)</label>
                                <textarea rows="3" id="editorSecondaryAdvice" v-model="secondaryAdvice">{!! $service->secondary_advice !!}</textarea>
                                <small v-if="errors.hasOwnProperty('secondary_advice')">@{{ errors['secondary_advice'][0] }}</small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Purchase advice (optional)</label>
                                <textarea rows="3" id="editorPurchaseAdvice" v-model="purchaseAdvice">{!! $service->purchase_advice !!}</textarea>
                                <small v-if="errors.hasOwnProperty('purchase_advice')">@{{ errors['purchase_advice'][0] }}</small>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <p class="text-center">
                                <button class="btn btn-success" @click="uploadMainImage()">Update</button>
                            </p>
                        </div>
                    </div>


                </div>
                <!--end::Body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->

        @include("services.edit.modal")
        @include("services.edit.modalServiceTypes")
    </div>

@endsection

@push("scripts")
    <script src="{{ url('ckeditor/build/ckeditor.js') }}"></script>
    @include("services.edit.script")

    

@endpush