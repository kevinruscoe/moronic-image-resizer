<template>

    <form class="resizer" :action="action" method='post' enctype="multipart/form-data">

        <div class="form-field">
            <label for="files">{{ message }}</label>
            <input
                type="file"
                name="files[]"
                ref="input"
                id="files"
                @change="updatefileCount"
                multiple required>
        </div>

        <div class="resize-to">
            <input type="number" name="width" placeholder="Width" required>
            <p>x</p>
            <input type="number" name="height" placeholder="Height" required>
        </div>

        <button type="submit">Resize</button>

    </form>
</template>

<script>
    export default {
        props: ['action'],
        data() {
            return {
                files: 0
            }
        },
        computed: {
            message() {
                if (this.files > 0) {
                    return `Gonna resize ${this.files} images hopefully.`;
                }

                return 'Images, please.'
            }
        },
        methods: {
            updatefileCount() {
                this.files = this.$refs['input'].files.length;
            }
        },
    }
</script>