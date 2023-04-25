<div
    x-data="{
        audioSrc: @entangle('audioSrc'),
        play() {
            console.log(this.audioSrc);
            $refs.sourceRef.src = this.audioSrc + '?t=' + new Date().getTime();
            $refs.playMe.load();
            $refs.playMe.play();
        },
    }"
>
    <audio x-ref="playMe">
        <source x-ref="sourceRef" src="" type="audio/wav" x-init="$watch('audioSrc', value => play())"/>
    </audio>
</div>
