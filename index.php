<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Care</title>
</head>
<body>
<main class="container">
    <div class="bg-light p-5 rounded mt-3">
        <h1>Teste Seleção Care - Importação XML</h1>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <input name="file" type="file" class="form-control" id="file">
                <label class="input-group-text" for="file">Upload</label>
            </div>
            <button class="btn btn-danger" type="submit">Enviar</button>
        </form>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
</body>
</html>