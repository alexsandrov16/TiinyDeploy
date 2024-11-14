<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Deploy your PHP projects on TiinyHost quickly and easily.">
    <meta name="keywords" content="PHP, TiinyHost, deployment, projects, web">
    <title>🚀 TiinyDeploy - Deploy Your PHP Projects</title>
    <link rel="shortcut icon" href="img/logo.svg" type="image/x-svg">
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        small{
            color: rgb(202 138 4);
        }
    </style>
</head>

<body class="h-dvh bg-gradient-to-r from-fuchsia-50 to-violet-200 px-4 flex justify-center items-center">
    <div class="card bg-base-100 shadow-2xl p-6 w-full max-w-[32em] m-auto rounded-3xl">
        <center class="mb-8">
            <img src="img/logo.svg" alt="" width="100">
            <h1 class="text-3xl lg:text-4xl mt-2 mb-3">Welcome to TiinyPHP</h1>
            <p class="text-xl lg:text-2xl">Take your PHP projects to TiinyHost with a single click.</p>
        </center>


        <form action="" method="post" x-data="fileUpload()">

            <div class="flex items-center justify-center w-full bg-grey-lighter mb-4 ">
                <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 text-gray-400">
                    <svg class="w-10 h-10" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                    </svg>
                    <span class="mt-2 text-base text-center leading-normal" x-html="fileInfo"></span>
                    <input class="hidden" type="file" name="files[]" webkitdirectory multiple @change="updateFileInfo">
                </label>
            </div>
            
            <button class="btn bg-pink-400 border-bg-pink-400 hover:bg-pink-500 hover:border-bg-pink-500 text-white w-full rounded-full" type="submit">Deploy</button>
            
        </form>

    </div>

    <script>
        function fileUpload() {
            return {
                fileInfo: 'Upload project folder.<br/><small>The free version of TiinyHost has a limit of 3MB.</small>',
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
                }
            }
        }
    </script>
</body>

</html>