<!-- resources/views/components/multiple-modal.blade.php -->
<div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Partes del Proyecto</h1>
                <button type="button" id="closeFirstModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped" id="partsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las filas se agregarán dinámicamente aquí -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="openSecondModal">Open second modal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Detalle de la Parte</h1>
                <button type="button" id="closeSecondModal" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="partDetailBody">
                <!-- Los detalles de la parte se agregarán dinámicamente aquí -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="backToFirstModal">Back to first</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openPartsModalButtons = document.querySelectorAll('.open-parts-modal');

        openPartsModalButtons.forEach(button => {
            button.addEventListener('click', function () {
                const projectId = this.getAttribute('data-project-id');
                fetchParts(projectId);
            });
        });

        document.getElementById('openSecondModal').addEventListener('click', function() {
            const firstModal = bootstrap.Modal.getInstance(document.getElementById('exampleModalToggle'));
            firstModal.hide();
            const secondModal = new bootstrap.Modal(document.getElementById('exampleModalToggle2'));
            secondModal.show();
        });

        document.getElementById('backToFirstModal').addEventListener('click', function() {
            const secondModal = bootstrap.Modal.getInstance(document.getElementById('exampleModalToggle2'));
            secondModal.hide();
            const firstModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
            firstModal.show();
        });

        const cleanupModals = () => {
            if (!document.querySelector('.modal.show')) {
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                document.body.classList.remove('modal-open');
                document.body.style = '';
            }
        };

        document.getElementById('exampleModalToggle').addEventListener('hidden.bs.modal', cleanupModals);
        document.getElementById('exampleModalToggle2').addEventListener('hidden.bs.modal', cleanupModals);

        document.getElementById('closeFirstModal').addEventListener('click', function() {
            const firstModal = bootstrap.Modal.getInstance(document.getElementById('exampleModalToggle'));
            firstModal.hide();
            cleanupModals();
        });

        document.getElementById('closeSecondModal').addEventListener('click', function() {
            const secondModal = bootstrap.Modal.getInstance(document.getElementById('exampleModalToggle2'));
            secondModal.hide();
            cleanupModals();
        });
    });

    function fetchParts(projectId) {
        // Aquí debes hacer una llamada AJAX para obtener las partes del proyecto
        // Por ejemplo:
        fetch(`/api/projects/${projectId}/parts`)
            .then(response => response.json())
            .then(data => {
                populatePartsTable(data);
                const firstModal = new bootstrap.Modal(document.getElementById('exampleModalToggle'));
                firstModal.show();
            });
    }

    function populatePartsTable(parts) {
        const partsTableBody = document.getElementById('partsTable').querySelector('tbody');
        partsTableBody.innerHTML = ''; // Limpia la tabla existente

        parts.forEach(part => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${part.id}</td>
                <td>${part.name}</td>
                <td>
                    <button class="btn btn-outline-secondary open-detail-modal" data-part-id="${part.id}">Detalle</button>
                </td>
            `;
            partsTableBody.appendChild(row);
        });

        document.querySelectorAll('.open-detail-modal').forEach(button => {
            button.addEventListener('click', function() {
                const partId = this.getAttribute('data-part-id');
                fetchPartDetail(partId);
            });
        });
    }

    function fetchPartDetail(partId) {
        // Aquí debes hacer una llamada AJAX para obtener el detalle de la parte
        // Por ejemplo:
        fetch(`/api/parts/${partId}`)
            .then(response => response.json())
            .then(data => {
                populatePartDetail(data);
                const secondModal = new bootstrap.Modal(document.getElementById('exampleModalToggle2'));
                secondModal.show();
            });
    }

    function populatePartDetail(part) {
        const partDetailBody = document.getElementById('partDetailBody');
        partDetailBody.innerHTML = `
            <p><strong>ID:</strong> ${part.id}</p>
            <p><strong>Nombre:</strong> ${part.name}</p>
            <p><strong>Descripción:</strong> ${part.description}</p>
            <!-- Agrega más campos según sea necesario -->
        `;
    }
</script>