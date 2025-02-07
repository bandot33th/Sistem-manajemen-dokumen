<!DOCTYPE html>
<html>

<head>
    <title>PDF Viewer</title>
    <style>
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            overflow-y: auto;
        }

        #pdf-container {
            width: 100%;
            max-width: 800px;
            height: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        canvas {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <div id="pdf-container"></div>

    <script src="{{ asset('vendor/pdfjs-dist/build/pdf.js') }}"></script>
    <script>
        const pdfData = "{{ $data }}";

        const pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = '{{ asset('vendor/pdfjs-dist/build/pdf.worker.js') }}';

        const container = document.getElementById('pdf-container');

        function renderPDF(data) {
            const loadingTask = pdfjsLib.getDocument({ data });
            loadingTask.promise.then(function (pdf) {
                for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
                    pdf.getPage(pageNumber).then(function (page) {
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');
                        const viewport = page.getViewport({ scale: 1.5 });

                        canvas.width = viewport.width;
                        canvas.height = viewport.height;

                        container.appendChild(canvas);

                        const renderContext = {
                            canvasContext: context,
                            viewport: viewport
                        };
                        page.render(renderContext);
                    });
                }
            });
        }

        renderPDF(atob(pdfData));

        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

        document.addEventListener('keydown', function (e) {
            if (e.ctrlKey && (e.key === 's' || e.key === 'p' || e.key === 'u' || e.key === 'c')) {
                e.preventDefault();
            }
        });
    </script>

</body>

</html>
