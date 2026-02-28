<?php
include_once('config.php');
session_start();

$texto = "";
$imagem = "./img/foto-padrao.jpg";
$caminho = "";
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $nome_arquivo = uniqid() . '.' . $ext;
    $caminho = "./img/" . $nome_arquivo;

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {




        $stmt = $conexao->prepare("UPDATE melhores SET img_perfil = ? WHERE nm_nome = ? LIMIT 1");
        $stmt->bind_param("ss", $caminho, $_SESSION['nome']);
        $stmt->execute();
        $stmt->close();

        $imagem = $caminho;
    }
}

if (isset($_FILES['imagem'])) {
    $stmt = $conexao->prepare("SELECT img_perfil FROM melhores WHERE nm_nome = ? LIMIT 1");
    $stmt->bind_param("s", $_SESSION['nome']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (!empty($row['img_perfil'])) {
            $imagem = $row['img_perfil'];
        }
    }
    $stmt->close();
}


if (isset($_POST['noe'])) {

    $_SESSION['nome'] = $_POST['nome'];

    $nome = $_SESSION['nome'];


    $pesquisa = "SELECT * FROM melhores WHERE nm_nome='$nome' ";
    $nomeprocurar = $conexao->query($pesquisa);
    if ($nome === "") {
        $texto = "<div class='erro'><p>Este nome já esta em uso</p></div>";
    } else if (mysqli_num_rows($nomeprocurar) >= 1) {
        $texto = "<div class='erro'><p>Este nome já esta em uso</p></div>";

    } else {

        $stmt = $conexao->prepare("INSERT INTO Melhores(nm_nome, img_perfil) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $imagem);
        $stmt->execute();

        $_SESSION['nome'] = $_POST['nome'];

        $nome = $_SESSION['nome'];
        $_SESSION['teste'] = 1;
        header('location:quiz.php');
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <style>
        body {
            align-items: center;
            justify-items: center;

            min-height: 100vh;
            background-color: #f4f4f9;

        }

        h1 {
            padding-top: 50px;
        }

        .nome {
            align-items: center;
            justify-items: center;
            margin-top: 30px;
        }

        label {
            font-size: 25px;
        }

        .foto {
            width: 160px;
            height: 1600px;

            border: 3px solid #000;
            border-radius: 50px;

        }

        input {
            border-radius: 10px !important;

        }


        .todo {
            width: 600px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            align-items: center;
        }


        .botao {
            display: block;
            width: 60%;
            margin: 12px 0;
            padding: 14px;
            font-size: 19px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            margin-right: auto;
            margin-left: auto;
        }

        .botao:hover {
            background-color: #2980b9;
        }

        .botao:active {
            background-color: #1f6391;
        }

        .foto-container {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .erro {
            width: 210px;
            height: 50px;
            background-color: #ff150095;
            border: 1px solid #a8200595;
            border-radius: 10px;
            align-items: center;
            text-align: center;
            justify-items: center;

            transition: all 0.9s ease !important;



        }

        .erro p {

            justify-items: center;
            display: block;
            background-color: #f8f8f800;
            margin-top: 10px;

        }

        img {
            width: 100%;
            height: 100%;
            border-radius: 50% !important;
        }

        .foto {
            border-radius: 100%;

            border: 2px solid #000000;
            transition: opacity 0.3s ease;

            width: 160px;
            height: 160px;


        }

        .foto-container:hover .foto {
            opacity: 0.7;
        }

        .overlay {
            position: absolute;
            top: 0px;
            left: 0;
            border-radius: 100%;

            border: 2px solid #000000;
            transition: opacity 0.3s ease;

            width: 160px;
            height: 160px;

            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .foto-container:hover .overlay {
            opacity: 1;
        }

        .overlay svg {
            font-size: 600px !important;
            color: white;

        }


        .overlay-label {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            border-radius: 50%;
        }

        #input-foto {
            display: none;
        }

        .erro {
            animation: animaçao 1.0s;
        }

        @keyframes animaçao {
            0% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }


        }

        @media (max-width: 500px) {


            label {
                font-size: 20px;
            }

            .foto {
                width: 100px !important;
                height: 100px !important;

                border: 3px solid #000;
                border-radius: 50px;

            }



            .todo {
                width: 75%;
                background: white;
                padding: 30px;
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                text-align: center;
                align-items: center;
            }






            .foto {
                border-radius: 100%;

                border: 2px solid #000000;
                transition: opacity 0.3s ease;

                width: 100px;
                height: 100px;


            }



            .overlay {
                position: absolute;
                top: 0px;
                left: 0;
                border-radius: 100%;

                border: 2px solid #000000;
                transition: opacity 0.3s ease;

                width: 100px;
                height: 100px;

                background-color: rgba(0, 0, 0, 0.5);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
                pointer-events: none;
            }




        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <h1>QUIZ</h1>
    <div class="card todo">
        <div class="perfil-container central ">
            <div class="foto-container">
                <img class="foto" id="foto-perfil" src="<?php echo htmlspecialchars($imagem); ?>" alt="Foto de perfil">

                <form action="" method="post" enctype="multipart/form-data" id="form-foto">

                    <label for="input-foto" class="overlay-label"></label>

                    <div class="overlay">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-pencil" viewBox="0 0 16 16">
                            <path
                                d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                        </svg>
                    </div>


                    <input type="file" name="imagem" id="input-foto" accept="image/*">

                </form>

            </div>
        </div>

        <div class="form-group nome">
            <form action="" method="post">
                <label>Digite seu Nome (não precisa ser o real)</label>
                <input class="form-control" name="nome" type="text" maxlength="20" required>
                <button name="noe" class="botao" type="submit">Começar</button>
            </form>
            <?php if ($texto != "") {
                echo $texto;
            } ?>
        </div>
    </div>
    </div>
    <script>   document.getElementById('input-foto').addEventListener('change', function () {
            if (this.files && this.files.length > 0) {
                document.getElementById('form-foto').submit();
            }
        });</script>

</body>

</html>
