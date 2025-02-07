<div class="modal fade {{ $modalSize }}" id="{{ $modalId }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div 
        @if (isset($modalTop))
            class="modal-dialog"
        @else
            class="modal-dialog modal-dialog-centered modal-dialog-scrollable"
        @endif
        >
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ isset($modalTitleId) ? $modalTitleId : '' }}">{{ $modalTitle }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="{{ isset($modalBody) ? $modalBody: 'modalBodyId' }}" class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer" id="{{ isset($footerId) ? $footerId : '' }}">
                <div class="d-flex justify-content-center align-items-center gap-2 mr-2" id="{{ isset($otherButtonsContainer) ? $otherButtonsContainer : '' }}"></div>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cerrar</button>
                <button 
                    type="button" 
                    id="{{ isset($btnSaveId) ? $btnSaveId : '' }}" 
                    {{ isset($disabledSaveBtn) ? 'disabled' : '' }}
                    class="{{ isset($hideButton) ? "btn btn-outline-primary d-none" : "btn btn-outline-warning" }}"
                >
                    {{ isset($nameButtonSave) ? $nameButtonSave : 'Guardar' }}
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .modal {
        min-width: 100vw;
    }
    .modal-body {
        scroll-behavior: smooth;
    }
</style>
