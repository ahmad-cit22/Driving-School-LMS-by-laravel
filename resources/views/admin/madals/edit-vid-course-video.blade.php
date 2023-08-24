 @csrf
 <input type="hidden" name="id" value="{{ $video->id }}">
 <div class="mb-2">
     <label class="form-label">Class No.</label>
     <input type="number" class="form-control @error('class_no')is-invalid @enderror" name="class_no" value="{{ $video->class_no }}" placeholder="Enter Class No." required>
     @error('class_no')
         <div class="invalid-feedback">{{ $message }}</div>
     @enderror
 </div>

 <div class="mb-2">
     <label class="form-label">Video Title</label>
     <input type="text" class="form-control @error('video_title')is-invalid @enderror" name="video_title" value="{{ $video->video_title }}" placeholder="Enter Video Title" required>
     @error('video_title')
         <div class="invalid-feedback">{{ $message }}</div>
     @enderror
 </div>
 <div class="mb-2">
     <label class="form-label">Video Link</label>
     <input type="text" class="form-control @error('video_link')is-invalid @enderror" name="video_link" value="{{ $video->video_link }}" placeholder="Enter Video Link" required>
     @error('video_link')
         <div class="invalid-feedback">{{ $message }}</div>
     @enderror
 </div>
