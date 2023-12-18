<?php
require_once "db.php";
session_start();
if (isset($_SESSION["ID"]) && getUser($conn, $_SESSION["ID"]))
{
	header("Location: tours.php");
	exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$name1=$_POST['name1'];
	$name2=$_POST['name2'];
	$name3=$_POST['name3'];
  $login = trim($_POST['login']);
  $password = trim($_POST['password']);
	$pasp = trim($_POST['pasp']);
  $status = 1;

	if ($password !== $pasp)
  {
    $err='<span style="color:red; margin:0px; font-size:13pt; width:450px;">Пароли не совпадают!</span>';
  }
  else
  {
    $sql = $conn->prepare("SELECT Login FROM Baza WHERE Login=:login");
    $sql->execute([":login" => $login]);
    $user = $sql->fetch();
    if (isset($user["ID"]))
    {
      $errLog='<span style="color:red; margin:0px; font-size:10pt; width:450px;"> Такой логин уже зарегистрирован. Пожалуйста, выберите другой логин.</span>';
    }
    else
    {
      $sql = $conn->prepare("INSERT INTO Baza (Familia, Name, Otch, Login, Password, status) VALUES (:familia, :name, :otch, :login, :password, :status)");

      if ($sql->execute([":familia" => $name1, ":name" => $name2, ":otch" => $name3, ":login" => $login, ":password" => $password, ":status" => $status]))
      {
			  $_SESSION['ID'] = $conn->lastInsertId();
        $_SESSION['status'] = $status;

        header("Location: cabinet.php");
        exit();
      }
      else
      {
        echo "Ошибка при регистрации: " . $stmt->error;
      }
    }
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
			const famInput = document.getElementById('name1');
			const ImInput = document.getElementById('name2');
			const OtchInput = document.getElementById('name3');
            const loginInput = document.getElementById('login');
            const passwordInput = document.getElementById('password');
			const paspInput = document.getElementById('pasp');

            const submitButton = document.querySelector('input[type="submit"]');

			famInput.addEventListener('blur', validateFam);
			ImInput.addEventListener('blur', validateIm);
			OtchInput.addEventListener('blur', validateOtch);
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
                } else if (loginValue.length < 4 || loginValue.length > 15) {
                    errorMessage.textContent = 'Длина логина должна быть от 4 до 15 символов.';
                } else {
                    errorMessage.textContent = '';
                }

                validateForm();
            }

            function validatePassword() {
                const passwordValue = passwordInput.value.trim();
                const errorMessage = document.getElementById('password-error');

                if (passwordValue === '') {
                    errorMessage.textContent = 'Пароль является обязательным полем.';
                } else if (passwordValue.length < 6 || passwordValue.length > 12) {
                    errorMessage.textContent = 'Длина пароля должна быть от 6 до 12 символов.';
                } else {
                    errorMessage.textContent = '';
                }

                validateForm();
            }


			 function validatePasp() {
				const passwordValue = passwordInput.value.trim();
                const paspValue = paspInput.value.trim();
                const errorMessage = document.getElementById('pasp-error');
				if (paspValue === '') {
                    errorMessage.textContent = 'Пароль является обязательным полем.';
                } else if (passwordValue !== paspValue) {
                    errorMessage.textContent = 'Пароли не совпадают';
                } else {
                    errorMessage.textContent = '';
                }

                validateForm();
            }


            function isValidlogin(login) {
                const loginRegex = '/^[a-z0-9-_]{2,20}$/i';
                return loginRegex.test(login);
            }

            validateForm();


			function validateFam() {
                const famValue = famInput.value.trim();
                const errorMessage = document.getElementById('fam-error');

                if (famValue === '') {
                    errorMessage.textContent = 'Фамилия является обязательным полем.';

				} else if (!/^[A-ЯЁа-яё]+$/.test(famValue)) {
                    errorMessage.textContent = 'Поле может содержать только кириллицу.';

                } else {
                    errorMessage.textContent = '';
                }

                validateForm();
            }

			function validateIm() {
                const imValue = ImInput.value.trim();
                const errorMessage = document.getElementById('im-error');

                if (imValue === '') {
                    errorMessage.textContent = 'Имя является обязательным полем.';

				} else if (!/^[A-ЯЁа-яё]+$/.test(imValue)) {
                    errorMessage.textContent = 'Поле может содержать только кириллицу.';

                } else {
                    errorMessage.textContent = '';
                }

                validateForm();
            }

			function validateOtch() {
                const otchValue = OtchInput.value.trim();
                const errorMessage = document.getElementById('otch-error');

                if (otchValue === '') {
                    errorMessage.textContent = 'Отчество является обязательным полем.';

				} else if (!/^[A-ЯЁа-яё]+$/.test(otchValue)) {
                    errorMessage.textContent = 'Поле может содержать только кириллицу.';

                } else {
                    errorMessage.textContent = '';
                }

                validateForm();
            }


        });
    </script>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<title>MOUNTAINS</title>
    <link rel="stylesheet" type="text/css" href="avtoriz.css">
  </head>
  <body>
  <form style="width:400px; padding:20px; border-radius:50px; "  method="POST" action="" name="reg" >
  <div class="imgcontainer">
    <a href="index.html"><img src="images/avto.jpg" alt="Avatar" class="avatar"></a>
  </div>

  <div class="container">
