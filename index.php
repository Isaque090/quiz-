<?php
include_once('config.php');
session_start();
   $_SESSION['teste']=0;
$texto = "";
$imagem = "./img/foto-padrao.jpg";

if (isset($_SESSION['foto'])) {
    $imagem = $_SESSION['foto'];
}


if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    $ext = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($ext, $permitidos)) {
        $nome_arquivo = uniqid() . '.' . $ext;
        $caminho = "./img/" . $nome_arquivo;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho)) {
           
            $_SESSION['foto'] = $caminho;
            $imagem = $caminho;
        } else {
            $texto = "<div class='erro'><p>Erro ao salvar a imagem no servidor</p></div>";
        }
    } else {
        $texto = "<div class='erro'><p>Apenas imagens JPG, JPEG, PNG ou GIF</p></div>";
    }
}


if (isset($_POST['noe'])) {
    $nome = $_POST['nome'];

  
   
        
        $pesquisa = $conexao->prepare("SELECT nm_nome FROM melhores WHERE nm_nome = ? LIMIT 1");
        $pesquisa->bind_param("s", $nome);
        $pesquisa->execute();
        $resultado = $pesquisa->get_result();

        if ($resultado->num_rows > 0) {
            $texto = "<div class='erro'><p>Este nome já está em uso</p></div>";
        } else {
           
            $salvar_foto = $_SESSION['foto'] ?? "./img/foto-padrao.jpg";

            $stmt = $conexao->prepare("INSERT INTO melhores (nm_nome, img_perfil) VALUES (?, ?)");
            $stmt->bind_param("ss", $nome, $salvar_foto);
if($stmt->execute()){
 $_SESSION['nome'] = $nome;
                $_SESSION['teste'] = 1;

            
                unset($_SESSION['foto']);

                header('Location: quiz.php');
                exit;
}
               
             
            $stmt->close();
        }
        $pesquisa->close();
    
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
         margin: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: #f4f4f9;
    color: #333;
    text-align: center;
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
             margin: 2rem auto;
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
.botao:disabled{
      background-color: #88b4d1;
      cursor:not-allowed;
}
.botao:disabled:hover{
      background-color: #88b4d1;
          cursor:not-allowed;
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

                border: 3px solid #000;}


            .todo {
                width: 85%;
              
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
main {
            flex: 1 0 auto;               
        }
     footer {
            background-color: black;
           
            width: 100%;
            margin-top: auto;
            padding: 1.5rem !important;
            flex-shrink: 0;
        }
           footer i:hover {
            text-shadow: 0px 0px 8px #ffffff;
            transition: transform 0.4s ease;
        }
           footer i {
           font-size:1.5rem;
        }
    </style>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
       <main>
    
           <div class="card todo"><div class="card-heder"><h1>QUIZ</div><div class="card-body ">
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
        </div></div>

        <div class="form-group nome">
            <form action="" method="post">
                <label>Digite seu Nome (não precisa ser o real)</label>
                <input class="form-control" name="nome" type="text" id="iiinput" maxlength="20" required>
                <button name="noe" id="botao" class="botao" type="submit">Começar</button>
            </form>
            <?php if ($texto != "") {
                echo $texto;
            } ?>
        </div>
    </div>
    </div>
       </main>
     



      <footer class="bg-dark text-white  ">
        <div class="container text-center" style="margin-top:-15px;">
            <h4 style="padding-top:20px;">Criado Por:</h4>
            <p style="margin-top:-6px;">Isaque Severo
                <a style="margin-left:5px;" href="https://github.com/Isaque090" target="_blank" class="text-white ">
                    <i class="bi bi-github fs-4 "></i>
                </a>
            </p>



        </div>
        <div class="text-center ">
            <small class="text-secondary ">&copy; 2026 Todos os direitos reservados.
            </small>
        </div>
    </footer>

    <script>
const botao =document.getElementById('botao');    

     
     $('#iiinput').on('keyup', function () {
             let nome = $(this).val();
             if (nome.length > 20) {
   botao.disabled = true;
    

        }
        else{
             botao.disabled = false;
        }
   
    
    });
    document.getElementById('input-foto').addEventListener('change', function () {
            if (this.files && this.files.length > 0) {
                document.getElementById('form-foto').submit();
            }
        });</script>

</body>

</html>
