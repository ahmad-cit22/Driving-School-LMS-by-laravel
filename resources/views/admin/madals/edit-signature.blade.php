@csrf
<input type="hidden" name="branch_id" value="{{ $branch->id }}">
<img src="{{ asset("uploads/signature/$branch->branch_manager_signature") }}" id="signature" class="manager-signature mb-2">
<input type="file" class="form-control" name="signature" onchange="document.getElementById('signature').src = window.URL.createObjectURL(this.files[0])" required accept=".jpg, .png">
<div class="error"></div>
