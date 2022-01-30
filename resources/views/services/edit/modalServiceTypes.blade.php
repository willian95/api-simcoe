 <!-- Modal-->
 <div class="modal fade" id="servicesTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@{{ modalServiceTypeTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="serviceName">*Service type name</label>
                                <input type="text" class="form-control" id="serviceName" v-model="serviceTypeName">
                                <small v-if="modalErrorServiceTypeName" class="text-danger">@{{ modalErrorServiceTypeName }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="airports">* Is only for private rides?</label>
                            <div class="form-group">
                                <select class="form-control" v-model="serviceTypeIsOnlyPrivate">
                                    <option value="true">true</option>
                                    <option value="false">false</option>
                                </select>
                                <small v-if="modalErrorServiceTypeIsOnlyPrivate" class="text-danger">@{{ modalErrorServiceTypeIsOnlyPrivate }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="serviceTypeDiscountPercentage">Discount percentage</label>
                                <input type="text" class="form-control" id="serviceTypeDiscountPercentage" v-model="serviceTypeDiscountPercentage">
                                <small v-if="modalErrorServiceTypeDiscountPercentage" class="text-danger">@{{ modalErrorServiceTypeDiscountPercentage }}</small>
                            </div>
                        </div>

                        

                
                    </div>

                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold"  @click="addServiceType()" v-if="modalServiceTypeAction == 'create'">Create</button>
                <button type="button" class="btn btn-primary font-weight-bold"  @click="updateServiceType()" v-if="modalServiceTypeAction == 'edit'">Update</button>
            </div>
        </div>
    </div>
</div>