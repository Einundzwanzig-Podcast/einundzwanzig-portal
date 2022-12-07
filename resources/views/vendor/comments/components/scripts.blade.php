<script>
    if (window.Alpine) {
        console.warn(
            'Laravel Comments scripts were loaded after Alpine. ' +
            'Please ensure Alpine is loaded last so Laravel Comments can initialize first.'
        );
    }
</script>
@stack('comments-scripts')
