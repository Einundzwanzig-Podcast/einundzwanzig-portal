<style>
    .shiki .highlight {
        background-color: hsl(197, 88%, 94%);
        padding: 3px 0;
    }

    .shiki .add {
        background-color: hsl(136, 100%, 96%);
        padding: 3px 0;
    }

    .shiki .del {
        background-color: hsl(354, 100%, 96%);
        padding: 3px 0;
    }

    .shiki.focus .line:not(.focus) {
        transition: all 250ms;
        filter: blur(2px);
    }

    .shiki.focus:hover .line {
        transition: all 250ms;
        filter: blur(0);
    }

    .comments {
        --comments-color-background: rgb(34, 34, 34);
        --comments-color-background: rgb(34, 34, 34);
        --comments-color-background-nested: rgb(34, 34, 34);
        --comments-color-background-paper: rgb(55, 51, 51);
        --comments-color-background-info: rgb(104, 89, 214);

        --comments-color-reaction: rgb(59, 59, 59);
        --comments-color-reaction-hover: rgb(65, 63, 63);
        --comments-color-reacted: rgba(67, 56, 202, 0.25);
        --comments-color-reacted-hover: rgba(67, 56, 202, 0.5);

        --comments-color-border: rgb(221, 221, 221);

        --comments-color-text: white;
        --comments-color-text-dimmed: rgb(164, 164, 164);
        --comments-color-text-inverse: white;

        --comments-color-accent: rgba(67, 56, 202);
        --comments-color-accent-hover: rgba(67, 56, 202, 0.75);

        --comments-color-danger: rgb(225, 29, 72);
        --comments-color-danger-hover: rgb(225, 29, 72, 0.75);

        --comments-color-success: rgb(10, 200, 134);
        --comments-color-success-hover: rgb(10, 200, 134, 0.75);

        --comments-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    }

    .comments-button {
        background-color: #F7931A !important;
    }

    .leaflet-pane {
        z-index: 0 !important;
    }

    [x-cloak] {
        display: none !important;
    }
</style>
