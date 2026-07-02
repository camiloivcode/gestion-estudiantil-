<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <p id="deleteMessage"></p>
            </div>
            <div class="modal-footer">
                <button id="confirmDelete" class="btn btn-danger">Sí, eliminar</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let deleteId = null;
        const modalEl = document.getElementById('deleteModal');
        if (!modalEl) return;
        const modal = new bootstrap.Modal(modalEl);
        const message = document.getElementById('deleteMessage');
        const confirmBtn = document.getElementById('confirmDelete');
        const deleteForm = document.getElementById('deleteForm');

        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function () {
                deleteId = this.dataset.id;
                const name = this.dataset.name || 'este registro';
                const resource = this.dataset.resource || '';
                message.textContent = `¿Seguro que deseas eliminar ${resource ? resource + ' ' : ''}${name}?`;
                modal.show();
            });
        });

        if (confirmBtn) {
            confirmBtn.addEventListener('click', function () {
                if (deleteForm && deleteId) {
                    deleteForm.action = deleteForm.action.replace(/\/\d+$/, '') + '/' + deleteId;
                    deleteForm.submit();
                }
            });
        }
    });
</script>
@endpush