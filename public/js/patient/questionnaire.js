let isRecording = false;
let recorder;

async function toggleRecording(questionId) {
    try {
        const micImage = document.getElementById(`mic_${questionId}`);
        if (!isRecording) {
            const stream = await navigator.mediaDevices.getUserMedia({
                audio: {
                    sampleRate: 44100
                }
            });

            audio_context = new AudioContext;
            recorder = new Recorder(audio_context.createMediaStreamSource(stream));

            recorder.record();
            isRecording = true;
            micImage.src = "/assets/mic_recording.png"; // Update with the correct path
        } else {
            recorder.stop();
            isRecording = false;
            micImage.src = "/assets/mic.png"; // Update with the correct path

            // create WAV download link using audio data blob
            createDownloadLink(questionId);

            recorder.clear();
        }
    } catch (error) {
        console.error('Error toggling recording:', error);
    }
}

function createDownloadLink(questionId) {
    recorder.exportWAV(async function(blob) {
        try {
            // const formData = new FormData();
            // formData.append('audio', blob, 'recorded_audio.wav'); // 'audio' is the key
            var counter =1;
            var url = URL.createObjectURL(blob);
            var fileName = 'Recording' + counter + '.wav';
            var fileObject = new File([blob], fileName, {
                type: 'audio/wav'
            });
            var formData = new FormData();
            // recorded data
            formData.append('audio-blob', fileObject);
            // file name
            formData.append('audio-filename', fileObject.name);

            console.log('formdata',formData,'blob',blob)
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('/speech-to-text', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });

            const {
                transcripts
            } = await response.json();
            console.log(transcripts)
            console.log(questionId)
            document.getElementById(`answer_${questionId}`).value = transcripts.join(' ');
        } catch (error) {
            console.error('Error sending audio to server:', error);
        }
    });
}
