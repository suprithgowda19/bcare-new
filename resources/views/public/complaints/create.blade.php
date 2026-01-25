@extends('layouts.public')

@section('nav_title', 'ಹೊಸ ದೂರು ಸಲ್ಲಿಸಿ')
@section('back_url', route('public.complaints.sub_category', ['category_id' => $category->id]))

@push('styles')
<style>
    .upload_inputfile { position: absolute; left: -9999px; }
    .upload-center { width: 100%; display: flex; justify-content: center; }
    .upload-long { min-width: 280px; padding-left: 40px; padding-right: 40px; text-align: center; cursor: pointer; }
    .upload_img-wrap { display: flex; flex-wrap: wrap; margin: 10px -5px; justify-content: center; }
    .upload_img-box { width: 100px; padding: 0 5px; margin-bottom: 12px; position: relative; }
    .img-bg { 
        background-repeat: no-repeat; background-position: center; background-size: cover; 
        position: relative; padding-bottom: 100%; border-radius: 10px; border: 1px solid #ddd;
    }
    .btn-recording { background-color: #ff3b30 !important; animation: pulse-red 1s infinite; }
    @keyframes pulse-red { 0% { transform: scale(1); } 70% { transform: scale(1.05); } 100% { transform: scale(1); } }
    .location-loader { font-size: 11px; color: #6366f1; font-weight: 700; }
</style>
@endpush

@section('content')
<div class="page-content">
    <form method="POST" action="{{ route('public.complaints.store') }}" enctype="multipart/form-data" id="complaintForm">
        @csrf 
        <input type="hidden" name="category_id" value="{{ $category->id }}">
        <input type="hidden" name="subcategory_id" value="{{ $subcategory->id }}">

        <div class="card card-style shadow-xl">
            <div class="content mb-0">
                <h3 class="font-700">ದೂರಿನ ವಿವರಗಳು</h3>
                <p class="mb-4">ದಯವಿಟ್ಟು ಕೆಳಗಿನ ವಿವರಗಳನ್ನು ಮತ್ತು ದೂರಿನ ಫೋಟೋಗಳನ್ನು ಒದಗಿಸಿ.</p>

                <div class="input-style has-borders input-style-always-active mb-4">
                    <input type="text" class="form-control" value="{{ $subcategory->name }}" name="subject" readonly>
                    <label class="color-highlight font-500 font-13">ದೂರಿನ ವಿಷಯ</label>
                </div>

                <div class="input-style no-borders no-icon mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="color-highlight font-500">ವಿವರಣೆ (Description)</label>
                        <button type="button" onclick="startVoice('message_area')" id="btn-message_area" class="btn btn-xs bg-highlight color-white rounded-s mb-2 shadow-s">🎤 ಧ್ವನಿ (Voice)</button>
                    </div>
                    <textarea id="message_area" class="form-control" placeholder="ದೂರಿನ ಬಗ್ಗೆ ಹೆಚ್ಚಿನ ಮಾಹಿತಿ ನೀಡಿ..." name="message" rows="4" required>{{ old('message') }}</textarea>
                </div>

                <div class="input-style has-borders no-icon input-style-always-active mb-4">
                    <div class="d-flex justify-content-between">
                        <label class="color-highlight font-500 font-13">ಸ್ಥಳದ ವಿಳಾಸ</label>
                        <button type="button" onclick="startVoice('location_input')" id="btn-location_input" class="btn btn-xs bg-highlight color-white rounded-s mb-1 shadow-s">🎤 ಧ್ವನಿ (Voice)</button>
                    </div>
                    <input type="text" class="form-control" id="location_input" name="address" value="{{ old('address') }}" required placeholder="ವಿಳಾಸವನ್ನು ಇಲ್ಲಿ ನಮೂದಿಸಿ">
                </div>

                <div class="input-style has-borders input-style-always-active mb-4">
                    <select class="form-control" name="priority" required>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low (ಕಡಿಮೆ)</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : 'selected' }}>Medium (ಸಾಮಾನ್ಯ)</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High (ಹೆಚ್ಚು)</option>
                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent (ತುರ್ತು)</option>
                    </select>
                    <label class="color-highlight font-500 font-13">ಪ್ರಾಮುಖ್ಯತೆ (Priority)</label>
                </div>

                <div class="row mb-0">
                    <div class="col-12 mb-2 d-flex justify-content-between">
                        <span class="font-11 font-700 color-highlight text-uppercase">GPS Coordinates</span>
                        <a href="javascript:void(0)" onclick="requestLocation()" class="font-11 font-700 text-primary"><i class="fa fa-sync-alt me-1"></i> Refresh Location</a>
                    </div>
                    <div class="col-6">
                        <div class="input-style has-borders input-style-always-active mb-4">
                            <input type="text" class="form-control" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly required>
                            <label class="color-highlight font-500 font-13">Lat</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="input-style has-borders input-style-always-active mb-4">
                            <input type="text" class="form-control" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly required>
                            <label class="color-highlight font-500 font-13">Lng</label>
                        </div>
                    </div>
                </div>

                <div class="upload_box text-center mt-2">
                    <label class="upload_btn upload-center">
                        <input type="file" multiple class="upload_inputfile" id="imageUpload" name="image[]" accept="image/*" required>
                        <p class="btn bg-highlight rounded-sm shadow-xl btn-m text-uppercase font-900 color-white upload-long">
                            <i class="fa fa-camera pe-2"></i> ಫೋಟೋಗಳನ್ನು ಸೇರಿಸಿ
                        </p>
                    </label>
                    <div class="upload_img-wrap" id="imagePreviewWrap"></div>
                </div>

                <div class="text-center mt-4 mb-4">
                    <button type="submit" id="submitBtn" class="btn btn-full bg-highlight rounded-sm shadow-xl btn-m text-uppercase font-900 w-100">ದೂರು ಸಲ್ಲಿಸಿ (Submit)</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // 1. IMAGE PREVIEW
    document.getElementById('imageUpload').addEventListener('change', function(e) {
        const previewWrap = document.getElementById('imagePreviewWrap');
        previewWrap.innerHTML = ""; 
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = (event) => {
                previewWrap.insertAdjacentHTML('beforeend', `<div class='upload_img-box'><div style='background-image: url(${event.target.result})' class='img-bg'></div></div>`);
            };
            reader.readAsDataURL(file);
        });
    });

    // 2. LOCATION FETCH (FIXED)
    function requestLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                },
                function(error) {
                    alert("Location Error: " + error.message + ". Please enable GPS and Refresh.");
                },
                { enableHighAccuracy: true, timeout: 10000 }
            );
        }
    }
    document.addEventListener('DOMContentLoaded', requestLocation);

    // 3. VOICE (KANNADA)
    function startVoice(targetId) {
        if (!('webkitSpeechRecognition' in window)) { alert("Voice not supported."); return; }
        const recognition = new webkitSpeechRecognition();
        recognition.lang = 'kn-IN'; 
        recognition.onstart = () => { document.getElementById('btn-'+targetId).classList.add('btn-recording'); };
        recognition.onresult = (event) => { document.getElementById(targetId).value += " " + event.results[0][0].transcript; };
        recognition.onend = () => { document.getElementById('btn-'+targetId).classList.remove('btn-recording'); };
        recognition.start();
    }
</script>
@endpush