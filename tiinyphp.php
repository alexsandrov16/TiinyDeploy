<?php
//Test
//require_once "vendor/autoload.php";

if (!file_exists('.htaccess')) {
    $content = <<<HTACCESS
    # Cambiar el tamaño máximo de archivo que se puede subir
    php_value upload_max_filesize 10M
    php_value post_max_size 10M

    # Cambiar la cantidad máxima de archivos que se pueden subir
    php_value max_file_uploads 100000000

    # Opcional: Cambiar el tiempo máximo de ejecución (en segundos)
    php_value max_execution_time 300

    # Opcional: Cambiar el límite de memoria (en megabytes)
    php_value memory_limit 128M
    HTACCESS;
    file_put_contents('.htaccess', $content);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
?>
    <!DOCTYPE html>
    <html lang="en" data-theme="light">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="TiinyPHP">
        <meta name="description" content="Deploy your PHP projects on TiinyHost quickly and easily.">
        <meta name="keywords" content="PHP, TiinyHost, deployment, projects, web">
        <title>🚀 TiinyDeploy - Deploy Your PHP Projects</title>
        <link rel="shortcut icon" href="https://raw.githubusercontent.com/alexsandrov16/tiinyphp/refs/heads/main/img/logo.svg" type="image/x-svg">
        <script src="//unpkg.com/alpinejs" defer></script>
        <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            small {
                color: rgb(202 138 4);
            }
        </style>
    </head>

    <body class="h-dvh bg-gradient-to-r from-fuchsia-50 to-violet-200 px-4 flex justify-center items-center">
        <div class="card bg-base-100 shadow-2xl p-6 w-full max-w-[32em] m-auto rounded-3xl">
            <center class="mb-8">
                <img src="https://raw.githubusercontent.com/alexsandrov16/tiinyphp/refs/heads/main/img/logo.svg" alt="" width="100">
                <h1 class="text-3xl lg:text-4xl mt-2 mb-3">Welcome to TiinyPHP</h1>
                <p class="text-xl lg:text-2xl">Take your PHP projects to TiinyHost with a single click.</p>
            </center>


            <form action="" method="post" enctype="multipart/form-data" x-data="fileUpload()">

        <!--

        <div class="label">
                    <span class="label-text opacity-70">What is your public folder?</span>
                </div>
                <label class="input input-bordered flex items-center gap-2 ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-folder-code opacity-70">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M11 19h-6a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v4" />
                        <path d="M20 21l2 -2l-2 -2" />
                        <path d="M17 17l-2 2l2 2" />
                    </svg>
                    <input type="text" name="public" class="grow" placeholder="/public" autocomplete="off" />
                </label>
                <div class="label mb-5"><span class="label-text opacity-60">If your public files are in the root folder leave this field empty.</span></div>

            -->

                <div class="flex items-center justify-center w-full bg-grey-lighter mb-4 ">
                    <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 text-gray-400">
                        <svg class="w-10 h-10" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                        </svg>
                        <span class="mt-2 text-base text-center leading-normal" x-html="fileInfo"></span>
                        <input class="hidden" type="file" name="files[]" webkitdirectory multiple @change="updateFileInfo">
                        <input type="hidden" name="folder" x-bind:value="folder">
                    </label>
                </div>

                <button class="btn bg-pink-400 border-bg-pink-400 hover:bg-pink-500 hover:border-bg-pink-500 text-white w-full rounded-full" type="submit">Deploy</button>

            </form>

        </div>

        <script>
            function fileUpload() {
                return {
                    fileInfo: 'Upload project folder.<!--<br/><small>The free version of TiinyHost has a limit of 3MB.</small>-->',
                    folder: '',
                    updateFileInfo(event) {
                        const files = event.target.files;
                        let totalSize = 0;
                        let folderName = '';

                        if (files.length > 0) {
                            folderName = files[0].webkitRelativePath.split('/')[0]; // Get the folder name
                            for (let i = 0; i < files.length; i++) {
                                totalSize += files[i].size; // Sum the sizes of the files
                            }
                        }

                        // Convert size to megabytes
                        const totalSizeMB = (totalSize / (1024 * 1024)).toFixed(2);
                        this.fileInfo = `Folder: ${folderName} | Size: ${totalSizeMB} MB`;
                        this.folder = folderName;
                    }
                }
            }
        </script>
    </body>

    </html>
<?php
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    define('DS', DIRECTORY_SEPARATOR);

    //$public = !empty($_POST['public']) ? trim($_POST['public'], '/') : '/';

    if (isset($_FILES['files'])) {
        $folder = $_POST['folder'];
        $uploadDir = 'D:\xampp\htdocs\tiinyphp\upload';

        foreach ($_FILES['files']['tmp_name'] as $key => $tmpFile) {
            $file = $_FILES['files']['name'][$key];

            // Asegúrate de que 'full_path' esté definido
            if (isset($_FILES['files']['full_path'][$key])) {
                $path = ltrim($_FILES['files']['full_path'][$key], $folder);
            } else {
                echo "Error: 'full_path' no está definido para el archivo $file.<br>";
                continue; // Salta a la siguiente iteración
            }

            // Crea el directorio de destino
            $dir = rtrim($uploadDir . DS . rtrim(dirname($path), DS), DS);
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true); // El tercer parámetro 'true' permite crear directorios anidados
            }

            // Construye la ruta completa del archivo
            $filename = $dir . DS . basename($file);


            // Mueve el archivo
            if (move_uploaded_file($tmpFile, $filename)) {

                echo "El archivo $filename se ha subido correctamente.<br>";
            } else {

                echo "Error al subir el archivo $filename.<br>";
            }
        }
    }
}
