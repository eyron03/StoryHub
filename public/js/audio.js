const audio = document.getElementById('background-audio');

// Load audio position from localStorage if available
const savedTime = localStorage.getItem('audioCurrentTime');
if (savedTime) {
    audio.currentTime = savedTime;
}

// Play audio automatically
audio.play();

// Save the audio position every second
setInterval(() => {
    localStorage.setItem('audioCurrentTime', audio.currentTime);
}, 1000);

// Clear audio time on page unload (if necessary)
window.addEventListener('beforeunload', () => {
    localStorage.setItem('audioCurrentTime', audio.currentTime);
});