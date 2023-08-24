 @csrf
 <input type="hidden" name="id" value="{{ $enroll->id }}">
 <div class="mb-2">
     <label class="form-label">Enrollment ID</label>
     <input type="text" class="form-control" id="e_id" name="e_id" value="#00{{ $enroll->id }}" readonly>
     @error('name')
         <div class="invalid-feedback">{{ $message }}</div>
     @enderror
 </div>

 <div class="mb-2">
     <label class="form-label">Student ID</label>
     <input type="text" class="form-control" id="s_id" name="s_id" value="{{ $enroll->user->id_no }}" readonly>
     @error('name')
         <div class="invalid-feedback">{{ $message }}</div>
     @enderror
 </div>

 <div class="mb-2">
     <label class="form-label">Student Name</label>
     <input type="text" class="form-control" id="name" name="name" value="{{ $enroll->user->name }}" readonly>
     @error('name')
         <div class="invalid-feedback">{{ $message }}</div>
     @enderror
 </div>
 <div class="row mt-4 mb-2">
     <h6 class="col-6 site-text-primary">Class Attended: {{ $attendances->count() }}</h6>
     <h6 class="col-6 site-text-primary">Class Remaining: {{ $remaining_classes }}</h6>
 </div>
 <div class="mb-2">
     <label class="form-label">Class No.</label>
     <select name="class_no" class="form-select select2 @error('class_no')is-invalid @enderror" style="cursor: pointer;">
         <option value="0">-- Select Class No. --</option>
         <option value="{{ $attendances->count() + 1 }}" selected>Class No - {{ $attendances->count() + 1 }}</option>
     </select>
     @error('class_no')
         <div class="invalid-feedback">{{ $message }}</div>
     @enderror
 </div>

 <div class="mb-2">
     <label class="form-label">Date</label>
     <input type="date" class="form-control" id="date" name="date" value="{{ $current_date }}">
     @error('date')
         <div class="invalid-feedback">{{ $message }}</div>
     @enderror
 </div>

 <div class="error"></div>
