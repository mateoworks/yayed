<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" wire:ignore.self>
    <div class="modal-dialog" role="document" wire:ignore.self>
        <div class="modal-content" wire:ignore.self>
            <div class="modal-header" wire:ignore.self>
                <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo aval</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg> ... </svg>
                </button>
            </div>
            <form wire:submit.prevent="save" wire:ignore.self>
                <div class="modal-body">
                    <div class="form-group row mb-5">
                        <label for="endorsement.names" class="col-sm-3 col-form-label">Nombre(s):</label>
                        <div class="col-sm-7">
                            <input type="text" wire:model="endorsement.names" class="form-control @error('endorsement.names') is-invalid @enderror" id="endorsement.names">
                            @error('endorsement.names')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="form-group row mb-5">
                        <label for="endorsement.surnames" class="col-sm-3 col-form-label">Nombre(s):</label>
                        <div class="col-sm-7">
                            <input type="text" wire:model="endorsement.surnames" class="form-control @error('endorsement.surnames') is-invalid @enderror" id="endorsement.surnames">
                            @error('endorsement.surnames')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="form-group row mb-5">
                        <label for="endorsement.phone" class="col-sm-3 col-form-label">Nombre(s):</label>
                        <div class="col-sm-7">
                            <input type="text" wire:model="endorsement.phone" class="form-control @error('endorsement.phone') is-invalid @enderror" id="endorsement.phone">
                            @error('endorsement.phone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn" data-bs-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>