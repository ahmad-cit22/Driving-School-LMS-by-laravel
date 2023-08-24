  @csrf
  <input type="hidden" name="enrollment_id" value="{{ $enroll->id }}">
  <div class="mb-3">
      <label class="form-label">Rate The Course (Out of 5)</label>
      <select class="form-select cursor-pointer" name="review" id="review" required>
          <option value=""> -- Select a Number -- </option>
          <option value="1"> 1 </option>
          <option value="2"> 2 </option>
          <option value="3"> 3 </option>
          <option value="4"> 4 </option>
          <option value="5" selected> 5 </option>
      </select>
  </div>
  <div class="mb-3">
      <label class="form-label">Give Your Feedback</label>
      <textarea class="form-control" name="feedback" id="feedback" cols="30" rows="6" placeholder="Kindly Give Your Feedback Shortly About the Course" @error('feedback')is-invalid @enderror required></textarea>
  </div>

  <div class="error"></div>
