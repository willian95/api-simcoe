 <!-- Modal-->
 <div class="modal fade" id="servicesPricesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@{{ modalTitle }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-4">
                            <label for="airports">* Airport</label>
                            <div class="form-group">
                                <select class="form-control" v-model="selectedAirport">
                                    <option value="">Select</option>
                                    <option :value="aiport.id" v-for="aiport in airports">@{{ aiport.name }}</option>
                                </select>
                                <small v-if="modalErrorAirport" class="text-danger">@{{ modalErrorAirport }}</small>
                            </div>
                        </div>

                        <div class="col-md-4" v-if="hasGroups == 'true'">
                            <div class="form-group">
                                <label for="groups">* Group</label>
                                <select class="form-control" v-model="selectedGroup">
                                    <option value="">Select</option>
                                    <option :value="group.id" v-for="group in groups">@{{ group.name }}</option>
                                </select>
                                <small v-if="modalErrorGroup" class="text-danger">@{{ modalErrorGroup }}</small>
                            </div>
                        </div>

                        <div class="col-md-4" v-if="isSharedAndPrivate == 'true'">
                            <div class="form-group">
                                <label for="sharedPrice">* Shared price</label>
                                <input type="text" class="form-control" id="sharedPrice" v-model="sharedPrice">
                                <small v-if="modalErrorSharedPrice" class="text-danger">@{{ modalErrorSharedPrice }}</small>
                            </div>
                        </div>

                        <div class="col-md-4" v-if="isSharedAndPrivate == 'true'">
                            <div class="form-group">
                                <label for="privatePrice">* Private price</label>
                                <input type="text" class="form-control" id="privatePrice" v-model="privatePrice">
                                <small v-if="modalErrorPrivatePrice">@{{ modalErrorPrivatePrice }}</small>
                            </div>
                        </div>

                        <div class="col-md-4" v-if="isSharedAndPrivate == 'false'">
                            <div class="form-group">
                                <label for="uniquePrice">* Unique price</label>
                                <input type="text" class="form-control" id="uniquePrice" v-model="uniquePrice">
                                <small v-if="modalErrorUniquePrice" class="text-danger">@{{ modalErrorUniquePrice }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="baseBordenPrice">Base borden price (optional)</label>
                                <input type="text" class="form-control" id="baseBordenPrice" v-model="baseBordenPrice">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="extraPassengerFee">Extra passenger fee (optional)</label>
                                <input type="text" class="form-control" id="extraPassengerFee" v-model="extraPassengerFee">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="extraFamilyPrice">Extra family price (optional)</label>
                                <input type="text" class="form-control" id="extraFamilyPrice" v-model="extraFamilyPrice">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="parkingDayPrice">Parking day price (optional)</label>
                                <input type="text" class="form-control" id="parkingDayPrice" v-model="parkingDayPrice">
                            </div>
                        </div>

                        <div class="col-md-4" v-if="maxStops > 0">
                            <div class="form-group">
                                <label for="pricePerStops">* Price per stops</label>
                                <input type="text" class="form-control" id="pricePerStops" v-model="pricePerStops">
                            </div>
                        </div>

                
                    </div>

                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold"  @click="addPrice()" v-if="modalAction == 'create'">Create</button>
                <button type="button" class="btn btn-primary font-weight-bold"  @click="updatePrice()" v-if="modalAction == 'edit'">Update</button>
            </div>
        </div>
    </div>
</div>