@extends("layouts.main")

@section("content")
<div class="d-flex flex-column-fluid" id="dev-vehicles">
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
               <h3 class="card-label">
               New vehicle
            </div>
         </div>
         <!--end::Header-->
         <!--begin::Body-->
         <div class="card-body">
            <div class="row">
               <div class="col-4">
                  <div class="form-group">
                     <label for="services">* Service</label>
                     <select class="form-control" v-model="service_id">
                        <option value="">Select</option>
                        <option :value="service.id" v-for="service in services">@{{ service.name }}</option>
                     </select>
                     <small v-if="errors.hasOwnProperty('group_id')">@{{ errors['service_id'][0] }}</small>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="name">* Name</label>
                     <input class="form-control" v-model="name">
                     <small v-if="errors.hasOwnProperty('name')">@{{ errors['name'][0] }}</small>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="name" title="(jpg,png | Suggested dimenssions: 250x250px | max: 2mb)">* Picture</label>
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
                     <label for="name">* Is private?</label>
                     <select class="form-control" v-model="is_private" >
                        <option value="">Select</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                     </select>
                     <small v-if="errors.hasOwnProperty('is_private')">@{{ errors['is_private'][0] }}</small>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="name">* is shared?</label>
                     <select class="form-control" v-model="is_shared" >
                        <option value="">Select</option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                     </select>
                     <small v-if="errors.hasOwnProperty('is_shared')">@{{ errors['is_shared'][0] }}</small>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <label for="name">* Max passengers</label>
                     <input class="form-control" v-model="maxPassengers">
                     <small v-if="errors.hasOwnProperty('maxPassengers')">@{{ errors['maxPassengers'][0] }}</small>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-12">
                  <p class="text-center">
                     <button class="btn btn-success" @click="uploadMainImage()">Create</button>
                  </p>
               </div>
            </div>
         </div>
         <!--end::Body-->
      </div>
      <!--end::Card-->
   </div>
   <!--end::Container-->
</div>

@endsection

@push('scripts')

    @include('vehicles.create.script')

@endpush