<p>
    <p class="o">Фамилия
<div id="fam-error" class="error-message"></div>
<input  type="text" name="name1" id = "name1" class="tb" required placeholder="Только кириллица">


<script>
document.getElementById('name1').onkeyup = function() {
	var reg= /[a-zA-Z0-9]/g;
	if (this.value.search(reg) != -1) {
	this.value = this.value.replace(reg, '');}
}
</script>
</p>
<br>
<p class="o">Имя
<div id="im-error" class="error-message"></div>
<input type="text" name="name2" id = "name2" class="tb" required placeholder="Только кириллица">
<script>
document.getElementById('name2').onkeyup = function() {
	var reg= /[a-zA-Z0-9]/g;
	if (this.value.search(reg) != -1) {
	this.value = this.value.replace(reg, '');}
}
</script>
</p><br>
<p class="o">Отчество
<div id="otch-error" class="error-message"></div>
<input type="text" name="name3" id="name3" class="tb" required placeholder="Только кириллица">
<script>
document.getElementById('name3').onkeyup = function() {
	var reg= /[a-zA-Z0-9]/g;
	if (this.value.search(reg) != -1) {
	this.value = this.value.replace(reg, '');}
}
</script>
</p><br>
<p class="o">Логин
<div id="login-error" class="error-message"></div>
<input type="text" name="login" id="login"  class="tb" required placeholder="Только латинские буквы и цифры">
<input name="vLog" class="vld"  readonly  >
<script>
document.getElementById('login').onkeyup = function() {
	var reg= /[а-яёЁА-Я]/g;
	if (this.value.search(reg) != -1) {
	this.value = this.value.replace(reg, '');}
}
</script>
</p><br>
<p class="o">Пароль
<div id="password-error" class="error-message"></div>

<input type="password" name="password" id="password"  class="tb" required placeholder="От 6 до 12 символов латинских букв и цифр" pattern="[a-zA-Z0-9]{4,10}">
<input  name="vPas" class="vld"  readonly >
</p>
<br>
<p class="o">Повтор пароля
<div id="pasp-error" class="error-message"></div>
<input type="password" name="pasp" id="pasp" class="tb" required >
<input  name="vPasp" class="vld"  readonly>
</p>
<?php
echo $err;
echo $errLog;
?>

<form action="checkbox-form.php" method="post">

  <p>Создавая учетную запись, вы соглашаетесь с нашим <a href="politika.html" style="color:dodgerblue">Условия и конфиденциальность</a>.</p>

<br>
<input style="border-radius:50px; "  type ="submit" value="Зарегистрироваться" class="k"></input><br><br>


</form>
<p>
	У вас уже есть аккаунт?

</p><br>
<input style="border-radius:50px; "  type = button onclick="document.location='login.php'" value="Войти" class="vhod"></input>
<script>
<?php

?>
</script>

  </div>
    </form>
</body>
</html>
