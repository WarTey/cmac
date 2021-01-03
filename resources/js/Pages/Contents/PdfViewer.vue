<template>
    <div>
        <canvas class="w-full rounded border" :id="file.uuid">{{ loadFile(file.title, file.uuid) }}</canvas>
        <div class="mt-2 flex">
            <a class="text-blue-500 font-semibold text-justify hover:underline cursor-pointer" v-on:click.prevent="previousPage(file.uuid)">
                Page précédente
            </a>
            <a class="text-blue-500 font-semibold text-justify hover:underline cursor-pointer ml-auto" v-on:click.prevent="nextPage(file.uuid)">
                Page suivante
            </a>
        </div>
    </div>
</template>

<script>
export default {
    name: "PdfViewer",

    props: ['urlFile', 'file'],

    data() {
        return {
            files: []
        }
    },

    methods: {
        loadFile(url, uuid) {
            pdfjsLib.getDocument({
                url : "/storage/files/" + url,
                disableAutoFetch: true,
                disableStream: true
            }).promise.then(pdf => {
                this.files.push({
                    uuid: uuid,
                    pdf: pdf,
                    pages: pdf.numPages,
                    currentPage: 1
                });

                pdf.getPage(1).then(page => this.renderFile(page, uuid));
            });
        },

        renderFile(page, uuid) {
            const canvas = document.getElementById(uuid);
            const context = canvas.getContext('2d');
            const viewport = page.getViewport({
                scale: 2,
                rotation: 0
            });

            canvas.height = viewport.height;
            canvas.width = viewport.width;

            page.render({
                canvasContext: context,
                viewport: viewport
            });
        },

        nextPage(uuid) {
            if (this.files.length > 0) {
                this.files.forEach(element => {
                    if (element.uuid === uuid && element.currentPage < element.pages) {
                        element.currentPage += 1;
                        element.pdf.getPage(element.currentPage).then(page => this.renderFile(page, uuid));
                    }
                });
            }
        },

        previousPage(uuid) {
            this.files.forEach(element => {
                if (element.uuid === uuid && element.currentPage > 0) {
                    element.currentPage -= 1;
                    element.pdf.getPage(element.currentPage).then(page => this.renderFile(page, uuid));
                }
            });
        },
    }
}
</script>
