@csrf
<input type="hidden" name="branch_id" value="{{ $id }}">
<img src="" id="signature" class="manager-signature mb-2">
<input type="file" class="form-control" name="signature" onchange="document.getElementById('signature').src = window.URL.createObjectURL(this.files[0])" required>
<div class="error"></div>
