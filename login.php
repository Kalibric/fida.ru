<?php
require_once "db.php";
session_start(); // Инициализация сессии

if (isset($_SESSION["ID"]))
{
  header("Location: cabinet.php");
  exit();
}
// Обработка формы при отправке
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $login = trim($_POST['login']);
  $password = trim($_POST['password']);
  $sql = $conn->prepare("SELECT * FROM Baza WHERE Login=:login AND Password=:password LIMIT 1");
  $sql->execute([":login" => $login, ":password" => $password]);
  $user = $sql->fetch();

  if (isset($user["ID"]))
  {
    $_SESSION["ID"] = $user["ID"];
    $_SESSION["status"] = $user["Status"];
    header("Location: cabinet.php");
    exit();
  }
  else
  {
    $erVhod='<span style="color:red; margin:0px; font-size:10pt; width:450px;">Неверный логин или пароль!</span>';
  }
}
?>
<style>
				.tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: #fff;
            color: #000;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
			border: 1px solid #000;
        }

		.error-message {
            color: red;
            font-size: 12px;
				</style>
<script>
        document.addEventListener('DOMContentLoaded', function() {

            const loginInput = document.getElementById('login');
            const passwordInput = document.getElementById('password');
			const paspInput = document.getElementById('pasp');

            const submitButton = document.querySelector('input[type="submit"]');

            loginInput.addEventListener('blur', validateLogin);
            passwordInput.addEventListener('blur', validatePassword);
			paspInput.addEventListener('blur', validatePasp);




        function validateForm() {
        const errorMessages = document.getElementsByClassName('error-message');
        let hasErrors = false;

        for (let i = 0; i < errorMessages.length; i++) {
            if (errorMessages[i].textContent !== '') {
                hasErrors = true;
                break;
            }
        }

        if (hasErrors) {
            submitButton.setAttribute('disabled', 'disabled');
        } else {
            submitButton.removeAttribute('disabled');
        }
    }




            function validateLogin() {
                const loginValue = loginInput.value.trim();
                const errorMessage = document.getElementById('login-error');

                if (loginValue === '') {
                    errorMessage.textContent = 'Логин является обязательным полем.';
                }else {
                    errorMessage.textContent = '';
                }

                validateForm();
            }

            function validatePassword() {
                const passwordValue = passwordInput.value.trim();
                const errorMessage = document.getElementById('password-error');

                if (passwordValue === '') {
                    errorMessage.textContent = 'Пароль является обязательным полем.';
                } else {
                    errorMessage.textContent = '';
                }

                validateForm();
            }











        });
    </script>

 <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>MOUNTAIN</title>
    <link rel="stylesheet" type="text/css" href="avtoriz.css">
  </head>
  <body>




  <form style="width:400px; padding:20px; border-radius:50px;  " method="POST"  name="reg">
  <div class="imgcontainer">
	<a href="index.html"><img src="images/avto.jpg" alt="Avatar" class="avatar"></a>
  </div>

  <div class="container">
<p>

<p class="o">Логин
<div id="login-error" class="error-message"></div>
<input type="text" name="login" id="login" required class="tb" placeholder="Только латинские буквы и цифры">

</p><br>
<p class="o">Пароль
<div id="password-error" class="error-message"></div>
<input type="password" name="password" id="password" required class="tb" placeholder="Длина пароля от 6 до 12 символов">

</p>
<?php
echo $er;
echo $erVhod;
?>
<br><br><input style="border-radius:50px; " type="submit" value="Войти" OnClick="Proverka()"  class="vho"></input>
</div>




</form>
  </body>
  </html>
