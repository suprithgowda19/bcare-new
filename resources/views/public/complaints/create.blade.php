@extends('layouts.staff')

@section('nav_title', 'ಹೊಸ ದೂರು')
@section('back_url', route('complaints.sub_category', ['category_id' => $category->id]))

@push('styles')
<style>
    .upload_inputfile { position: absolute; left: -9999px; }
    .upload-center { width: 100%; display: flex; justify-content: center; }
    .upload-long { min-width: 280px; padding-left: 40px; padding-right: 40px; text-align: center; cursor: pointer; }
    
    /* Image Preview Styling */
    .upload_img-wrap { display: flex; flex-wrap: wrap; margin: 10px -5px; justify-content: center; }
    .upload_img-box { width: 100px; padding: 0 5px; margin-bottom: 12px; position: relative; }
    .img-bg { 
        background-repeat: no-repeat; background-position: center; background-size: cover; 
        position: relative; padding-bottom: 100%; border-radius: 10px; border: 1px solid #ddd;
    }
    
    .btn-recording { background-color: #ff3b30 !important; animation: pulse-red 1s infinite; }
    @keyframes pulse-red { 0% { transform: scale(1); } 70% { transform: scale(1.05); } 100% { transform: scale(1); } }
</style>
@endpush

@section('content')
<form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data" id="complaintForm">
    @csrf 
    <input type="hidden" name="category_id" value="{{ $category->id }}">
    <input type="hidden" name="subcategory_id" value="{{ $subcategory->id }}">

    <div class="card card-style shadow-xl">
        <div class="content mb-0">
            <h3 class="font-600">ದೂರಿನ ವಿವರಗಳನ್ನು ನಮೂದಿಸಿ</h3>
            <p class="mb-4">ದಯವಿಟ್ಟು ಕೆಳಗಿನ ವಿವರಗಳನ್ನು ಮತ್ತು ದೂರಿನ ಫೋಟೋಗಳನ್ನು ಒದಗಿಸಿ.</p>

            <div class="input-style has-borders input-style-always-active mb-4">
                <input type="text" class="form-control" id="form1" value="{{ $subcategory->name }}" name="subject" readonly>
                <label for="form1" class="color-highlight font-400 font-13">ದೂರಿನ ವಿಷಯ</label>
            </div>

            <div class="input-style no-borders no-icon mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="message_area" class="color-highlight">ವಿವರಣೆ (Description)</label>
                    <button type="button" onclick="startVoice('message_area')" id="btn-message_area"
                        class="btn btn-xs bg-highlight color-white rounded-s mb-2 shadow-s">
                        🎤 ಧ್ವನಿ (Voice)
                    </button>
                </div>
                <textarea id="message_area" class="form-control"
                    placeholder="ನಿಮ್ಮ ದೂರನ್ನು ಇಲ್ಲಿ ತಿಳಿಸಿ..." name="message" rows="4" required></textarea>
                <em class="mt-n3">(ಕಡ್ಡಾಯ)</em>
            </div>

            <div class="input-style has-borders no-icon input-style-always-active mb-4">
                <div class="d-flex justify-content-between">
                    <label for="location_input" class="color-highlight font-400 font-13">ಸ್ಥಳದ ವಿಳಾಸ</label>
                    <button type="button" onclick="startVoice('location_input')" id="btn-location_input"
                        class="btn btn-xs bg-highlight color-white rounded-s mb-1 shadow-s">
                        🎤 ಧ್ವನಿ (Voice)
                    </button>
                </div>
                <input type="text" class="form-control" id="location_input"
                    placeholder="ಘಟನೆ ನಡೆದ ಸ್ಥಳದ ವಿಳಾಸ ತಿಳಿಸಿ" name="address" required>
                <em>(ಕಡ್ಡಾಯ)</em>
            </div>

            <div class="input-style has-borders input-style-always-active mb-4">
                <select class="form-control" name="priority" required>
                    <option value="" disabled selected>ಪ್ರಾಮುಖ್ಯತೆ ಆಯ್ಕೆಮಾಡಿ</option>
                    <option value="low">Low (ಕಡಿಮೆ)</option>
                    <option value="medium">Medium (ಸಾಮಾನ್ಯ)</option>
                    <option value="high">High (ಹೆಚ್ಚು)</option>
                    <option value="urgent">Urgent (ತುರ್ತು)</option>
                </select>
                <label class="color-highlight font-400 font-13">ಪ್ರಾಮುಖ್ಯತೆ (Priority)</label>
            </div>

            <div class="row mb-0">
                <div class="col-6">
                    <div class="input-style has-borders input-style-always-active mb-4">
                        <input type="text" class="form-control" id="lattitude" name="latitude" readonly required>
                        <label class="color-highlight font-400 font-13">Lat</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="input-style has-borders input-style-always-active mb-4">
                        <input type="text" class="form-control" id="longitude" name="longitude" readonly required>
                        <label class="color-highlight font-400 font-13">Lng</label>
                    </div>
                </div>
            </div>

            <div class="upload_box text-center mt-2">
                <div class="upload_btn-bx d-flex justify-content-center">
                    <label class="upload_btn upload-center">
                        <input type="file" multiple class="upload_inputfile" id="imageUpload" name="image[]" accept="image/*" required>
                        <p class="btn bg-highlight rounded-sm shadow-xl btn-m text-uppercase font-900 color-white upload-long">
                            <i class="fa fa-camera pe-2"></i> ಫೋಟೋಗಳನ್ನು ಸೇರಿಸಿ
                        </p>
                    </label>
                </div>
                <div class="upload_img-wrap" id="imagePreviewWrap"></div>
            </div>

            <div class="text-center mt-4 mb-4">
                <button type="submit" class="btn btn-full bg-highlight rounded-sm shadow-xl btn-m text-uppercase font-900 w-100">
                    ದೂರು ಸಲ್ಲಿಸಿ (Submit)
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    // 1. DYNAMIC IMAGE PREVIEW
    document.getElementById('imageUpload').addEventListener('change', function(e) {
        const previewWrap = document.getElementById('imagePreviewWrap');
        previewWrap.innerHTML = ""; // Clear old previews
        const files = e.target.files;

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();
            reader.onload = function(event) {
                const html = `
                    <div class='upload_img-box'>
                        <div style='background-image: url(${event.target.result})' class='img-bg'></div>
                    </div>`;
                previewWrap.insertAdjacentHTML('beforeend', html);
            }
            reader.readAsDataURL(file);
        }
    });

    // 2. LOCATION PERMISSION & AUTO-FETCH
    function requestLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById('lattitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                },
                function(error) {
                    if (error.code === error.PERMISSION_DENIED) {
                        alert("ಸ್ಥಳದ ಮಾಹಿತಿ ಪಡೆಯಲು ಅನುಮತಿ ಅಗತ್ಯವಿದೆ. ದಯವಿಟ್ಟು ಬ್ರೌಸರ್ ಸೆಟ್ಟಿಂಗ್‌ಗಳಲ್ಲಿ ಲೊಕೇಶನ್ ಆನ್ ಮಾಡಿ.");
                    } else {
                        alert("ಲೊಕೇಶನ್ ಪಡೆಯುವಲ್ಲಿ ತೊಂದರೆಯಾಗಿದೆ: " + error.message);
                    }
                },
                { enableHighAccuracy: true }
            );
        } else {
            alert("ನಿಮ್ಮ ಸಾಧನದಲ್ಲಿ ಲೊಕೇಶನ್ ಸಪೋರ್ಟ್ ಮಾಡುತ್ತಿಲ್ಲ.");
        }
    }

    // Auto-fetch location on page load
    document.addEventListener('DOMContentLoaded', requestLocation);

    // 3. KANNADA VOICE ASSISTANT
    function startVoice(targetId) {
        const targetInput = document.getElementById(targetId);
        const btn = document.getElementById('btn-' + targetId);
        
        if (!('webkitSpeechRecognition' in window)) {
            alert("Speech recognition not supported in this browser.");
            return;
        }

        const recognition = new webkitSpeechRecognition();
        recognition.lang = 'kn-IN'; 
        recognition.onstart = () => { 
            btn.classList.add('btn-recording'); 
            btn.innerHTML = "🎤 ಆಲಿಸುತ್ತಿದೆ..."; 
        };
        recognition.onresult = (event) => { 
            targetInput.value += " " + event.results[0][0].transcript; 
        };
        recognition.onend = () => { 
            btn.classList.remove('btn-recording'); 
            btn.innerHTML = "🎤 ಧ್ವನಿ (Voice)"; 
        };
        recognition.start();
    }
</script>
@endpush