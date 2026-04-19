@extends('layouts.app')

@section('page-title', 'Incoming Goods')

@section('content')
<div class="table-container">
    <div class="table-header">
        <div class="table-title"><svg class="icon-inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg> Incoming Goods (Stock In)</div>
        <button onclick="openAddIncomingModal()" class="btn-add">+ Add Incoming</button>
    </div>

    @if ($transactions->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Supplier</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $tx)
                    <tr>
                        <td>{{ $tx->product->name ?? 'N/A' }}</td>
                        <td>{{ $tx->supplier->name ?? 'N/A' }}</td>
                        <td>{{ $tx->quantity }}</td>
                        <td>{{ \Carbon\Carbon::parse($tx->transaction_date)->format('M d, Y') }}</td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <button 
                                    class="btn-edit" 
                                    data-transaction-id="{{ $tx->id }}"
                                    data-product-id="{{ $tx->product_id }}"
                                    data-supplier-id="{{ $tx->supplier_id }}"
                                    data-quantity="{{ $tx->quantity }}"
                                    data-transaction-date="{{ $tx->transaction_date }}"
                                    onclick="openEditIncomingModal(this)">Edit</button>
                                <form id="deleteForm-{{ $tx->id }}" method="POST" action="{{ url('/incoming/' . $tx->id) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button 
                                    type="button" 
                                    class="btn-delete" 
                                    data-transaction-id="{{ $tx->id }}"
                                    data-transaction-name="{{ $tx->product->name ?? 'Transaction' }}"
                                    onclick="openDeleteModal(this.dataset.transactionId, this.dataset.transactionName)">Delete</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">
            <div class="empty-state-icon"><svg class="icon-large" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg></div>
            <p>No incoming transactions yet</p>
            <button onclick="openAddIncomingModal()" class="btn-add">Create First Incoming</button>
        </div>
    @endif
</div>

<!-- Add Incoming Modal -->
<div id="addIncomingModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><svg class="icon-inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg> Add Incoming Goods</h2>
            <button class="modal-close" onclick="closeAddIncomingModal()">&times;</button>
        </div>
        
        <form method="POST" action="{{ url('/incoming') }}" class="modal-body">
            @csrf

            <div class="form-group">
                <label>Product</label>
                <select name="product_id" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Supplier</label>
                <select name="supplier_id" required>
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" value="{{ old('quantity') }}" required>
                    @error('quantity')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                    @error('transaction_date')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-submit">Add Incoming</button>
                <button type="button" class="btn-cancel" onclick="closeAddIncomingModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Incoming Modal -->
<div id="editIncomingModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2><svg class="icon-inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg> Edit Incoming Goods</h2>
            <button class="modal-close" onclick="closeEditIncomingModal()">&times;</button>
        </div>
        
        <form id="editIncomingForm" method="POST" class="modal-body">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Product</label>
                <select name="product_id" id="edit_product_id" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('product_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Supplier</label>
                <select name="supplier_id" id="edit_supplier_id" required>
                    <option value="">Select Supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity" id="edit_quantity" required>
                    @error('quantity')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="transaction_date" id="edit_transaction_date" required>
                    @error('transaction_date')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn-submit">Update Incoming</button>
                <button type="button" class="btn-cancel" onclick="closeEditIncomingModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content delete-modal">
        <div class="modal-body delete-body">
            <p>Are you sure you want to delete this incoming transaction for <strong id="deleteTransactionName"></strong>?</p>
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

    function openAddIncomingModal() {
        document.getElementById('addIncomingModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeAddIncomingModal() {
        document.getElementById('addIncomingModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function openEditIncomingModal(button) {
        const transactionId = button.dataset.transactionId;
        const productId = button.dataset.productId;
        const supplierId = button.dataset.supplierId;
        const quantity = button.dataset.quantity;
        const transactionDate = button.dataset.transactionDate;

        document.getElementById('edit_product_id').value = productId;
        document.getElementById('edit_supplier_id').value = supplierId;
        document.getElementById('edit_quantity').value = quantity;
        document.getElementById('edit_transaction_date').value = transactionDate;
        document.getElementById('editIncomingForm').action = '/incoming/' + transactionId;
        
        document.getElementById('editIncomingModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeEditIncomingModal() {
        document.getElementById('editIncomingModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    let deleteTransactionId = null;

    function openDeleteModal(transactionId, transactionName) {
        deleteTransactionId = transactionId;
        document.getElementById('deleteTransactionName').textContent = transactionName;
        document.getElementById('deleteModal').classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        deleteTransactionId = null;
        document.getElementById('deleteModal').classList.remove('show');
        document.body.style.overflow = 'auto';
    }

    function confirmDelete() {
        if (deleteTransactionId) {
            document.getElementById('deleteForm-' + deleteTransactionId).submit();
        }
    }

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        const addModal = document.getElementById('addIncomingModal');
        const editModal = document.getElementById('editIncomingModal');
        const deleteModal = document.getElementById('deleteModal');
        if (event.target == addModal) {
            closeAddIncomingModal();
        }
        if (event.target == editModal) {
            closeEditIncomingModal();
        }
        if (event.target == deleteModal) {
            closeDeleteModal();
        }
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeAddIncomingModal();
            closeEditIncomingModal();
            closeDeleteModal();
        }
    });

    // Show modal if there are validation errors
    document.addEventListener('DOMContentLoaded', function() {
        if (hasErrors) {
            openAddIncomingModal();
        }
    });
</script>
@endsection
