/**
 * Debug output messages
 *
 * @param msg The message to show
 */
var consoleMessage = function (msg) {
    console.log(msg);
};

/**
 *
 * @param onSuccess
 * @param onDenied
 * @param onError
 */
var getRecordPermission = function (onSuccess, onDenied, onError) {
    window.audiorecord.hasPermission(function (result) {
        try {
            if (result.hasPermission) {
                if (onSuccess) onSuccess();
            }
            else {
                window.audiorecord.requestPermission(function (result) {
                    try {
						if (result.hasPermission) {
							if (onSuccess) onSuccess();
							else if (onDenied) onDenied();
						}
					}
                    catch (ex) {
                        if (onError) onError("Start after getting permission exception: " + ex);
                    }
				},
				function (errMsg) {
					if (onError) onError("getRecordPermission: " + errMsg);
                });
            }
        }
        catch (ex) {
            if (onError) onError("getRecordPermission exception: " + ex);
        }
    });
};


/**
 * Start capturing audio.
 */
var startCapture = function () {
    try {
        if (window.audiorecord/* && !window.audioinput.isCapturing()*/) {

            getRecordPermission(function () {
                // Connect the audioinput to the speaker(s) in order to hear the captured sound.
                // We're using a filter here to avoid too much feedback looping...
                // Start with default values and let the plugin handle conversion from raw data to web audio.

                consoleMessage("Microphone input starting...");
                window.audiorecord.startRecord({
					isChatMode: true,
					duration:10
					}, function(result) {
					consoleMessage("Record success:" + result);
				});
                consoleMessage("Microphone input started!");
                consoleMessage("Capturing audio!");
            }, function (deniedMsg) {
                consoleMessage(deniedMsg);
            }, function (errorMsg) {
                consoleMessage(errorMsg);
            });
        }
        else {
            alert("Already capturing!");
        }
    }
    catch (ex) {
        alert("startCapture exception: " + ex);
    }
};


/**
 * Stop capturing audio.
 */
var stopCapture = function () {

    if (window.audiorecord /*(window.audioinput.isCapturing()*/) {
        window.audiorecord.stopRecord(function(data) {
			var blob = new Blob([data], { type: 'audio/mp3' });
			if (blob.size > 0) {
				var mp3Name = 'recording_' + Date.now() + '.mp3';
				
				var reader = new FileReader();
				reader.onload = function (evt) {
					var audio = document.createElement("AUDIO");
					audio.controls = true;
					audio.src = evt.target.result;
					audio.type = "audio/mp3";
					document.getElementById("recording-list").appendChild(audio);
					consoleMessage("Audio created");
				};

				consoleMessage("Loading from BLOB");
				reader.readAsDataURL(blob);
			}
		});
    }

    consoleMessage("Stopped!");
};

/**
 * When cordova fires the deviceready event, we initialize everything needed for audio input.
 */
var onDeviceReady = function () {
    if (window.cordova && window.audiorecoder) {
        consoleMessage("Use 'Start Capture' to begin...");
    }
    else {
        consoleMessage("cordova-plugin-audioinput not found!");
    }
};


// Make it possible to run the demo on desktop.
if (!window.cordova) {
    console.log("Running on desktop!");
    onDeviceReady();
}
else {
    // For Cordova apps
    console.log("Running on device!");
    document.addEventListener('deviceready', onDeviceReady, false);
}
