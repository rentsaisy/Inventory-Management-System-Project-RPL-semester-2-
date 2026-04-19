@extends('layouts.app')

@section('page-title', 'Suppliers')

@section('content')
<div class="table-container">
    <div class="table-header">
        <div class="table-title"><svg class="icon-inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6 0"></path><path d="M5 14l1 0"></path><path d="M19 14l1 0"></path><path d="M17 6l2 0"></path><path d="M5 6l2 0"></path><path d="M6 10a1 1 0 0 0 -1 1v3a6 6 0 0 0 6 6h2a6 6 0 0 0 6 -6v-3a1 1 0 0 0 -1 -1"></path><path d="M6 10v-4a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v4"></path></svg> Supplier Management</div>
        <button onclick="openAddSupplierModal()" class="btn-add">+ Add Supplier</button>
    </div>

    @if ($suppliers->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>City</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr>
                        <td><strong>{{ $supplier->name }}</strong></td>
                        <td>{{ $supplier->city ?? '-' }}</td>
                        <td>{{ $supplier->phone ?? '-' }}</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button 
                                    class="btn-edit" 
                                    data-supplier-id="{{ $supplier->id }}"
                                    data-name="{{ $supplier->name }}"
                                    data-city="{{ $supplier->city }}"
                                    data-phone="{{ $supplier->phone }}"
                                    onclick="openEditSupplierModal(this)">Edit</button>
                                <form id="deleteForm-{{ $supplier->id }}" method="POST" action="{{ url('/suppliers/' . $supplier->id) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button 
                                    type="button" 
                                    class="btn-delete" 
                                    data-supplier-id="{{ $supplier->id }}"
                                    data-supplier-name="{{ $supplier->name }}"
                                    onclick="openDeleteModal(this.dataset.supplierId, this.dataset.supplierName)">Delete</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon"><svg class="icon-large" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6 0"></path><path d="M5 14l1 0"></path><path d="M19 14l1 0"></path><path d="M17 6l2 0"></path><path d="M5 6l2 0"></path><path d="M6 10a1 1 0 0 0 -1 1v3a6 6 0 0 0 6 6h2a6 6 0 0 0 6 -6v-3a1 1 0 0 0 -1 -1"></path><path d="M6 10v-4a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v4"></path></svg></div>
            <p>No suppliers found</p>
            <button onclick="openAddSupplierModal()" class="btn-add">Create First Supplier</button>
        </div>
    @endif
</div>

<!-- Add Supplier Modal -->
<div id="addSupplierModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><svg class="icon-inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6 0"></path><path d="M5 14l1 0"></path><path d="M19 14l1 0"></path><path d="M17 6l2 0"></path><path d="M5 6l2 0"></path><path d="M6 10a1 1 0 0 0 -1 1v3a6 6 0 0 0 6 6h2a6 6 0 0 0 6 -6v-3a1 1 0 0 0 -1 -1"></path><path d="M6 10v-4a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v4"></path></svg> Add New Supplier</h2>
            <button class="modal-close" onclick="closeAddSupplierModal()">&times;</button>
        </div>
        
        <form method="POST" action="{{ url('/suppliers') }}" class="modal-body">
            @csrf

            <div class="form-group">
                <label>Supplier Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" value="{{ old('city') }}">
                    @error('city')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-submit">Add Supplier</button>
                <button type="button" class="btn-cancel" onclick="closeAddSupplierModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Supplier Modal -->
<div id="editSupplierModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><svg class="icon-inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6 0"></path><path d="M5 14l1 0"></path><path d="M19 14l1 0"></path><path d="M17 6l2 0"></path><path d="M5 6l2 0"></path><path d="M6 10a1 1 0 0 0 -1 1v3a6 6 0 0 0 6 6h2a6 6 0 0 0 6 -6v-3a1 1 0 0 0 -1 -1"></path><path d="M6 10v-4a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v4"></path></svg> Edit Supplier</h2>
            <button class="modal-close" onclick="closeEditSupplierModal()">&times;</button>
        </div>
        
        <form id="editSupplierForm" method="POST" class="modal-body">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Supplier Name</label>
                <input type="text" name="name" id="edit_name" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" id="edit_city">
                    @error('city')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" id="edit_phone">
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-submit">Update Supplier</button>
                <button type="button" class="btn-cancel" onclick="closeEditSupplierModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content delete-modal">
        <div class="modal-body delete-body">
            <p>Are you sure you want to delete <strong id="deleteSupplierName"></strong>?</p>
            <p class="delete-warning">This action cannot be undone.</p>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn-delete" onclick="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: var(--bg-white);
        padding: 0;
        border-radius: 12px;
        width: 90%;
        max-width: 420px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-light);
    }

    .modal-header h2 {
        margin: 0;
        font-size: 18px;
        color: var(--text-dark);
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 28px;
        color: var(--text-gray);
        cursor: pointer;
        padding: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .modal-close:hover {
        background: var(--bg-light);
        color: var(--text-dark);
    }

    .modal-body {
        padding: 15px 20px;
    }

    .modal-footer {
        display: flex;
        gap: 10px;
        padding: 12px 20px;
        border-top: 1px solid var(--border-light);
        justify-content: flex-end;
    }

    .modal-footer .btn-submit,
    .modal-footer .btn-cancel {
        padding: 8px 16px;
        font-size: 13px;
    }

    .error-message {
        display: block;
        color: var(--danger);
        font-size: 12px;
        margin-top: 4px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .icon-inline {
        width: 20px;
        height: 20px;
        display: inline-block;
        vertical-align: middle;
        margin-right: 8px;
        stroke: currentColor;
    }

    .icon-large {
        width: 64px;
        height: 64px;
        color: var(--text-gray);
        margin-bottom: 16px;
    }

    .delete-modal {
        max-width: 360px;
    }

    .delete-body {
        text-align: center;
        padding: 20px 15px;
    }

    .delete-body p {
        margin: 10px 0;
        color: var(--text-dark);
    }

    .delete-body strong {
        color: var(--danger);
    }

    .delete-warning {
        font-size: 12px;
        color: var(--text-gray);
        font-style: italic;
    }
</style>

<script>
    const hasErrors = '{{ $errors->any() ? "true" : "false" }}' === 'true';

    function openAddSupplierModal() {
        document.getElementById('addSupplierModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeAddSupplierModal() {
        document.getElementById('addSupplierModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function openEditSupplierModal(button) {
        const supplierId = button.dataset.supplierId;
        const name = button.dataset.name;
        const city = button.dataset.city;
        const phone = button.dataset.phone;

        document.getElementById('edit_name').value = name;
        document.getElementById('edit_city').value = city || '';
        document.getElementById('edit_phone').value = phone || '';
        document.getElementById('editSupplierForm').action = '/suppliers/' + supplierId;
        
        document.getElementById('editSupplierModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeEditSupplierModal() {
        document.getElementById('editSupplierModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    let deleteSupplierId = null;

    function openDeleteModal(supplierId, supplierName) {
        deleteSupplierId = supplierId;
        document.getElementById('deleteSupplierName').textContent = supplierName;
        document.getElementById('deleteModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        deleteSupplierId = null;
        document.getElementById('deleteModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function confirmDelete() {
        if (deleteSupplierId) {
            document.getElementById('deleteForm-' + deleteSupplierId).submit();
        }
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const addModal = document.getElementById('addSupplierModal');
        const editModal = document.getElementById('editSupplierModal');
        const deleteModal = document.getElementById('deleteModal');
        if (event.target == addModal) {
            closeAddSupplierModal();
        }
        if (event.target == editModal) {
            closeEditSupplierModal();
        }
        if (event.target == deleteModal) {
            closeDeleteModal();
        }
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeAddSupplierModal();
            closeEditSupplierModal();
            closeDeleteModal();
        }
    });

    // Show modal if there are validation errors
    document.addEventListener('DOMContentLoaded', function() {
        if (hasErrors) {
            openAddSupplierModal();
        }
    });
</script>
@endsection
