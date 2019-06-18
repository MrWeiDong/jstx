$(function(){

    document.getElementById('audioBtn').onclick = function (e) {
        e.preventDefault();
        if (this.className == 'audio audio_icon') {
            document.getElementById('player').pause();
            this.className = 'mscBtn audio_icon';
        } else {
            document.getElementById('player').play();
            this.className = 'audio audio_icon';
        }
    }; 
})
